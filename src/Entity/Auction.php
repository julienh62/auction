<?php

namespace App\Entity;

use App\Enum\Status;
use App\Repository\AuctionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: AuctionRepository::class)]
#[Broadcast]
class Auction implements TranslatableInterface
{

    use TranslatableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: 'string', enumType:Status::class)]
    private Status $status = Status::STANDBY;

    #[ORM\Column]
    private ?int $price = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateOpen = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateClose = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;


    public function __toString(): string
    {
        // Retourne une représentation en chaîne de l'objet Auction
        return $this->getId(); // Vous pouvez utiliser un autre champ pertinent pour représenter l'Auction
    }



    #[ORM\OneToMany(mappedBy: 'auction', targetEntity: Raise::class, orphanRemoval: true)]
    private Collection $auctions;

    public function __construct()
    {
        $this->auctions = new ArrayCollection();
        $this->createdAt = new \DateTime(); // Définit la date actuelle lors de la création de l'entité

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->translate()->getTitle();
    }

    public function getDescription(): ?string
    {
        return $this->translate()->getDescription();
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



    public function getDateOpen(): ?\DateTimeInterface
    {
        return $this->dateOpen;
    }

    public function setDateOpen(\DateTimeInterface $dateOpen): static
    {
        $this->dateOpen = $dateOpen;

        return $this;
    }

    public function getDateClose(): ?\DateTimeInterface
    {
        return $this->dateClose;
    }

    public function setDateClose(\DateTimeInterface $dateClose): static
    {
        $this->dateClose = $dateClose;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTime();
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Raise>
     */
    public function getAuctions(): Collection
    {
        return $this->auctions;
    }

    public function addAuction(Raise $auction): static
    {
        if (!$this->auctions->contains($auction)) {
            $this->auctions->add($auction);
            $auction->setAuction($this);
        }

        return $this;
    }

    public function removeAuction(Raise $auction): static
    {
        if ($this->auctions->removeElement($auction)) {
            // set the owning side to null (unless already changed)
            if ($auction->getAuction() === $this) {
                $auction->setAuction(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Raise>
     */
    public function getRaises(): Collection
    {
        return $this->auctions;
    }
}
