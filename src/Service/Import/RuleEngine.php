<?php

namespace App\Service\Import;

use App\Domain\Import\Rules\RuleInterface;
use App\Entity\ProductData;

final class RuleEngine
{
    /** @var RuleInterface[] */
    private array $rules;

    public function __construct(array $rules)
    {
        foreach ($rules as $rule) {
            $this->addRule($rule);
        }
    }

    public function addRule(RuleInterface $rule): RuleEngine
    {
        $this->rules[] = $rule;

        return $this;
    }

    public function validate(ProductData $productData): array
    {
        $errors = [];

        foreach ($this->rules as $rule) {
            if (false === $rule->isImportable($productData)) {
                $errors[] = $rule->getDescription();
            }
        }

        return $errors;
    }
}
