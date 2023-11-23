<?php

namespace App\Entity;

use App\Repository\RaiseRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RaiseRepository::class)]
class Raise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column]
    #[Assert\Expression(
        "value > this.getLastRaise() + add_value",
message: "must be greater than highest raise for this product or + 5",
values: ['add_value' => 5 * 100]
    )]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'auctions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Auction $auction = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getAuction(): ?Auction
    {
        return $this->auction;
    }

    public function setAuction(?Auction $auction): static
    {
        $this->auction = $auction;

        return $this;
    }

    public function getLastRaise()
    {
        $array = $this->getAuction()?->getRaises()->toArray();
        if (count($array)==0) {
            return null;
        }
        return end($array)->getPrice();
    }
}
