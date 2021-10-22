<?php

namespace App\Domain\ImportRule;

use App\Entity\ProductData;

class CostLessOrEqual1000Rule implements ImportRuleInterface
{
    public function getDescription(): string
    {
        return 'Any stock items which cost over $1000 will not be imported.';
    }

    public function isImportable(ProductData $productData): bool
    {
        if ($productData->getPrice() <= 1000) {
            return true;
        }

        return false;
    }
}