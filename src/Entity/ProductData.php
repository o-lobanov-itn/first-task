<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductDataRepository;

/**
 * @ORM\Entity(repositoryClass=ProductDataRepository::class)
 * @ORM\Table(name="tblProductData")
 */
class ProductData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="intProductDataId")
     */
    private int $id;

    /**
     * @ORM\Column(length=50, name="strProductName")
     */
    private string $productName;

    /**
     * @ORM\Column(length=255, name="strProductDesc")
     */
    private string $productDesc;

    /**
     * @ORM\Column(length=10, name="strProductCode")
     */
    private string $productCode;

    /**
     * @ORM\Column(type="integer", options={"default":0})
     */
    private int $stock;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $price;

    /**
     * @ORM\Column(type="datetime", name="dtmAdded", nullable=true)
     */
    private ?DateTime $added;

    /**
     * @ORM\Column(type="datetime", name="dtmDiscontinued", nullable=true)
     */
    private ?DateTime $discontinued;

    /**
     * @ORM\Column(type="datetime", name="stmTimestamp")
     */
    private DateTime $timestamp;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->productName;
    }

    /**
     * @return string
     */
    public function getProductDesc(): string
    {
        return $this->productDesc;
    }

    /**
     * @return string
     */
    public function getProductCode(): string
    {
        return $this->productCode;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @return DateTime|null
     */
    public function getAdded(): ?DateTime
    {
        return $this->added;
    }

    /**
     * @return DateTime|null
     */
    public function getDiscontinued(): ?DateTime
    {
        return $this->discontinued;
    }

    /**
     * @return DateTime
     */
    public function getTimestamp(): DateTime
    {
        return $this->timestamp;
    }
}
