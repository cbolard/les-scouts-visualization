<?php

namespace App\Entity;

use App\Repository\WsGroupeUniteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;


#[ORM\Entity(repositoryClass: WsGroupeUniteRepository::class)]
#[Crud\Controller("App\Controller\Admin\WsGroupeUniteCrudController")]
class WsGroupeUnite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, WsUnite>
     */
    #[ORM\OneToMany(targetEntity: WsUnite::class, mappedBy: 'groupe')]
    private Collection $wsUnites;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\ManyToOne(inversedBy: 'wsGroupeUnites')]
    private ?WsFederation $federation = null;

    public function __construct()
    {
        $this->wsUnites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, WsUnite>
     */
    public function getWsUnites(): Collection
    {
        return $this->wsUnites;
    }

    public function addWsUnite(WsUnite $wsUnite): static
    {
        if (!$this->wsUnites->contains($wsUnite)) {
            $this->wsUnites->add($wsUnite);
            $wsUnite->setGroupe($this);
        }

        return $this;
    }

    public function removeWsUnite(WsUnite $wsUnite): static
    {
        if ($this->wsUnites->removeElement($wsUnite)) {
            // set the owning side to null (unless already changed)
            if ($wsUnite->getGroupe() === $this) {
                $wsUnite->setGroupe(null);
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

    public function getFederation(): ?WsFederation
    {
        return $this->federation;
    }

    public function setFederation(?WsFederation $federation): static
    {
        $this->federation = $federation;

        return $this;
    }
}
