<?php

namespace App\Tests\Domain\ImportRule;

use App\Domain\Import\Rules\CostFrom5OrStockFrom10Rule;
use App\Entity\ProductData;
use App\Exception\Import\RuleCheckingException;
use PHPUnit\Framework\TestCase;

class CostFrom5OrStockFrom10RuleTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testCheck(int $stock, float $price, bool $isImportable): void
    {
        $productData = (new ProductData())
            ->setStock($stock)
            ->setPrice($price)
        ;

        $rule = new CostFrom5OrStockFrom10Rule();

        if (false === $isImportable) {
            $this->expectException(RuleCheckingException::class);
        } else {
            $this->expectNotToPerformAssertions();
        }

        $rule->check($productData);
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
