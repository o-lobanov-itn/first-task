<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductDataRepository;

/**
 * @ORM\Entity(repositoryClass=ProductDataRepository::class)
 */
class ProductData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(length=50)
     */
    private string $productName;

    /**
     * @ORM\Column(length=255)
     */
    private string $productDesc;

    /**
     * @ORM\Column(length=10)
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $added;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $discontinued;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $timestamp;

    public function __construct()
    {
        $this->timestamp = new DateTime();
    }

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

    /**
     * @param string $productName
     * @return ProductData
     */
    public function setProductName(string $productName): ProductData
    {
        $this->productName = $productName;
        return $this;
    }

    /**
     * @param string $productDesc
     * @return ProductData
     */
    public function setProductDesc(string $productDesc): ProductData
    {
        $this->productDesc = $productDesc;
        return $this;
    }

    /**
     * @param string $productCode
     * @return ProductData
     */
    public function setProductCode(string $productCode): ProductData
    {
        $this->productCode = $productCode;
        return $this;
    }

    /**
     * @param int $stock
     * @return ProductData
     */
    public function setStock(int $stock): ProductData
    {
        $this->stock = $stock;
        return $this;
    }

    /**
     * @param float|null $price
     * @return ProductData
     */
    public function setPrice(?float $price): ProductData
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @param DateTime|null $added
     * @return ProductData
     */
    public function setAdded(?DateTime $added): ProductData
    {
        $this->added = $added;
        return $this;
    }

    /**
     * @param DateTime|null $discontinued
     * @return ProductData
     */
    public function setDiscontinued(?DateTime $discontinued): ProductData
    {
        $this->discontinued = $discontinued;
        return $this;
    }
}
