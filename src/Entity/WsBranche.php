<?php

namespace App\Entity;

use App\Repository\WsBrancheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WsBrancheRepository::class)]
class WsBranche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    /**
     * @var Collection<int, WsSection>
     */
    #[ORM\OneToMany(targetEntity: WsSection::class, mappedBy: 'branche')]
    private Collection $wsSections;

    public function __construct()
    {
        $this->wsSections = new ArrayCollection();
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
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
            $wsSection->setBranche($this);
        }

        return $this;
    }

    public function removeWsSection(WsSection $wsSection): static
    {
        if ($this->wsSections->removeElement($wsSection)) {
            // set the owning side to null (unless already changed)
            if ($wsSection->getBranche() === $this) {
                $wsSection->setBranche(null);
            }
        }

        return $this;
    }
}
