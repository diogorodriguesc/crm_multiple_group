<?php
declare(strict_types=1);

namespace App\Tests\Functional\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class AppFixtures extends Fixture implements Loader
{
    public function load(ObjectManager $manager): void
    {
        $country = new Country();

        $country
            ->setName('France')
            ->setCountryCode('FR')
            ->setUuid(Uuid::uuid4()->toString());

        $manager->persist($country);

        $manager->flush();
    }
}
