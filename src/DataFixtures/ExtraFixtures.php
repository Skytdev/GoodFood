<?php

namespace App\DataFixtures;


use App\Entity\Ingredient;
use App\Entity\Extra;
use App\Entity\TicketRow;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ExtraFixtures extends Fixture implements DependentFixtureInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {

        $ingredients = $this->doctrine->getRepository(Ingredient::class)->findAll();
        $tickets = $this->doctrine->getRepository(TicketRow::class)->findAll();

        $faker = Factory::create();
       
        for ($i = 0; $i < 10 ;$i++) {
            $extra = new Extra();
            $extra->setQuantity($faker->randomDigit());
            $extra->setIngredient($ingredients[array_rand($ingredients)]);
            $extra->setTicketRow($tickets[array_rand($tickets)]);

            $manager->persist($extra);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            IngredientFixtures::class,
            TicketRowFixtures::class
        ];
    }
}
