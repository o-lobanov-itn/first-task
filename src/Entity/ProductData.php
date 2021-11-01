<?php

namespace App\Entity;

use App\Repository\ProductDataRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

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

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getProductDesc(): string
    {
        return $this->productDesc;
    }

    public function getProductCode(): string
    {
        return $this->productCode;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function getAdded(): ?DateTime
    {
        return $this->added;
    }

    public function getDiscontinued(): ?DateTime
    {
        return $this->discontinued;
    }

    public function getTimestamp(): DateTime
    {
        return $this->timestamp;
    }

    public function setProductName(string $productName): ProductData
    {
        $this->productName = $productName;

        return $this;
    }

    public function setProductDesc(string $productDesc): ProductData
    {
        $this->productDesc = $productDesc;

        return $this;
    }

    public function setProductCode(string $productCode): ProductData
    {
        $this->productCode = $productCode;

        return $this;
    }

    public function setStock(int $stock): ProductData
    {
        $this->stock = $stock;

        return $this;
    }

    public function setPrice(?float $price): ProductData
    {
        $this->price = $price;

        return $this;
    }

    public function setAdded(?DateTime $added): ProductData
    {
        $this->added = $added;

        return $this;
    }

    public function setDiscontinued(?DateTime $discontinued): ProductData
    {
        $this->discontinued = $discontinued;

        return $this;
    }
}
