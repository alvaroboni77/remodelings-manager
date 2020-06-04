<?php


namespace App\Tests\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RegistrationControllerTest
 * @package App\Tests\Controller
 * @coversDefaultClass \App\Controller\RegistrationController
 */
class RegistrationControllerTest extends WebTestCase
{
    const REGISTER_PATH = '/register';
    /**
     * @var KernelBrowser $client
     */
    private static $client;

    public static function setUpBeforeClass()
    {
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
     * @return string
     * @throws Exception
     * @covers ::register
     */
    public function testRegisterUserCreated()
    {
        $randomNum = random_int(1,200);
        $name = 'NuevoNombre' .$randomNum;
        $password= 'pass' .$randomNum;
        $email= 'nuevoEmail' .$randomNum. '@example.com';

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

        return $email;
    }

    /**
     * Implements testRegisterEmailExists
     * @param  string $email email returned by testRegisterUserCreated()
     * @return void
     * @throws Exception
     * @covers ::register
     * @depends testRegisterUserCreated
     */
    public function testRegisterEmailExists($email)
    {
        $randomNum = random_int(1,200);
        $name = 'NuevoNombre' .$randomNum;
        $password= 'pass' .$randomNum;

        self::$client->request('GET', self::REGISTER_PATH);
        self::$client->submitForm('user[Registrar]', [
            'user[name]' => $name,
            'user[email]' => $email,
            'user[password][first]' => $password,
            'user[password][second]' => $password
        ], 'POST');

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertStringContainsString('Este valor ya se ha utilizado.', $response->getContent());
    }
}