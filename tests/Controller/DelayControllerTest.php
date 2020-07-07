<?php


namespace App\Tests\Controller;

use App\Entity\Delay;
use App\Repository\DelayRepository;
use App\Repository\RemodelingRepository;
use Faker\Factory as FakerFactoryAlias;
use Faker\Generator as FakerGeneratorAlias;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DelayControllerTest
 * @package App\Tests\Controller
 * @coversDefaultClass \App\Controller\DelayController
 */
class DelayControllerTest extends WebTestCase
{
    const DELAY_PATH = '/delay';
    const LOGIN_PATH = '/login';
    const REMODELING_PATH = '/remodeling';

    /**
     * @var KernelBrowser $client
     */
    private static $client;

    /** @var FakerGeneratorAlias $faker */
    private static $faker;

    public static function setUpBeforeClass():void
    {
        self::$faker = FakerFactoryAlias::create('es_ES');
        self::$client= static::createClient();
    }

    /**
     * Implements testCreateView
     * @return void
     * @covers ::create
     */
    public function testCreateView()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        self::$client->request('GET', self::DELAY_PATH.'/create');

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * Implements testCreateDelayCreated
     * @return Delay $delay
     * @covers ::create
     */
    public function testCreateDelayCreated()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        self::$client->request('GET', self::REMODELING_PATH.'/');
        $crawler = new Crawler(self::$client->getResponse()->getContent(), 'http://localhost/remodeling/');
        $remodelingId = $crawler->filter('tbody>tr>td')->first()->text();
        $note = self::$faker->sentence;
        $days = self::$faker->numberBetween(1, 30);

        self::$client->request('GET', self::DELAY_PATH.'/create?remodeling='.$remodelingId);
        self::$client->submitForm('delay[Create]', [
            'delay[note]' => $note,
            'delay[days]' => $days
        ], 'POST');

        self::bootKernel();
        $delay = self::$container->get(DelayRepository::class)->findOneByNote($note);
        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertTrue($response->isRedirect(self::REMODELING_PATH.'/'));
        self::assertStringContainsString($note, $delay->getNote());

        return $delay;
    }

    /**
     * Implements testCreateDelayNotFoundRemodeling
     * @return void
     * @covers ::create
     */
    public function testCreateDelayNotFoundRemodeling()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        self::bootKernel();
        $lastRemodeling = self::$container->get(RemodelingRepository::class)->findOneBy([], ['id' => 'desc']);
        $lastId = $lastRemodeling->getId();
        $id = $lastId + 1;
        $note = self::$faker->sentence;
        $days = self::$faker->numberBetween(1, 30);

        self::$client->request('GET', self::DELAY_PATH.'/create?remodeling='.$id);
        self::$client->submitForm('delay[Create]', [
            'delay[note]' => $note,
            'delay[days]' => $days
        ], 'POST');

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        self::assertStringContainsString('No remodeling found for id '.$id, $response->getContent());
    }

    /**
     * Implements testShowDelay
     * @param Delay $delay
     * @return void
     * @covers ::show
     * @depends testCreateDelayCreated
     */
    public function testShowDelay(Delay $delay)
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        $id = $delay->getId();
        self::$client->request('GET', self::DELAY_PATH.'/show/'.$id);

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * Implements testShowDelayNotFound
     * @return void
     * @covers ::show
     */
    public function testShowDelayNotFound()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        self::bootKernel();
        $lastDelay = self::$container->get(DelayRepository::class)->findOneBy([], ['id' => 'desc']);
        $lastId = $lastDelay->getId();
        $id = $lastId + 1;
        self::$client->request('GET', self::DELAY_PATH.'/show/'.$id);

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        self::assertStringContainsString('No delay found for id '.$id, $response->getContent());
    }
}