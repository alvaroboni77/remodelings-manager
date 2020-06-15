<?php


namespace App\Tests\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Faker\Factory as FakerFactoryAlias;
use Faker\Generator as FakerGeneratorAlias;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BuilderControllerTest
 * @package App\Tests\Controller
 * @coversDefaultClass \App\Controller\BuilderController
 */
class BuilderControllerTest extends WebTestCase
{
    const BUILDER_PATH = '/builder';
    const REGISTER_PATH = '/register';

//    /**
//     * @var User
//     */
//    protected static $user;

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
        $userRepository = self::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('testmail@mail.com');
        self::$client->loginUser($testUser);

        self::$client->request('GET', self::BUILDER_PATH.'/new');

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * Implements testCreateBuilderCreated
     * @return void
     * @covers ::create
     */
    public function testCreateBuilderCreated()
    {
        $userRepository = self::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('testmail@mail.com');
        self::$client->loginUser($testUser);

        $name = self::$faker->name;
        $email = self::$faker->email;
        $company = self::$faker->company;

        self::$client->request('GET', self::BUILDER_PATH.'/new');
        self::$client->submitForm('builder[Create]', [
            'builder[name]' => $name,
            'builder[email]' => $email,
            'builder[company]' => $company
        ], 'POST');

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertTrue($response->isRedirect(self::BUILDER_PATH.'/'));
    }
}