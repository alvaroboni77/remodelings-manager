<?php


namespace App\Tests\Entity;

use App\Entity\Architect;
use App\Entity\Builder;
use App\Entity\Remodeling;
use App\Entity\TechnicalArchitect;
use Exception;
use Faker\Factory as FakerFactoryAlias;
use Faker\Generator as FakerGeneratorAlias;
use PHPUnit\Framework\TestCase;

/**
 * Class RemodelingTest
 * @package App\Tests\Entity
 * @coversDefaultClass \App\Entity\Remodeling
 */
class RemodelingTest extends TestCase
{
    /**
     * @var Remodeling
     */
    protected static $remodeling;

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
        $address = self::$faker->address;
        self::$remodeling = new Remodeling();
        self::$remodeling->setAddress($address);
        self::assertEquals(0, self::$remodeling->getId());
        self::assertEquals($address, self::$remodeling->getAddress());
    }

    /**
     * Implement testGetId().
     *
     * @covers ::getId
     * @return void
     */
    public function testGetId(): void
    {
        self::assertEmpty(self::$remodeling->getId());
    }

    /**
     * Implements testGetSetAddress().
     *
     * @covers ::getAddress()
     * @covers ::setAddress()
     * @return void
     */
    public function testGetSetAddress(): void
    {
        $address = self::$faker->address;
        self::$remodeling->setAddress($address);
        static::assertEquals(
            $address,
            self::$remodeling->getAddress()
        );
    }

    /**
     * Implements testGetSetCity().
     *
     * @covers ::getCity()
     * @covers ::setCity()
     * @return void
     */
    public function testGetSetCity(): void
    {
        $city = self::$faker->city;
        self::$remodeling->setCity($city);
        static::assertEquals(
            $city,
            self::$remodeling->getCity()
        );
    }

    /**
     * Implements testGetSetBuiltArea().
     *
     * @covers ::getBuiltArea()
     * @covers ::setBuiltArea()
     * @return void
     */
    public function testGetSetBuiltArea(): void
    {
        $builtArea = self::$faker->numberBetween(20, 1000);
        self::$remodeling->setBuiltArea($builtArea);
        static::assertEquals(
            $builtArea,
            self::$remodeling->getBuiltArea()
        );
    }

    /**
     * Implements testGetSetStartDate().
     *
     * @covers ::getStartDate()
     * @covers ::setStartDate()
     * @return void
     * @throws Exception
     */
    public function testGetSetStartDate(): void
    {
        $startDate = new \DateTime();
        self::$remodeling->setStartDate($startDate);
        static::assertEquals(
            $startDate,
            self::$remodeling->getStartDate()
        );
    }

    /**
     * Implements testGetSetConstructionTime().
     *
     * @covers ::getConstructionTime()
     * @covers ::setConstructionTime()
     * @return void
     */
    public function testGetSetConstructionTime(): void
    {
        $constructionTime = self::$faker->numberBetween(1, 100);
        self::$remodeling->setConstructionTime($constructionTime);
        static::assertEquals(
            $constructionTime,
            self::$remodeling->getConstructionTime()
        );
    }

    /**
     * Implements testGetSetType().
     *
     * @covers ::getType()
     * @covers ::setType()
     * @return void
     */
    public function testGetSetType(): void
    {
        $type = '15x30x40x15';
        self::$remodeling->setType($type);
        static::assertEquals(
            $type,
            self::$remodeling->getType()
        );
    }

    /**
     * Implements testGetSetBuilder().
     *
     * @covers ::getBuilder()
     * @covers ::setBuilder()
     * @return void
     */
    public function testGetSetBuilder(): void
    {
        $builder = new Builder();
        $builder->setName(self::$faker->name);
        $builder->setEmail(self::$faker->email);
        $builder->setCompany(self::$faker->company);

        self::$remodeling->setBuilder($builder);
        static::assertEquals(
            $builder,
            self::$remodeling->getBuilder()
        );
    }

    /**
     * Implements testGetSetArchitect().
     *
     * @covers ::getArchitect()
     * @covers ::setArchitect()
     * @return void
     */
    public function testGetSetArchitect(): void
    {
        $architect = new Architect();
        $architect->setName(self::$faker->name);
        $architect->setEmail(self::$faker->email);

        self::$remodeling->setArchitect($architect);
        static::assertEquals(
            $architect,
            self::$remodeling->getArchitect()
        );
    }

    /**
     * Implements testGetSetTechnicalArchitect().
     *
     * @covers ::getTechnicalArchitect()
     * @covers ::setTechnicalArchitect()
     * @return void
     */
    public function testGetSetTechnicalArchitect(): void
    {
        $technicalArchitect = new TechnicalArchitect();
        $technicalArchitect->setName(self::$faker->name);
        $technicalArchitect->setEmail(self::$faker->email);

        self::$remodeling->setTechnicalArchitect($technicalArchitect);
        static::assertEquals(
            $technicalArchitect,
            self::$remodeling->getTechnicalArchitect()
        );
    }
}