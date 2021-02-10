<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use App\Repository\CityRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RestaurantFixtures extends Fixture implements DependentFixtureInterface
{
    private $cityRepository;

    public function __construct(CityRepository $cityRepository) {
        $this->cityRepository = $cityRepository;
    }
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {

            $city = $this->cityRepository->find( rand(1, 100) );

            $restaurant = new Restaurant;
            $restaurant->setName( $faker->company);
            $restaurant->setCity($city);
            $manager->persist($restaurant);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CityFixtures::class
        ];
    }
}
