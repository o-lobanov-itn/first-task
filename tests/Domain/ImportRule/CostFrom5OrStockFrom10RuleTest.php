<?php

namespace App\Tests\Domain\ImportRule;

use App\Domain\ImportRule\CostFrom5OrStockFrom10Rule;
use App\Entity\ProductData;
use PHPUnit\Framework\TestCase;

class CostFrom5OrStockFrom10RuleTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testIsImportable(int $stock, float $price, bool $isImportable): void
    {
        $productData = (new ProductData())
            ->setStock($stock)
            ->setPrice($price)
        ;

        $rule = new CostFrom5OrStockFrom10Rule();
        self::assertEquals($isImportable, $rule->isImportable($productData));
    }

    public function dataProvider(): array
    {
        /*
         * [stock, price, isImportable]
         */
        return [
            [9, 4, false], // 9 < 10 and 4 < 5
            [10, 4, true], // 10 == 10
            [9, 5, true], // 5 == 5
        ];
    }
}
