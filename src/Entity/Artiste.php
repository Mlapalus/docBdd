<?php

namespace App\Entity;

use App\Repository\ArtisteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtisteRepository::class)]
#[ORM\Table(options: ['comment' => 'Table des Artistes'])]
class Artiste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, options: ['comment' => "Nom de l\'artiste"])]
    private ?string $nom = null;

    #[ORM\Column(length: 255, options: ['comment' => "Prenom de l\'artiste"])]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['comment' => "Date de naissance de l\'artiste"])]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\ManyToMany(targetEntity: Album::class, mappedBy: 'artistes')]
    #[ORM\Column(options: ['comment' => "Albums de l\'artiste"])]
    private Collection $albums;

    #[ORM\ManyToMany(targetEntity: Style::class, mappedBy: 'artistes')]
    #[ORM\Column(options: ['comment' => "Styles de l\'artiste"])]
    private Collection $styles;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
        $this->styles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
            $album->addArtiste($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            $album->removeArtiste($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Style>
     */
    public function getStyles(): Collection
    {
        return $this->styles;
    }

    public function addStyle(Style $style): self
    {
        if (!$this->styles->contains($style)) {
            $this->styles->add($style);
            $style->addArtiste($this);
        }

        return $this;
    }

    public function removeStyle(Style $style): self
    {
        if ($this->styles->removeElement($style)) {
            $style->removeArtiste($this);
        }

        return $this;
    }
}
