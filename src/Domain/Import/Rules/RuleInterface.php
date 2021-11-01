<?php

namespace App\Domain\Import\Rules;

use App\Entity\ProductData;
use App\Exception\Import\RuleCheckingException;

interface RuleInterface
{
    /**
     * @throws RuleCheckingException
     */
    public function check(ProductData $productData): void;
}
