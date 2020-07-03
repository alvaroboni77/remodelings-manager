<?php


namespace App\Tests\Entity;


use App\Entity\Architect;
use Faker\Factory as FakerFactoryAlias;
use Faker\Generator as FakerGeneratorAlias;
use PHPUnit\Framework\TestCase;

/**
 * Class ArchitectTest
 * @package App\Tests\Entity
 * @coversDefaultClass \App\Entity\Architect
 */
class ArchitectTest extends TestCase
{
    /**
     * @var Architect
     */
    protected static $architect;

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
        self::$architect = new Architect();
        self::$architect->setEmail($email);
        self::assertEquals(0, self::$architect->getId());
        self::assertEquals($email, self::$architect->getEmail());
    }

    /**
     * Implement testGetId().
     *
     * @covers ::getId
     * @return void
     */
    public function testGetId(): void
    {
        self::assertEmpty(self::$architect->getId());
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
        self::$architect->setName($userName);
        static::assertEquals(
            $userName,
            self::$architect->getName()
        );
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
        self::$architect->setEmail($userEmail);
        static::assertEquals(
            $userEmail,
            self::$architect->getEmail()
        );
    }
}