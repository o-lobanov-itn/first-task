<?php

namespace App\Domain\Import\Rules;

use App\Entity\ProductData;

class CostLessOrEqual1000Rule implements RuleInterface
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
