<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Faker\Factory;
use App\Entity\Order;
use App\Entity\Customer;
use App\Entity\Franchise;

use App\Entity\TicketRow;
use App\Entity\FactureRow;

use App\Entity\OrderState;
use App\Entity\OrderNotice;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        //$faker = Factory::create('fr_FR');

        $factureRows = $this->doctrine->getRepository(FactureRow::class)->findAll();
        $ticketRows = $this->doctrine->getRepository(TicketRow::class)->findAll();
        
        $customers = $this->doctrine->getRepository(Customer::class)->findAll();
        $orderStateRepository = $this->doctrine->getRepository(OrderState::class);
        $orderNoticeRepository = $this->doctrine->getRepository(OrderNotice::class);
        
        $franchises = $this->doctrine->getRepository(Franchise::class)->findAll();
        $addresses = $this->doctrine->getRepository(Address::class)->findAll();
        for ($i = 0; $i < 30; ++$i) {
            $order = new Order();
            $order->setState($orderStateRepository->findOneBy(['name'=> 'en cours']));
            $order->setCustomer($customers[array_rand($customers)]);
            $order->setFranchise($franchises[array_rand($franchises)]);
            $order->setAddress($addresses[array_rand($addresses)]);
            $manager->persist($order);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CustomerFixtures::class,
            OrderStateFixtures::class,
           // TicketRowFixtures::class,
            //FactureRowFixtures::class,
        ];
    }
}
