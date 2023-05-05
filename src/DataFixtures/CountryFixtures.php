<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $de = (new Country())
            ->setName('Germany')
            ->setCode('DE')
            ->setTaxNumberLength(11)
            ->setTax(19);
        $manager->persist($de);

        $it = (new Country())
            ->setName('Italy')
            ->setCode('IT')
            ->setTaxNumberLength(13)
            ->setTax(22);
        $manager->persist($it);

        $gr = (new Country())
            ->setName('Greece')
            ->setCode('GR')
            ->setTaxNumberLength(11)
            ->setTax(24);
        $manager->persist($gr);

        $manager->flush();
    }
}
