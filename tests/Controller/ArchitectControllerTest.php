<?php


namespace App\Tests\Controller;


use App\Entity\Architect;
use App\Repository\ArchitectRepository;
use Faker\Factory as FakerFactoryAlias;
use Faker\Generator as FakerGeneratorAlias;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ArchitectControllerTest
 * @package App\Tests\Controller
 * @coversDefaultClass \App\Controller\ArchitectController
 */
class ArchitectControllerTest extends WebTestCase
{
    const ARCHITECT_PATH = '/architect';
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
     * Implements testCreateView
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
     * @return Architect $architect
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

        self::$client->request('GET', self::ARCHITECT_PATH.'/new');
        self::$client->submitForm('architect[Create]', [
            'architect[name]' => $name,
            'architect[email]' => $email
        ], 'POST');

        self::bootKernel();
        $architect = self::$container->get(ArchitectRepository::class)->findOneByEmail($email);
        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertTrue($response->isRedirect(self::ARCHITECT_PATH.'/'));

        return $architect;
    }

    /**
     * Implements testEditArchitectUpdated
     * @param Architect $architect
     * @return void
     * @covers ::edit
     * @depends testCreateArchitectCreated
     */
    public function testEditArchitectUpdated(Architect $architect)
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'testmail@mail.com',
            'password' => '1234'
        ], 'POST');

        $id = $architect->getId();
        $email = self::$faker->email;
        self::$client->request('GET', self::ARCHITECT_PATH.'/edit/'.$id);
        self::$client->submitForm('architect[Update]', [
            'architect[name]' => $architect->getName(),
            'architect[email]' => $email
        ], 'POST');

        self::bootKernel();
        $editArchitect = self::$container->get(ArchitectRepository::class)->findOneById($id);
        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertTrue($response->isRedirect(self::ARCHITECT_PATH.'/'));
        self::assertSame($email, $editArchitect->getEmail());
    }

    /**
     * Implements testEditArchitectNotFound
     * @return void
     * @covers ::edit
     */
    public function testEditArchitectNotFound()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'testmail@mail.com',
            'password' => '1234'
        ], 'POST');

        self::bootKernel();
        $lastArchitect = self::$container->get(ArchitectRepository::class)->findOneBy([], ['id' => 'desc']);
        $lastId = $lastArchitect->getId();
        $id = $lastId + 1;
        self::$client->request('GET', self::ARCHITECT_PATH.'/edit/'.$id);

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * Implements testDeleteArchitectDeleted
     * @param Architect $architect
     * @return void
     * @covers ::delete
     * @depends testCreateArchitectCreated
     */
    public function testDeleteArchitectDeleted(Architect $architect)
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'testmail@mail.com',
            'password' => '1234'
        ], 'POST');

        $id = $architect->getId();
        self::$client->followRedirects(true);
        self::$client->request('POST', self::ARCHITECT_PATH.'/delete/'.$id);

        self::bootKernel();
        $architect = self::$container->get(ArchitectRepository::class)->findOneById($id);
        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertStringContainsString('Architect deleted', $response->getContent());
        self::assertNull($architect);
    }

    /**
     * Implements testDeleteArchitectNotFound
     * @return void
     * @covers ::edit
     */
    public function testDeleteArchitectNotFound()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'testmail@mail.com',
            'password' => '1234'
        ], 'POST');

        self::bootKernel();
        $lastArchitect = self::$container->get(ArchitectRepository::class)->findOneBy([], ['id' => 'desc']);
        $lastId = $lastArchitect->getId();
        $id = $lastId + 1;
        self::$client->request('GET', self::ARCHITECT_PATH.'/delete/'.$id);

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}