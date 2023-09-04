<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
#[ORM\Table(name: "departement")]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'departement', targetEntity: Festival::class)]
    private Collection $festivals;

    public function __construct()
    {
        $this->festivals = new ArrayCollection();
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

    /**
     * @return Collection<int, Festival>
     */
    public function getFestivals(): Collection
    {
        return $this->festivals;
    }

    public function addFestival(Festival $festival): static
    {
        if (!$this->festivals->contains($festival)) {
            $this->festivals->add($festival);
            $festival->setDepartement($this);
        }

        return $this;
    }

    public function removeFestival(Festival $festival): static
    {
        if ($this->festivals->removeElement($festival)) {
            // set the owning side to null (unless already changed)
            if ($festival->getDepartement() === $this) {
                $festival->setDepartement(null);
            }
        }

        return $this;
    }

}
