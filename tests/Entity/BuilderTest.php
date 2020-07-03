<?php


namespace App\Tests\Entity;

use App\Entity\Builder;
use Faker\Factory as FakerFactoryAlias;
use Faker\Generator as FakerGeneratorAlias;
use PHPUnit\Framework\TestCase;

/**
 * Class BuilderTest
 * @package App\Tests\Entity
 * @coversDefaultClass \App\Entity\Builder
 */
class BuilderTest extends TestCase
{
    /**
     * @var Builder
     */
    protected static $builder;

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
        self::$builder = new Builder();
        self::$builder->setEmail($email);
        self::assertEquals(0, self::$builder->getId());
        self::assertEquals($email, self::$builder->getEmail());
    }

    /**
     * Implement testGetId().
     *
     * @covers ::getId
     * @return void
     */
    public function testGetId(): void
    {
        self::assertEmpty(self::$builder->getId());
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
        self::$builder->setName($userName);
        static::assertEquals(
            $userName,
            self::$builder->getName()
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
        self::$builder->setEmail($userEmail);
        static::assertEquals(
            $userEmail,
            self::$builder->getEmail()
        );
    }

    /**
     * Implements testGetSetCompany().
     *
     * @covers ::getCompany()
     * @covers ::setCompany()
     * @return void
     */
    public function testGetSetCompany(): void
    {
        $userEmail = self::$faker->company;
        self::$builder->setCompany($userEmail);
        static::assertEquals(
            $userEmail,
            self::$builder->getCompany()
        );
    }
}