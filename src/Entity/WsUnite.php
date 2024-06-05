<?php

namespace App\Entity;

use App\Repository\WsUniteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WsUniteRepository::class)]
class WsUnite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, WsSection>
     */
    #[ORM\OneToMany(targetEntity: WsSection::class, mappedBy: 'unite')]
    private Collection $wsSections;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\ManyToOne(inversedBy: 'wsUnites')]
    private ?WsGroupeUnite $groupe = null;

    public function __construct()
    {
        $this->wsSections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, WsSection>
     */
    public function getWsSections(): Collection
    {
        return $this->wsSections;
    }

    public function addWsSection(WsSection $wsSection): static
    {
        if (!$this->wsSections->contains($wsSection)) {
            $this->wsSections->add($wsSection);
            $wsSection->setUnite($this);
        }

        return $this;
    }

    public function removeWsSection(WsSection $wsSection): static
    {
        if ($this->wsSections->removeElement($wsSection)) {
            // set the owning side to null (unless already changed)
            if ($wsSection->getUnite() === $this) {
                $wsSection->setUnite(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getGroupe(): ?WsGroupeUnite
    {
        return $this->groupe;
    }

    public function setGroupe(?WsGroupeUnite $groupe): static
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getGroupeName(): ?string
    {
        return $this->groupe ? $this->groupe->getName() : null;
    }
}
