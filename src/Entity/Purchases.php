<?php

namespace App\Entity;

use App\Repository\PurchasesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchasesRepository::class)]
class Purchases
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'purchases')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vendors $vendor = null;

    #[ORM\ManyToOne(inversedBy: 'purchases')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Products $product = null;

    #[ORM\ManyToOne(inversedBy: 'purchases')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Warehauses $warehause = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 13, scale: 2)]
    private ?string $unit_price = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $purchace_date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVendor(): ?Vendors
    {
        return $this->vendor;
    }

    public function setVendor(?Vendors $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getWarehause(): ?Warehauses
    {
        return $this->warehause;
    }

    public function setWarehause(?Warehauses $warehause): self
    {
        $this->warehause = $warehause;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitPrice(): ?string
    {
        return $this->unit_price;
    }

    public function setUnitPrice(string $unit_price): self
    {
        $this->unit_price = $unit_price;

        return $this;
    }

    public function getPurchaceDate(): ?\DateTimeInterface
    {
        return $this->purchace_date;
    }

    public function setPurchaceDate(\DateTimeInterface $purchace_date): self
    {
        $this->purchace_date = $purchace_date;

        return $this;
    }
}
