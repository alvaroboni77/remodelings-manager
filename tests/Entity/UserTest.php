<?php


namespace App\Tests\Entity;


use App\Entity\User;
use Faker\Factory as FakerFactoryAlias;
use Faker\Generator as FakerGeneratorAlias;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 * @package App\Tests\Entity
 * @coversDefaultClass \App\Entity\User
 */
class UserTest extends TestCase
{
    /**
     * @var User
     */
    protected static $user;

    /** @var FakerGeneratorAlias $faker */
    private static $faker;

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        self::$faker = FakerFactoryAlias::create('es_ES');
    }

    /**
     * Implement testConstructor().
     *
     * @covers ::__construct()
     * @return void
     */
    public function testConstructor(): void
    {
        $email = self::$faker->email;
        self::$user = new User();
        self::$user->setEmail($email);
        self::assertEquals(0, self::$user->getId());
        self::assertEquals($email, self::$user->getEmail());
    }

    /**
     * Implement testGetId().
     *
     * @covers ::getId
     * @return void
     */
    public function testGetId(): void
    {
        self::assertEmpty(self::$user->getId());
    }

    /**
     * Implements testGetSetEmail().
     *
     * @covers ::getEmail()
     * @covers ::setEmail()
     * @return void
     */
    public function testGetSetEmail(): void
    {
        $userEmail = self::$faker->email;
        self::$user->setEmail($userEmail);
        static::assertEquals(
            $userEmail,
            self::$user->getEmail()
        );
    }

    /**
     * Implements testGetSetName().
     *
     * @covers ::getName()
     * @covers ::setName()
     * @return void
     */
    public function testGetSetName(): void
    {
        $userName = self::$faker->name;
        self::$user->setName($userName);
        static::assertEquals(
            $userName,
            self::$user->getName()
        );
    }

    /**
     * Implements testGetSetPassword().
     *
     * @covers ::getPassword()
     * @covers ::setPassword()
     * @return void
     */
    public function testGetSetPassword(): void
    {
        $password = self::$faker->password;
        self::$user->setPassword($password);
        self::assertEquals(
            $password,
            self::$user->getPassword()
        );
    }

    /**
     * Implement testGetSetRoles().
     *
     * @covers ::getRoles()
     * @covers ::setRoles()
     * @return void
     */
    public function testGetSetRoles(): void
    {
        self::assertContains(
            'ROLE_USER',
            self::$user->getRoles()
        );
        $role = self::$faker->slug;
        self::$user->setRoles([ $role ]);
        self::assertContains(
            $role,
            self::$user->getRoles()
        );
    }

    /**
     * Implement testGetSalt().
     *
     * @covers ::getSalt()
     * @return void
     */
    public function testGetSalt(): void
    {
        self::assertNull(self::$user->getSalt());
    }
}