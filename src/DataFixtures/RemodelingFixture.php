<?php


namespace App\DataFixtures;


use App\Entity\Architect;
use App\Entity\Builder;
use App\Entity\Remodeling;
use App\Entity\TechnicalArchitect;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactoryAlias;
use Faker\Generator as FakerGeneratorAlias;

class RemodelingFixture extends Fixture
{
    /** @var FakerGeneratorAlias $faker */
    private static $faker;

    public function load(ObjectManager $manager)
    {
        self::$faker = FakerFactoryAlias::create('es_ES');

        $builder = new Builder();
        $builder->setName(self::$faker->name)->setEmail(self::$faker->email)->setCompany(self::$faker->company);
        $architect = new Architect();
        $technicalArchitect = new TechnicalArchitect();

        for ($i = 0; $i < 10; $i++) {
            $remodeling = new Remodeling();
            $remodeling
                ->setAddress(self::$faker->streetAddress)
                ->setConstructionTime(self::$faker->numberBetween(2,20))
                ->setStartDate(new DateTime())
                ->setBuiltArea(self::$faker->numberBetween(10,400))
                ->setType(self::$faker->randomElement(['4x25', '15/30/40/15']))
                ->setBuilder($builder)
                ->setArchitect($architect->setName(self::$faker->name)->setEmail(self::$faker->email))
                ->setTechnicalArchitect($technicalArchitect->setName(self::$faker->name)->setEmail(self::$faker->email))
                ->setCity(self::$faker->city);
            $manager->persist($remodeling);
        }
        $manager->flush();
    }
}