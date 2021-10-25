<?php

namespace App\Validator\Import\Constraints;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints as Assert;

class ProductDataRequirements extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\Collection([
                'Product Name' => [new Assert\Required(), new Assert\NotBlank()],
                'Product Description' => [new Assert\Required(), new Assert\NotBlank()],
                'Product Code' => [new Assert\Required(), new Assert\NotBlank()],
                'Stock' => new Assert\PositiveOrZero(),
                'Cost in GBP' => new Assert\AtLeastOneOf([new Assert\Blank(), new Assert\PositiveOrZero()]),
                'Discontinued' => new Assert\AtLeastOneOf([new Assert\Blank(), new Assert\Choice(['yes'])]),
            ])
        ];
    }
}