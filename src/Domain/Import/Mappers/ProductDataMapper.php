<?php

namespace App\Domain\Import\Mappers;

use App\Entity\ProductData;
use DateTime;

/**
 * Inspired by https://designpatternsphp.readthedocs.io/en/latest/Structural/DataMapper/README.html
 */
class ProductDataMapper
{
    public function mapRowToProductData(array $row): ProductData
    {
        $name = $row['Product Name'];
        $desc = $row['Product Description'];
        $code = $row['Product Code'];
        $stock = (int) ($row['Stock'] ?? 0);
        $price = isset($row['Cost in GBP']) ? (float) $row['Cost in GBP'] : null;
        $discontinued = $row['Discontinued'] ?? null;

        $productData = (new ProductData())
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
            $productData->setDiscontinued(new DateTime());
        }

        return $productData;
    }

    /*
     * function mapProductDataToRow isn't yet, because YAGNI.
     */
}