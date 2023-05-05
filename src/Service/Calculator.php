<?php

namespace App\Service;

use App\Entity\Country;
use App\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;

class Calculator
{
    /**
     * @param Country $country
     * @param ArrayCollection|Product[] $products
     * @return float
     */
    public function calculate(Country $country, ArrayCollection $products): float
    {
        return (1 + $country->getTax() / 100)
            * $products->reduce(
                fn(float $total, Product $product): float => $total + $product->getPrice(),
                0
            );
    }
}
