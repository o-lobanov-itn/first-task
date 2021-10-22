<?php

namespace App\Tests\Domain\ImportRule;

use App\Domain\ImportRule\CostFrom5OrStockFrom10Rule;
use App\Domain\ImportRule\CostLessOrEqual1000Rule;
use App\Entity\ProductData;
use PHPUnit\Framework\TestCase;

class CostLessOrEqual1000RuleTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testIsImportable(float $price, bool $isImportable): void
    {
        $productData = (new ProductData())
            ->setPrice($price)
        ;

        $rule = new CostLessOrEqual1000Rule();
        self::assertEquals($isImportable, $rule->isImportable($productData));
    }

    public function dataProvider(): array
    {
        /*
         * [price, isImportable]
         */
        return [
            [-1, true],
            [0, true],
            [1000, true],
            [1001, false],
            [1000.0001, false],
        ];
    }
}
