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
            'email' => 'admin@mail.com',
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
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        self::$client->request('GET', self::ARCHITECT_PATH.'/new');

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * Implements testCreateTechnicalArchitectCreated
     * @return TechnicalArchitect $technical_architect
     * @covers ::create
     */
    public function testCreateTechnicalArchitectCreated()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
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

    /**
     * Implements testEditTechnicalArchitectUpdated
     * @param TechnicalArchitect $technical_architect
     * @return void
     * @covers ::edit
     * @depends testCreateTechnicalArchitectCreated
     */
    public function testEditTechnicalArchitectUpdated(TechnicalArchitect $technical_architect)
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        $id = $technical_architect->getId();
        $email = self::$faker->email;
        self::$client->request('GET', self::TECHNICAL_ARCHITECT_PATH.'/edit/'.$id);
        self::$client->submitForm('technical_architect[Update]', [
            'technical_architect[name]' => $technical_architect->getName(),
            'technical_architect[email]' => $email
        ], 'POST');

        self::bootKernel();
        $editTechnicalArchitect = self::$container->get(TechnicalArchitectRepository::class)->findOneById($id);
        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertTrue($response->isRedirect(self::ARCHITECT_PATH.'/'));
        self::assertSame($email, $editTechnicalArchitect->getEmail());
    }

    /**
     * Implements testEditTechnicalArchitectNotFound
     * @return void
     * @covers ::edit
     */
    public function testEditTechnicalArchitectNotFound()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        self::bootKernel();
        $lastTechnicalArchitect = self::$container->get(TechnicalArchitectRepository::class)->findOneBy([], ['id' => 'desc']);
        $lastId = $lastTechnicalArchitect->getId();
        $id = $lastId + 1;
        self::$client->request('GET', self::TECHNICAL_ARCHITECT_PATH.'/edit/'.$id);

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * Implements testDeleteTechnicalArchitectDeleted
     * @param TechnicalArchitect $technical_architect
     * @return void
     * @covers ::delete
     * @depends testCreateTechnicalArchitectCreated
     */
    public function testDeleteTechnicalArchitectDeleted(TechnicalArchitect $technical_architect)
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        $id = $technical_architect->getId();
        self::$client->followRedirects(true);
        self::$client->request('POST', self::TECHNICAL_ARCHITECT_PATH.'/delete/'.$id);

        self::bootKernel();
        $technical_architect = self::$container->get(TechnicalArchitectRepository::class)->findOneById($id);
        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertStringContainsString('Technical architect deleted', $response->getContent());
        self::assertNull($technical_architect);
    }

    /**
     * Implements testDeleteTechnicalArchitectNotFound
     * @return void
     * @covers ::edit
     */
    public function testDeleteTechnicalArchitectNotFound()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        self::bootKernel();
        $lastTechnicalArchitect = self::$container->get(TechnicalArchitectRepository::class)->findOneBy([], ['id' => 'desc']);
        $lastId = $lastTechnicalArchitect->getId();
        $id = $lastId + 1;
        self::$client->request('GET', self::TECHNICAL_ARCHITECT_PATH.'/delete/'.$id);

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}