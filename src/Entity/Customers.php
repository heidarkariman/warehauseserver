<?php

namespace App\Entity;

use App\Repository\CustomersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomersRepository::class)]
class Customers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Sales::class, orphanRemoval: true)]
    private Collection $buys;

    public function __construct()
    {
        $this->buys = new ArrayCollection();
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

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    /**
     * @return Collection<int, Sales>
     */
    public function getBuys(): Collection
    {
        return $this->buys;
    }

    public function addBuy(Sales $buy): self
    {
        if (!$this->buys->contains($buy)) {
            $this->buys->add($buy);
            $buy->setCustomer($this);
        }

        return $this;
    }

    public function removeBuy(Sales $buy): self
    {
        if ($this->buys->removeElement($buy)) {
            // set the owning side to null (unless already changed)
            if ($buy->getCustomer() === $this) {
                $buy->setCustomer(null);
            }
        }

        return $this;
    }
}
