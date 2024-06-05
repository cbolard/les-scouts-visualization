<?php

namespace App\Entity;

use App\Repository\WsSectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WsSectionRepository::class)]
class WsSection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\ManyToOne(inversedBy: 'wsSections')]
    private ?WsUnite $unite = null;

    #[ORM\ManyToOne(inversedBy: 'wsSections')]
    private ?WsBranche $branche = null;

    /**
     * @var Collection<int, WsMembre>
     */
    #[ORM\OneToMany(targetEntity: WsMembre::class, mappedBy: 'section')]
    private Collection $wsMembres;

    public function __construct()
    {
        $this->wsMembres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNameWithoutCode(): ?string
    {
        if (strpos($this->name, ' ') !== false) {
            return substr($this->name, strpos($this->name, ' ') + 1);
        }

        return $this->name;
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

    public function getUnite(): ?WsUnite
    {
        return $this->unite;
    }

    public function setUnite(?WsUnite $unite): static
    {
        $this->unite = $unite;

        return $this;
    }

    public function getUniteName(): ?string
    {
        return $this->unite ? $this->unite->getName() : null;
    }

    public function getGroupeName(): ?string
    {
        return $this->unite ? $this->unite->getGroupeName() : null;
    }

    public function getBranche(): ?WsBranche
    {
        return $this->branche;
    }

    public function setBranche(?WsBranche $branche): static
    {
        $this->branche = $branche;

        return $this;
    }

    /**
     * @return Collection<int, WsMembre>
     */
    public function getWsMembres(): Collection
    {
        return $this->wsMembres;
    }

    public function addWsMembre(WsMembre $wsMembre): static
    {
        if (!$this->wsMembres->contains($wsMembre)) {
            $this->wsMembres->add($wsMembre);
            $wsMembre->setSection($this);
        }

        return $this;
    }

    public function removeWsMembre(WsMembre $wsMembre): static
    {
        if ($this->wsMembres->removeElement($wsMembre)) {
            // set the owning side to null (unless already changed)
            if ($wsMembre->getSection() === $this) {
                $wsMembre->setSection(null);
            }
        }

        return $this;
    }
}
