<?php

namespace App\DataFixtures;

use FakerArticle;
use App\Entity\Product;
use App\Entity\Franchise;
use App\Entity\Ingredient;
use App\Entity\MediaObject;
use App\Entity\ProductCategory;
use App\Entity\IngredientProduct;
use App\DataFixtures\MediaFixtures;
use App\DataFixtures\FranchiseFixtures;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\IngredientFixtures;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\ProductCategoryFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {

        $fakerProductList = FakerArticle::$productList;

        $franchises = $this->doctrine->getRepository(Franchise::class)->findAll();
        $productCategories = $this->doctrine->getRepository(ProductCategory::class)->findAll();
        
        $queryBuilder = $this->doctrine->getRepository(MediaObject::class)->createQueryBuilder('m');
        $images = $queryBuilder->select('m')
            ->where("m.filePath like 'product%'")
            ->getQuery()
            ->getResult();
        for ($i = 0; $i < count($franchises); ++$i) {
            for ($k = 0; $k < 3; ++$k) {
                for ($j = 0; $j < count($fakerProductList); $j++) {
                    $product = new Product();
                    $product->setName($fakerProductList[$j]['name'] . '_' . $k);
                    $product->setPrice(random_int(0, 20));
                    $product->setFranchise($franchises[$i]);
                    $product->image = $images[array_rand($images)];
                    $productCategoriesName = [];


                    foreach ($productCategories as $productCategory) {
                        if ($productCategory->getName() === $fakerProductList[$j]['productCategory']) {
                            array_push($productCategoriesName, $productCategory);
                        }
                    }


                    $product->addCategory($productCategoriesName[array_rand($productCategoriesName)]);


                    for ($l = 0; $l < count($fakerProductList[$j]['ingredientProduct']); $l++) {
                        $queryBuilder = $this->doctrine->getRepository(Ingredient::class)->createQueryBuilder('i');

                        $qb = $queryBuilder->select('i')
                            ->leftJoin('i.franchise', 'f')
                            ->where('i.name like :ingredientProduct')
                            ->setParameter('ingredientProduct', $fakerProductList[$j]['ingredientProduct'][$l] . '%')
                            ->andWhere('f.id = :franchise')
                            ->setParameter('franchise', $franchises[$i]->getId())
                            ->getQuery()
                            ->getResult();
                        $ingredientProduct = new IngredientProduct();

                        $ingredientProduct->setQuantity(random_int(0, 10));
                        $ingredientProduct->setIngredient($qb[array_rand($qb)]);
                        $ingredientProduct->setProduct($product);
                        $ingredientProduct->setIsExtra(1 === random_int(0, 1));
                        $ingredientProduct->setLimitQuantity(random_int(0, 10));
                        $manager->persist($ingredientProduct);

                        $product->addIngredientProduct($ingredientProduct);
                    }
                    $manager->persist($product);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductCategoryFixtures::class,
            IngredientFixtures::class,
            FranchiseFixtures::class,
            MediaFixtures::class
        ];
    }
}
