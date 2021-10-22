<?php

namespace App\Service;

use App\Domain\ImportRule\ImportRuleInterface;
use App\Entity\ProductData;

final class ImportRuleEngine
{
    private array $rules;

    public function addRule(ImportRuleInterface $rule): ImportRuleEngine
    {
        $this->rules[] = $rule;
        return $this;
    }

    public function validate(ProductData $productData): array
    {
        $errors = [];

        /** @var ImportRuleInterface $rule */
        foreach ($this->rules as $rule) {
            if (false === $rule->isImportable($productData)) {
                $errors[] = $rule->getDescription();
            }
        }

        return $errors;
    }
}