<?php

namespace App\Domain\Import\Rules;

use App\Entity\ProductData;
use App\Exception\Import\RuleCheckingException;

class CostFrom5OrStockFrom10Rule implements RuleInterface
{
    /**
     * @throws RuleCheckingException
     */
    public function check(ProductData $productData): void
    {
        if ($productData->getPrice() < 5 && $productData->getStock() < 10) {
            throw new RuleCheckingException('Any stock item which costs less that $5 and has less than 10 stock will not be imported.');
        }
    }
}
