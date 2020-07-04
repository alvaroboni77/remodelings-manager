<?php


namespace App\Tests\Controller;


use App\Entity\Builder;
use App\Repository\BuilderRepository;
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

        self::$client->request('GET', self::BUILDER_PATH.'/');

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

        self::$client->request('GET', self::BUILDER_PATH.'/new');

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * Implements testCreateBuilderCreated
     * @return Builder $builder
     * @covers ::create
     */
    public function testCreateBuilderCreated()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        $name = self::$faker->name;
        $email = self::$faker->email;
        $company = self::$faker->company;

        self::$client->request('GET', self::BUILDER_PATH.'/new');
        self::$client->submitForm('builder[Create]', [
            'builder[name]' => $name,
            'builder[email]' => $email,
            'builder[company]' => $company
        ], 'POST');

        self::bootKernel();
        $builder = self::$container->get(BuilderRepository::class)->findOneByEmail($email);
        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertTrue($response->isRedirect(self::BUILDER_PATH.'/'));

        return $builder;
    }

    /**
     * Implements testEditBuilderUpdated
     * @param Builder $builder
     * @return void
     * @covers ::edit
     * @depends testCreateBuilderCreated
     */
    public function testEditBuilderUpdated(Builder $builder)
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        $id = $builder->getId();
        $email = self::$faker->email;
        self::$client->request('GET', self::BUILDER_PATH.'/edit/'.$id);
        self::$client->submitForm('builder[Update]', [
            'builder[name]' => $builder->getName(),
            'builder[email]' => $email,
            'builder[company]' => $builder->getCompany()
        ], 'POST');

        self::bootKernel();
        $editBuilder = self::$container->get(BuilderRepository::class)->findOneById($id);
        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertTrue($response->isRedirect(self::BUILDER_PATH.'/'));
        self::assertSame($email, $editBuilder->getEmail());
    }

    /**
     * Implements testEditBuilderNotFound
     * @return void
     * @covers ::edit
     */
    public function testEditBuilderNotFound()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        self::bootKernel();
        $lastBuilder = self::$container->get(BuilderRepository::class)->findOneBy([], ['id' => 'desc']);
        $lastId = $lastBuilder->getId();
        $id = $lastId + 1;
        self::$client->request('GET', self::BUILDER_PATH.'/edit/'.$id);

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * Implements testDeleteBuilderDeleted
     * @param Builder $builder
     * @return void
     * @covers ::delete
     * @depends testCreateBuilderCreated
     */
    public function testDeleteBuilderDeleted(Builder $builder)
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        $id = $builder->getId();
        self::$client->followRedirects(true);
        self::$client->request('POST', self::BUILDER_PATH.'/delete/'.$id);

        self::bootKernel();
        $builder = self::$container->get(BuilderRepository::class)->findOneById($id);
        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertStringContainsString('Builder deleted', $response->getContent());
        self::assertNull($builder);
    }

    /**
     * Implements testDeleteBuilderNotFound
     * @return void
     * @covers ::edit
     */
    public function testDeleteBuilderNotFound()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        self::bootKernel();
        $lastBuilder = self::$container->get(BuilderRepository::class)->findOneBy([], ['id' => 'desc']);
        $lastId = $lastBuilder->getId();
        $id = $lastId + 1;
        self::$client->request('GET', self::BUILDER_PATH.'/delete/'.$id);

        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}