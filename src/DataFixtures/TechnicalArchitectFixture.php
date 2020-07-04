<?php


namespace App\DataFixtures;


use App\Entity\TechnicalArchitect;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactoryAlias;
use Faker\Generator as FakerGeneratorAlias;

class TechnicalArchitectFixture extends Fixture
{
    /** @var FakerGeneratorAlias $faker */
    private static $faker;

    public function load(ObjectManager $manager)
    {
        self::$faker = FakerFactoryAlias::create('es_ES');

        for ($i = 0; $i < 20; $i++) {
            $technicalArchitect = new TechnicalArchitect();
            $technicalArchitect
                ->setName(self::$faker->name)
                ->setEmail(self::$faker->email);
            $manager->persist($technicalArchitect);
        }
        $manager->flush();
    }
}