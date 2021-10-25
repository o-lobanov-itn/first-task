<?php

namespace App\Service\Import;

use App\Domain\Import\Rules\RuleInterface;
use App\Entity\ProductData;
use App\Exception\Import\RuleCheckingException;

final class RuleEngine implements RuleInterface
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

    public function check(ProductData $productData): void
    {
        $errors = [];

        foreach ($this->rules as $rule) {
            try {
                $rule->check($productData);
            } catch (RuleCheckingException $exception) {
                $errors[] = $exception->getMessage();
            }
        }

        if (0 !== count($errors)) {
            throw new RuleCheckingException(implode("\n", $errors));
        }
    }
}
