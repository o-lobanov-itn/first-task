<?php

namespace App\Domain\ImportRule;

use App\Entity\ProductData;

interface ImportRuleInterface
{
    public function getDescription(): string;

    public function isImportable(ProductData $productData): bool;
}
