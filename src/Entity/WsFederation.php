<?php

namespace App\Entity;

use App\Repository\WsFederationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

#[ORM\Entity(repositoryClass: WsFederationRepository::class)]
#[Crud\Controller("App\Controller\Admin\WsFederationCrudController")]
class WsFederation 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, WsGroupeUnite>
     */
    #[ORM\OneToMany(targetEntity: WsGroupeUnite::class, mappedBy: 'federation')]
    private Collection $wsGroupeUnites;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->wsGroupeUnites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, WsGroupeUnite>
     */
    public function getWsGroupeUnites(): Collection
    {
        return $this->wsGroupeUnites;
    }

    public function addWsGroupeUnite(WsGroupeUnite $wsGroupeUnite): static
    {
        if (!$this->wsGroupeUnites->contains($wsGroupeUnite)) {
            $this->wsGroupeUnites->add($wsGroupeUnite);
            $wsGroupeUnite->setFederation($this);
        }

        return $this;
    }

    public function removeWsGroupeUnite(WsGroupeUnite $wsGroupeUnite): static
    {
        if ($this->wsGroupeUnites->removeElement($wsGroupeUnite)) {
            // set the owning side to null (unless already changed)
            if ($wsGroupeUnite->getFederation() === $this) {
                $wsGroupeUnite->setFederation(null);
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
}
