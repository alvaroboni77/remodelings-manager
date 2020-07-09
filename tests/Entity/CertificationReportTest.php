<?php


namespace App\Tests\Entity;


use App\Entity\CertificationReport;
use App\Entity\Remodeling;
use DateTime;
use Faker\Factory as FakerFactoryAlias;
use Faker\Generator as FakerGeneratorAlias;
use PHPUnit\Framework\TestCase;

/**
 * Class CertificationReportTest
 * @package App\Tests\Entity
 * @coversDefaultClass \App\Entity\CertificationReport
 */
class CertificationReportTest extends TestCase
{
    /**
     * @var CertificationReport
     */
    protected static $certificationReport;

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
        $checkOrder = self::$faker->numberBetween(1, 4);
        $finished = self::$faker->randomElement([true, false]);
        self::$certificationReport = new CertificationReport($checkOrder, $finished);
        self::assertEquals(0, self::$certificationReport->getId());
        self::assertEquals($checkOrder, self::$certificationReport->getCheckOrder());
        self::assertEquals($finished, self::$certificationReport->getFinished());
    }

    /**
     * Implement testGetId().
     *
     * @covers ::getId
     * @return void
     */
    public function testGetId(): void
    {
        self::assertEmpty(self::$certificationReport->getId());
    }

    /**
     * Implements testGetSetCheckOrder().
     *
     * @covers ::getCheckOrder()
     * @covers ::setCheckOrder()
     * @return void
     */
    public function testGetSetCheckOrder(): void
    {
        $checkOrder = self::$faker->numberBetween(1, 4);
        self::$certificationReport->setCheckOrder($checkOrder);
        static::assertEquals(
            $checkOrder,
            self::$certificationReport->getCheckOrder()
        );
    }

    /**
     * Implements testGetSetFinished().
     *
     * @covers ::getFinished()
     * @covers ::setFinished()
     * @return void
     */
    public function testGetSetFinished(): void
    {
        $finished = self::$faker->randomElement([true, false]);
        self::$certificationReport->setFinished($finished);
        static::assertEquals(
            $finished,
            self::$certificationReport->getFinished()
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
        $remodeling->setStartDate(new DateTime());
        $remodeling->setConstructionTime(self::$faker->numberBetween(1,20));

        self::$certificationReport->setRemodeling($remodeling);
        static::assertEquals(
            $remodeling,
            self::$certificationReport->getRemodeling()
        );
    }
}