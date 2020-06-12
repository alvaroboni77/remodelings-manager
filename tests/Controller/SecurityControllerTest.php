<?php


namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Faker\Factory as FakerFactoryAlias;
use Faker\Generator as FakerGeneratorAlias;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SecurityControllerTest
 * @package App\Tests\Controller
 * @coversDefaultClass \App\Controller\SecurityController
 */
class SecurityControllerTest extends WebTestCase
{
    /**
     * @var User
     */
    protected static $usuario;

    /** @var FakerGeneratorAlias $faker */
    private static $faker;

    const LOGIN_PATH = '/login';
    const REGISTER_PATH = '/register';

    /**
     * @var KernelBrowser $client
     */
    private static $client;

    public static function setUpBeforeClass()
    {
        self::$usuario = new User();
        self::$faker = FakerFactoryAlias::create('es_ES');
        self::$client= static::createClient();
    }

    /**
     * Implements testRegisterCreateView
     * @return void
     * @throws Exception
     * @covers ::register
     */
    public function testRegisterCreateView()
    {
        self::$client->request('GET', self::REGISTER_PATH);

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * Implements testRegisterUserCreated
     * @return void
     * @covers ::register
     */
    public function testRegisterUserCreated()
    {
        $name = self::$faker->name;
        $email = self::$faker->email;
        $password = self::$faker->password;
        self::$usuario->setName($name);
        self::$usuario->setEmail($email);
        self::$usuario->setPassword($password);

        self::$client->request('GET', self::REGISTER_PATH);
        self::$client->submitForm('user[Registrar]', [
            'user[name]' => $name,
            'user[email]' => $email,
            'user[password][first]' => $password,
            'user[password][second]' => $password
        ], 'POST');

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertTrue($response->isRedirect('/'));
    }

    /**
     * Implements testRegisterEmailExists
     * @return void
     * @covers ::register
     */
    public function testRegisterEmailExists()
    {
        $name = self::$faker->name;
        $password = self::$faker->password;

        self::$client->request('GET', self::REGISTER_PATH);
        self::$client->submitForm('user[Registrar]', [
            'user[name]' => $name,
            'user[email]' => self::$usuario->getEmail(),
            'user[password][first]' => $password,
            'user[password][second]' => $password
        ], 'POST');

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertStringContainsString('Este valor ya se ha utilizado.', $response->getContent());
    }

    /**
     * Implements testLoginSuccessful
     * @return void
     * @covers ::login
     */
    public function testLoginSuccessful()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => self::$usuario->getEmail(),
            'password' => self::$usuario->getPassword()
        ], 'POST');

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertTrue($response->isRedirect('/'));
    }

    /**
     * Implements testLoginEmailNotExists
     * @return void
     * @covers ::login
     */
    public function testLoginEmailNotExists()
    {
        $email = self::$faker->email;

        self::$client->followRedirects(true);
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => $email,
            'password' => self::$usuario->getPassword()
        ], 'POST');

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertStringContainsString('Este email no existe', $response->getContent());
    }

    /**
     * Implements testLoginIncorrectPassword
     * @return void
     * @covers ::login
     */
    public function testLoginIncorrectPassword()
    {
        $password = self::$faker->password;

        self::$client->followRedirects(true);
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => self::$usuario->getEmail(),
            'password' => $password
        ], 'POST');

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertStringContainsString('La contraseña es incorrecta', $response->getContent());
    }
}