<?php


namespace App\Tests\Controller;


use App\Entity\TechnicalArchitect;
use App\Repository\TechnicalArchitectRepository;
use Faker\Factory as FakerFactoryAlias;
use Faker\Generator as FakerGeneratorAlias;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TechnicalArchitectControllerTest
 * @package App\Tests\Controller
 * @coversDefaultClass \App\Controller\TechnicalArquitectController
 */
class TechnicalArchitectControllerTest extends WebTestCase
{
    const ARCHITECT_PATH = '/architect';
    const TECHNICAL_ARCHITECT_PATH = '/technical-architect';
    const LOGIN_PATH = '/login';

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
     * Implements testListView
     * @return void
     * @covers ::list
     */
    public function testListView()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'testmail@mail.com',
            'password' => '1234'
        ], 'POST');

        self::$client->request('GET', self::ARCHITECT_PATH.'/');

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
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
            'email' => 'testmail@mail.com',
            'password' => '1234'
        ], 'POST');

        self::$client->request('GET', self::ARCHITECT_PATH.'/new');

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * Implements testCreateArchitectCreated
     * @return TechnicalArchitect $technical_architect
     * @covers ::create
     */
    public function testCreateArchitectCreated()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'testmail@mail.com',
            'password' => '1234'
        ], 'POST');

        $name = self::$faker->name;
        $email = self::$faker->email;

        self::$client->request('GET', self::TECHNICAL_ARCHITECT_PATH.'/new');
        self::$client->submitForm('technical_architect[Create]', [
            'technical_architect[name]' => $name,
            'technical_architect[email]' => $email
        ], 'POST');

        self::bootKernel();
        $technical_architect = self::$container->get(TechnicalArchitectRepository::class)->findOneByEmail($email);
        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertTrue($response->isRedirect(self::ARCHITECT_PATH.'/'));

        return $technical_architect;
    }
}