<?php

namespace App\DataFixtures;

use App\Entity\OrderState;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderStateFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $state = new OrderState();
        $state->setName('en attente');
        $manager->persist($state);

        $state = new OrderState();
        $state->setName('en cours');
        $manager->persist($state);
        
        $state = new OrderState();
        $state->setName('terminée');
        $manager->persist($state);

        $manager->flush();
    }
}
