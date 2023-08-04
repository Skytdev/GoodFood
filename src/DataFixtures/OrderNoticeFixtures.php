<?php

namespace App\DataFixtures;

use App\Entity\Order;

use App\Entity\OrderNotice;
use App\DataFixtures\OrderFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;



class OrderNoticeFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {        
        $orders = $this->doctrine->getRepository(Order::class)->findAll();
        
        foreach ($orders as $key => $order) {
            if (random_int(0, 1)) {
                $orderNotice = new OrderNotice();
                $orderNotice->setCustomer($order->getCustomer());
                $orderNotice->setOrderfield($order);
                $orderNotice->setScore(random_int(1, 10));
                $manager->persist($orderNotice);
            }
        }

           
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            OrderFixtures::class,
        ];
    }
}
