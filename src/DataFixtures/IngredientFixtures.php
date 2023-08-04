<?php

namespace App\DataFixtures;

use App\Entity\Franchise;
use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use FakerArticle;

class IngredientFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $ingredientList = FakerArticle::$ingredientList;
        $franchise = $this->doctrine->getRepository(Franchise::class)->findAll();

        for ($k = 0; $k < count($franchise); ++$k) {
            for ($i = 0; $i < 5; ++$i) {
                for ($j = 0; $j < count($ingredientList); $j++) {
                    $ingredient = new Ingredient();
                    $ingredient->setName($ingredientList[$j]['name'] . '_' . $i);
                    $ingredient->setQuantity(random_int(0, 1000));
                    $ingredient->setUnit($ingredientList[$j]['unit']);
                    $ingredient->setStockMin(random_int(0, 50));
                    $ingredient->setFranchise($franchise[$k]);
                    $ingredient->setExtraPrice(random_int(0, 20) / 10);
                    $manager->persist($ingredient);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CityFixtures::class,
            AddressFixtures::class,
            FranchiseFixtures::class,
        ];
    }
}
