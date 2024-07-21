<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist(
            (new Customer())
                ->setUuid(Uuid::uuid4()->toString())
                ->setName('Steve')
                ->setTaxIdentificationNumber('123456789')
                ->setCountry(
                    $manager->getRepository(Country::class)->findOneBy(['name' => 'France'])
                )
        );

        $manager->persist(
            (new Customer())
                ->setUuid(Uuid::uuid4()->toString())
                ->setName('Diogo')
                ->setTaxIdentificationNumber('234567891')
                ->setCountry(
                    $manager->getRepository(Country::class)->findOneBy(['name' => 'Portugal'])
                )
        );

        $manager->flush();
    }
}
