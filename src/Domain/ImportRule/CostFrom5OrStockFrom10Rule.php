<?php

namespace App\Domain\ImportRule;

use App\Entity\ProductData;

class CostFrom5OrStockFrom10Rule implements ImportRuleInterface
{
    public function getDescription(): string
    {
        return 'Any stock item which costs less that $5 and has less than 10 stock will not be imported.';
    }

    public function isImportable(ProductData $productData): bool
    {
        if ($productData->getPrice() >= 5) {
            return true;
        }

        if ($productData->getStock() >= 10) {
            return true;
        }

        return false;
    }
}