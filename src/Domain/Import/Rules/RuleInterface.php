<?php

namespace App\Domain\Import\Rules;

use App\Entity\ProductData;

interface RuleInterface
{
    public function getDescription(): string;

    public function isImportable(ProductData $productData): bool;
}
