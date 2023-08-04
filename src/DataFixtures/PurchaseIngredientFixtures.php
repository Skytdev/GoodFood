<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Purchase;
use App\Entity\PurchaseIngredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PurchaseIngredientFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $purchase = $this->doctrine->getRepository(Purchase::class)->findAll();
        $ingredient = $this->doctrine->getRepository(Ingredient::class)->findAll();

        $faker = Factory::create();
        
        for ($i = 0; $i < 5; $i++) {
            $purchaseIngredient = new PurchaseIngredient();
            $purchaseIngredient->setPurchase($purchase[array_rand($purchase)]);
            $purchaseIngredient->setIngredient($ingredient[array_rand($ingredient)]);
            $purchaseIngredient->setQte(1);
            $purchaseIngredient->setUnitPrice(1);

            $manager->persist($purchaseIngredient);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PurchaseFixtures::class,
            IngredientFixtures::class
        ];
    }
}