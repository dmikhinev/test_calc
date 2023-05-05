<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product1 = (new Product())
            ->setName('earphones')
            ->setPrice(100);
        $manager->persist($product1);

        $product2 = (new Product())
            ->setName('phone case')
            ->setPrice(20);
        $manager->persist($product2);

        $manager->flush();
    }
}
