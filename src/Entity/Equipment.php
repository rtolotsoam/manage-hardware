<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource as AnnotationApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\EquipmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;

const READ_EQUIPMENT = 'read:equipment';
const WRITE_EQUIPMENT = 'write:equipment';

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
#[AnnotationApiResource()]
#[ApiResource(
    normalizationContext: ['groups' => [READ_EQUIPMENT]],
    denormalizationContext: ['groups' => [WRITE_EQUIPMENT]],
    collectionOperations: [
        'get' => ['normalization_context' => ['groups' => [READ_EQUIPMENT]]],
        'post' => ['denormalization_context' => ['groups' => [WRITE_EQUIPMENT]]],
    ],
    itemOperations: [
        'get' => ['normalization_context' => ['groups' => [READ_EQUIPMENT]]],
        'put' => ['denormalization_context' => ['groups' => [WRITE_EQUIPMENT]]],
        'patch' => ['denormalization_context' => ['groups' => [WRITE_EQUIPMENT]]],
        'delete',
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact'])]
#[ORM\HasLifecycleCallbacks]
class Equipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Length(min: 3)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(length: 255)]
    #[Length(min: 2)]
    private ?string $number = null;

    #[ORM\Column(type: Types::TEXT, length: 65535, options: ['default' => ''])]
    #[Length(max: 65535)]
    private ?string $description = '';

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([WRITE_EQUIPMENT, READ_EQUIPMENT])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups([WRITE_EQUIPMENT, READ_EQUIPMENT])]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime;
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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): void
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTime;
        }
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAt() : void
    {
        $this->updatedAt = new \DateTime;
    }
}
