<?php


namespace App\Tests\Entity;


use App\Entity\Delay;
use App\Entity\Remodeling;
use Faker\Factory as FakerFactoryAlias;
use Faker\Generator as FakerGeneratorAlias;
use PHPUnit\Framework\TestCase;

/**
 * Class DelayTest
 * @package App\Tests\Entity
 * @coversDefaultClass \App\Entity\Delay
 */
class DelayTest extends TestCase
{
    /**
     * @var Delay
     */
    protected static $delay;

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
        $note = self::$faker->sentence;
        self::$delay = new Delay();
        self::$delay->setNote($note);
        self::assertEquals(0, self::$delay->getId());
        self::assertEquals($note, self::$delay->getNote());
    }

    /**
     * Implement testGetId().
     *
     * @covers ::getId
     * @return void
     */
    public function testGetId(): void
    {
        self::assertEmpty(self::$delay->getId());
    }

    /**
     * Implements testGetSetNote().
     *
     * @covers ::getNote()
     * @covers ::setNote()
     * @return void
     */
    public function testGetSetNote(): void
    {
        $note = self::$faker->sentence;
        self::$delay->setNote($note);
        static::assertEquals(
            $note,
            self::$delay->getNote()
        );
    }

    /**
     * Implements testGetSetDays().
     *
     * @covers ::getDays()
     * @covers ::setDays()
     * @return void
     */
    public function testGetSetDays(): void
    {
        $days = self::$faker->numberBetween(1, 100);
        self::$delay->setDays($days);
        static::assertEquals(
            $days,
            self::$delay->getDays()
        );
    }

    /**
     * Implements testGetSetRemodeling().
     *
     * @covers ::getRemodeling()
     * @covers ::setRemodeling()
     * @return void
     * @throws \Exception
     */
    public function testGetSetRemodeling(): void
    {
        $remodeling = new Remodeling();
        $remodeling->setAddress(self::$faker->streetAddress);
        $remodeling->setCity(self::$faker->city);
        $remodeling->setBuiltArea(self::$faker->numberBetween(30,300));
        $remodeling->setStartDate(new \DateTime());
        $remodeling->setConstructionTime(self::$faker->numberBetween(1,20));

        self::$delay->setRemodeling($remodeling);
        static::assertEquals(
            $remodeling,
            self::$delay->getRemodeling()
        );
    }
}