<?php

namespace App\DataFixtures;

use App\Entity\TicketRow;
use App\Entity\FactureRow;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Extra;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;



class TicketRowFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {   
        
        $orders = $this->doctrine->getRepository(Order::class)->findAll();
       
        $products = $manager->getRepository(Product::class)->findAll();
      
        $ticketRow = new TicketRow();
        $ticketRow->setProduct($products[array_rand($products)]);
        $ticketRow->setOrderFinal($orders[array_rand($orders)]);
        //$ticketRow->addExtra($extras[array_rand($extras)]);

        $manager->persist($ticketRow);

        $ticketRow = new TicketRow();
        $ticketRow->setProduct($products[array_rand($products)]);
        $ticketRow->setOrderFinal($orders[array_rand($orders)]);
        
        $manager->persist($ticketRow);

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
            CustomerFixtures::class,
            OrderFixtures::class,
           // ExtraFixtures::class,
        ];
    }
}
