<?php


namespace App\Tests\Controller;


use App\Entity\Remodeling;
use App\Repository\ArchitectRepository;
use App\Repository\BuilderRepository;
use App\Repository\TechnicalArchitectRepository;
use App\Repository\RemodelingRepository;
use Faker\Factory as FakerFactoryAlias;
use Faker\Generator as FakerGeneratorAlias;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RemodelingControllerTest
 * @package App\Tests\Controller
 * @coversDefaultClass \App\Controller\RemodelingController
 */
class RemodelingControllerTest extends WebTestCase
{
    const ARCHITECT_PATH = '/architect';
    const TECHNICAL_ARCHITECT_PATH = '/technical-architect';
    const REMODELING_PATH = '/remodeling';
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

        self::$client->request('GET', self::REMODELING_PATH.'/');

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

        self::$client->request('GET', self::REMODELING_PATH.'/new');

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * Implements testCreateRemodelingCreated
     * @return Remodeling $remodeling
     * @covers ::create
     */
    public function testCreateRemodelingCreated()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'testmail@mail.com',
            'password' => '1234'
        ], 'POST');

        $address = self::$faker->streetAddress;
        $city = self::$faker->city;
        $builtArea = self::$faker->numberBetween(30,300);
        $startDate = self::$faker->date('d-m-Y');
        $constructionTime = self::$faker->numberBetween(1,20);

        self::$client->request('GET', self::REMODELING_PATH.'/new');
        $crawler = new Crawler(self::$client->getResponse()->getContent(), 'http://localhost/remodeling/new');
        $type = $crawler->filter('select')->eq(0)->filter('option')->last()->text();
        $form = $crawler->selectButton('Crear')->form([
            'remodeling[type]' => $type,
            'remodeling[address]' => $address,
            'remodeling[city]' => $city,
            'remodeling[builtArea]' => $builtArea,
            'remodeling[startDate]' => $startDate,
            'remodeling[constructionTime]' => $constructionTime
        ]);

        $architectId = $crawler->filter('#remodeling_architect option')->last()->attr('value');
        $technicalArchitectId = $crawler->filter('#remodeling_technicalArchitect option')->last()->attr('value');
        $builderId = $crawler->filter('#remodeling_builder option')->last()->attr('value');

        $values = $form->getPhpValues();
        $values['remodeling']['architect'] = $architectId;
        $values['remodeling']['technicalArchitect'] = $technicalArchitectId;
        $values['remodeling']['builder'] = $builderId;

//        self::$client->request($form->getMethod(), $form->getUri(), $values);
        self::$client->submitForm($form, $values);

//        self::$client->submitForm('remodeling[Create]', [
//            'remodeling[type]' => $type,
//            'remodeling[address]' => $address,
//            'remodeling[city]' => $city,
//            'remodeling[builtArea]' => $builtArea,
//            'remodeling[startDate]' => $startDate,
//            'remodeling[constructionTime]' => $constructionTime,
//            'remodeling[architect]' => $idSelect,
//            'remodeling[technicalArchitect]' => $technicalArchitectId,
//            'remodeling[builder]' => $builderId
//        ], 'POST');

        self::bootKernel();
        $remodeling = self::$container->get(RemodelingRepository::class)->findOneBy(['address' => $address]);
        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        return $remodeling;
    }

}