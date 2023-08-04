<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\City;
use App\Entity\Address;
use App\Entity\Franchise;
use App\Entity\MediaObject;
use App\DataFixtures\MediaFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class FranchiseFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $cities = $this->doctrine->getRepository(City::class)->findAll();
        $addresses = $this->doctrine->getRepository(Address::class)->findAll();
        $queryBuilder = $this->doctrine->getRepository(MediaObject::class)->createQueryBuilder('m');
        $images = $queryBuilder->select('m')
            ->where("m.filePath like 'franchise%'")
            ->getQuery()
            ->getResult();
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 50; ++$i) {
            $franchise = new Franchise();
            $franchise->setAddress($addresses[array_rand($addresses)]);
            $franchise->setName($faker->name);
            for ($j = 0; $j < random_int(1, 15); ++$j) {
                $franchise->addCitiesDelivery($cities[array_rand($cities)]);
            }
            $franchise->setCostDelivery(random_int(1, 10));
            $franchise->image = $images[array_rand($images)];
            $manager->persist($franchise);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CityFixtures::class,
            AddressFixtures::class,
            MediaFixtures::class
        ];
    }
}
