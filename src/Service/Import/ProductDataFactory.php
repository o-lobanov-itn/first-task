<?php

namespace App\Service\Import;

use App\Entity\ProductData;
use App\Exception\Import\RowValidationErrorException;
use App\Validator\Import\Constraints\ProductDataRequirements;
use DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductDataFactory
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
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

        $name = $row['Product Name'];
        $desc = $row['Product Description'];
        $code = $row['Product Code'];
        $stock = (int) ($row['Stock'] ?? 0);
        $price = isset($row['Cost in GBP']) ? (float) $row['Cost in GBP'] : null;
        $discontinued = $row['Discontinued'] ?? null;

        $product = (new ProductData())
            ->setProductName($name)
            ->setProductDesc($desc)
            ->setProductCode($code)
            ->setStock($stock)
            ->setPrice($price);

        /*
         * Any stock item marked as discontinued will be imported,
         * but will have the discontinued date set as the current date.
         */
        if ('yes' === $discontinued) {
            $product->setDiscontinued(new DateTime());
        }

        return $product;
    }
}
