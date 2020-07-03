<?php


namespace App\Tests\Entity;


use App\Entity\TechnicalArchitect;
use Faker\Factory as FakerFactoryAlias;
use Faker\Generator as FakerGeneratorAlias;
use PHPUnit\Framework\TestCase;

/**
 * Class ArchitectTest
 * @package App\Tests\Entity
 * @coversDefaultClass \App\Entity\TechnicalArchitect
 */
class TechnicalArchitectTest extends TestCase
{
    /**
     * @var TechnicalArchitect
     */
    protected static $technical_architect;

    /** @var FakerGeneratorAlias $faker */
    private static $faker;

    /**
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
        self::$technical_architect = new TechnicalArchitect();
        self::$technical_architect->setEmail($email);
        self::assertEquals(0, self::$technical_architect->getId());
        self::assertEquals($email, self::$technical_architect->getEmail());
    }

    /**
     * Implement testGetId().
     *
     * @covers ::getId
     * @return void
     */
    public function testGetId(): void
    {
        self::assertEmpty(self::$technical_architect->getId());
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
        self::$technical_architect->setName($userName);
        static::assertEquals(
            $userName,
            self::$technical_architect->getName()
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
        self::$technical_architect->setEmail($userEmail);
        static::assertEquals(
            $userEmail,
            self::$technical_architect->getEmail()
        );
    }
}