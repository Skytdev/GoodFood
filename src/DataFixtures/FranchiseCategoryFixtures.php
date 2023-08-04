<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Franchise;
use App\Entity\MediaObject;
use App\Entity\FranchiseCategory;
use App\DataFixtures\MediaFixtures;
use App\DataFixtures\FranchiseFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class FranchiseCategoryFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $categoryNameList = [
            'Pizza',
            'Burger',
            'Tacos',
            'Japonais',
            'Asiatique',
            'Vegan',
            'Halal',
            'Oriental',
            'Sandwich'
        ];

        $franchises = $this->doctrine->getRepository(Franchise::class)->findAll();
        $queryBuilder = $this->doctrine->getRepository(MediaObject::class)->createQueryBuilder('m');
        $images = $queryBuilder->select('m')
            ->where("m.filePath like 'fCategory%'")
            ->getQuery()
            ->getResult();
        foreach ($categoryNameList as $key => $categoryName) {
            $category = new FranchiseCategory();
            $category->setName($categoryName);
            $category->addFranchise($franchises[array_rand($franchises)]);
            $category->image = $images[array_rand($images)];
            $manager->persist($category);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            FranchiseFixtures::class,
            MediaFixtures::class
        ];
    }
}
