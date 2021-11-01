<?php

namespace App\Service\Import;

use App\Domain\Import\Mappers\ProductDataMapper;
use App\Entity\ProductData;
use App\Exception\Import\RowValidationErrorException;
use App\Validator\Import\Constraints\ProductDataRequirements;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductDataFactory
{
    private ValidatorInterface $validator;

    private ProductDataMapper $mapper;

    public function __construct(ValidatorInterface $validator, ProductDataMapper $mapper)
    {
        $this->validator = $validator;
        $this->mapper = $mapper;
    }

    /**
     * @throws RowValidationErrorException
     */
    public function createFromRow(array $row): ProductData
    {
        $errors = $this->validator->validate($row, new ProductDataRequirements());

        if (0 !== count($errors)) {
            throw new RowValidationErrorException($errors);
        }

        return $this->mapper->mapRowToProductData($row);
    }
}
