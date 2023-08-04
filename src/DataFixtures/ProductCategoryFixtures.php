<?php

namespace App\DataFixtures;

use App\Entity\Franchise;
use App\Entity\ProductCategory;
use App\DataFixtures\FranchiseFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductCategoryFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    public function load(ObjectManager $manager): void
    {
        $productCategoryNameList = \FakerArticle::$productCategoryNameList;
        $franchises = $this->doctrine->getRepository(Franchise::class)->findAll();

        for ($i=0; $i < count($productCategoryNameList); $i++) { 
            $productCategory = new productCategory();
            $productCategory->setName($productCategoryNameList[$i]);
            $productCategory->addFranchise($franchises[array_rand($franchises)]);
            $manager->persist($productCategory);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            FranchiseFixtures::class,
        ];
    }
}
