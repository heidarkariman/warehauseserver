<?php

namespace App\Entity;

use App\Repository\WarehausesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WarehausesRepository::class)]
class Warehauses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $address = null;

    #[ORM\OneToMany(mappedBy: 'warehause', targetEntity: Inventories::class, orphanRemoval: true)]
    private Collection $inventories;

    #[ORM\OneToMany(mappedBy: 'warehause', targetEntity: Purchases::class, orphanRemoval: true)]
    private Collection $purchases;

    #[ORM\OneToMany(mappedBy: 'warehause', targetEntity: Sales::class, orphanRemoval: true)]
    private Collection $sales;

    public function __construct()
    {
        $this->inventories = new ArrayCollection();
        $this->purchases = new ArrayCollection();
        $this->sales = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Inventories>
     */
    public function getInventories(): Collection
    {
        return $this->inventories;
    }

    public function addInventory(Inventories $inventory): self
    {
        if (!$this->inventories->contains($inventory)) {
            $this->inventories->add($inventory);
            $inventory->setWarehause($this);
        }

        return $this;
    }

    public function removeInventory(Inventories $inventory): self
    {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getWarehause() === $this) {
                $inventory->setWarehause(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Purchases>
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchases $purchase): self
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases->add($purchase);
            $purchase->setWarehause($this);
        }

        return $this;
    }

    public function removePurchase(Purchases $purchase): self
    {
        if ($this->purchases->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getWarehause() === $this) {
                $purchase->setWarehause(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sales>
     */
    public function getSales(): Collection
    {
        return $this->sales;
    }

    public function addSale(Sales $sale): self
    {
        if (!$this->sales->contains($sale)) {
            $this->sales->add($sale);
            $sale->setWarehause($this);
        }

        return $this;
    }

    public function removeSale(Sales $sale): self
    {
        if ($this->sales->removeElement($sale)) {
            // set the owning side to null (unless already changed)
            if ($sale->getWarehause() === $this) {
                $sale->setWarehause(null);
            }
        }

        return $this;
    }
}
