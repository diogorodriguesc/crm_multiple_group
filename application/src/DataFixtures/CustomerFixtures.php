<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist(
            (new Customer())
                ->setName('John')
                ->setSurname('Doe')
                ->setBalance('0.00')
        );

        $manager->persist(
            (new Customer())
                ->setName('Melissa')
                ->setSurname('Frank')
                ->setBalance('0.00')
        );

        $manager->persist(
            (new Customer())
                ->setName('Richard')
                ->setSurname('Albert')
                ->setBalance('0.00')
        );
    }
}
