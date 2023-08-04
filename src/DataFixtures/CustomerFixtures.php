<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomerFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $hasher;
    private ManagerRegistry $doctrine;

    public function __construct(UserPasswordHasherInterface $hasher, ManagerRegistry $doctrine)
    {
        $this->hasher = $hasher;
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $addresses = $this->doctrine->getRepository(Address::class)->findAll();

        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $user = new Customer();
            $password = $this->hasher->hashPassword($user, $faker->password(8, 14));

            $user->setEmail($faker->email());
            $user->setLastName($faker->lastname());
            $user->setFirstName($faker->firstname());
            $user->setPhone($faker->e164PhoneNumber());
            $user->setCivility($faker->title());
            $user->setBirthday($faker->dateTimeBetween('-60 years', '-18 years'));
            $user->setPassword($password);
            $user->addAddress($addresses[array_rand($addresses)]);
            $manager->persist($user);
        }

        // Fixe Customer
        $user = new Customer();

        $user->setEmail('customertest@gmail.com');
        $user->setLastName('lastname');
        $user->setFirstName('firstname');
        $user->setPhone($faker->e164PhoneNumber());
        $user->setCivility($faker->title());
        $user->setBirthday($faker->dateTimeBetween('-60 years', '-18 years'));
        $password = $this->hasher->hashPassword($user, 'password');
        $user->setPassword($password);
        $user->addAddress($addresses[array_rand($addresses)]);

        $manager->persist($user);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AddressFixtures::class,
        ];
    }
}
