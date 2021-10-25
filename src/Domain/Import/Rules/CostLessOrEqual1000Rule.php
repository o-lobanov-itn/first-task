<?php

namespace App\Domain\Import\Rules;

use App\Entity\ProductData;
use App\Exception\Import\RuleCheckingException;

class CostLessOrEqual1000Rule implements RuleInterface
{
    /**
     * @throws RuleCheckingException
     */
    public function check(ProductData $productData): void
    {
        if ($productData->getPrice() > 1000) {
            throw new RuleCheckingException('Any stock items which cost over $1000 will not be imported.');
        }
    }
}
