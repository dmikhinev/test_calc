<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    /**
     * @dataProvider calculateProvider
     */
    public function testCalculate(array $products, string $taxNumber, int $responseCode, array $invalids, int $total, array $exceptions): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('select#cart_products');
        $this->assertSelectorExists('input#cart_tax_number');

        foreach ($exceptions as $exception) {
            $this->expectException($exception);
        }

        $crawler = $client->submitForm('cart_Calculate', [
            'cart[products]' => $products,
            'cart[tax_number]' => $taxNumber,
        ]);

        $this->assertResponseStatusCodeSame($responseCode);


        foreach ($invalids as $invalid) {
            $this->assertSelectorExists($invalid);
        }

        if ($total > 0) {
            $this->assertSelectorTextContains('span#total', $total);
        } else {
            $this->assertSelectorNotExists('span#total');
        }
    }

    public function calculateProvider()
    {
        return [
            'all empty' => [[], '', 422, ['select#cart_products.is-invalid', 'input#cart_tax_number.is-invalid'], 0, []],
            'invalid product' => [[10], 'GR123456789', 422, ['select#cart_products.is-invalid'], 0, [\InvalidArgumentException::class]],
            'tax number empty' => [[1, 2], '', 422, ['input#cart_tax_number.is-invalid'], 0, []],
            'tax number incorrect' => [[1], 'GR123456789o', 422, ['input#cart_tax_number.is-invalid'], 0, []],
            'GR earphones' => [[1], 'GR123456789', 200, [], 124, []],
        ];
    }
}
