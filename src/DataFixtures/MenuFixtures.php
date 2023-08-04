<?php

namespace App\DataFixtures;

use FakerArticle;
use Faker\Factory;
use App\Entity\City;
use App\Entity\Menu;
use App\Entity\Address;
use App\Entity\Article;
use App\Entity\Product;
use App\Entity\Franchise;
use App\Entity\Ingredient;
use App\Entity\MediaObject;
use Doctrine\ORM\EntityManager;
use App\Entity\IngredientProduct;
use App\DataFixtures\MediaFixtures;
use App\DataFixtures\ProductFixtures;
use App\DataFixtures\FranchiseFixtures;
use Doctrine\Persistence\ObjectManager;
use function PHPUnit\Framework\isEmpty;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MenuFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $fakerMenuList = FakerArticle::$menuList;

        $franchise = $this->doctrine->getRepository(Franchise::class)->findAll();

        $queryBuilder = $this->doctrine->getRepository(MediaObject::class)->createQueryBuilder('m');
        $images = $queryBuilder->select('m')
            ->where("m.filePath like 'menu%'")
            ->getQuery()
            ->getResult();

        for ($i = 0; $i < count($franchise); ++$i) {
            for ($k = 0; $k < 5; ++$k) {
                for ($j = 0; $j < count($fakerMenuList); $j++) {
                    $menu = new Menu();
                    $menu->setName($fakerMenuList[$j]['name'] . '_' . $k);
                    $menu->setPrice(random_int(0, 20));
                    $menu->setFranchise($franchise[$i]);
                    $menu->image = $images[array_rand($images)];
                    for ($l = 0; $l < count($fakerMenuList[$j]['productMenu']); $l++) {
                        $queryBuilder = $this->doctrine->getRepository(Product::class)->createQueryBuilder('p');

                        $qb = $queryBuilder->select('p')
                            ->leftJoin('p.franchise', 'f')
                            ->where('p.name like :productName')
                            ->setParameter('productName', $fakerMenuList[$j]['productMenu'][$l] . '%')
                            ->andWhere('f.id = :franchise')
                            ->setParameter('franchise', $franchise[$i]->getId())
                            ->getQuery()
                            ->getResult();

                        $random = random_int(1, 5);
                        for ($r = 0; $r < $random; ++$r) {
                            $menu->addProduct($qb[array_rand($qb)]);
                        }
                    }
                    $manager->persist($menu);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            FranchiseFixtures::class,
            ProductFixtures::class,
            MediaFixtures::class
        ];
    }
}
