<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\FactureRow;
use App\Entity\Article;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FactureRowFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {        
        $orders = $this->doctrine->getRepository(Order::class)->findAll();
        $articles= $this->doctrine->getRepository(Article::class)->findAll();

            $factureRow = new FactureRow();
            $factureRow->setQuantity(random_int(1, 10));
            $factureRow->setArticle($articles[array_rand($articles)]);
            $factureRow->setPrice(random_int(1, 10));
            $factureRow->setOrderFinal($orders[array_rand($orders)]);

            $manager->persist($factureRow);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
            CustomerFixtures::class,
            OrderFixtures::class,
        ];
    }
}
