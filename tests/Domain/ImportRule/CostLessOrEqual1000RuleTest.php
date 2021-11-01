<?php

namespace App\Tests\Domain\ImportRule;

use App\Domain\Import\Rules\CostLessOrEqual1000Rule;
use App\Entity\ProductData;
use App\Exception\Import\RuleCheckingException;
use PHPUnit\Framework\TestCase;

class CostLessOrEqual1000RuleTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testCheck(float $price, bool $isImportable): void
    {
        $productData = (new ProductData())
            ->setPrice($price)
        ;

        $rule = new CostLessOrEqual1000Rule();

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
