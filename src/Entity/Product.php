<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le nom ne peut pas être vide.')]
    #[Assert\Length(min: 3, minMessage: 'Le nom doit contenir au moins {{ limit }} caractères.')]
    private ?string $nom = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le prix ne peut pas être vide.')]
    #[Assert\Type(type: 'float', message: 'Le prix doit être un nombre décimal.')]
    #[Assert\Positive(message: 'Le prix doit être un nombre positif.')]
    private ?float $prix = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'La quantité ne peut pas être vide.')]
    #[Assert\Regex(pattern: '/^\d+$/', message: 'La quantité doit être un nombre entier positif.')]
    private ?string $quantite = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\Type(type: 'bool', message: 'Le statut doit être un booléen.')]
    private ?bool $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $modifiedAt = null;
    // hadi valiation dyal categorie 
    #[ORM\ManyToOne(inversedBy: 'products')]
    #[Assert\NotNull(message: "Veuillez sélectionner une catégorie.")]
     private ?Categorie $categorie = null;
   

    

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;
        return $this;
    }

    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(string $quantite): static
    {
        $this->quantite = $quantite;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getModifiedAt(): ?\DateTime
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?\DateTime $modifiedAt): static
    {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }


    #[ORM\PreUpdate]
    public function updateModifiedAt(): void
    {
        $this->modifiedAt = new \DateTime();
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }
    // hna kayna relation manyTo one m3a categorie 
    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
    
}
