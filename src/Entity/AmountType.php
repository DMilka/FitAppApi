<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Core\Database\Autofill\Entity\UserFill;
use App\Repository\AmountTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"amount_type_read"}}
 *          },
 *          "post"={
 *              "normalization_context"={"groups"={"amount_type_read"}},
 *              "denormalization_context"={"groups"={"amount_type_write"}}
 *          },
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"amount_type_read"}}
 *          },
 *          "put"={
 *              "normalization_context"={"groups"={"amount_type_read"}},
 *              "denormalization_context"={"groups"={"amount_type_update"}}
 *          },}
 * )
 * @ORM\Entity(repositoryClass=AmountTypeRepository::class)
 */
class AmountType extends UserFill
{
    /**
     * @Groups({"amount_type_read"})
     * @ApiProperty(identifier=true)
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\SequenceGenerator(sequenceName="amount_type_id_seq")
     * @ORM\Column(type="integer", name="id")
     */
    private ?int $id = null;

    /**
     * @Groups({"amount_type_read", "amount_type_write", "amount_type_update","ingredient_read"})
     * @ORM\Column(type="string", length=255, name="name")
     */
    private string $name;

    /**
     * @Groups({"amount_type_read", "amount_type_write", "amount_type_update"})
     * @ORM\Column(type="string", length=255, name="description")
     */
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return AmountType
     */
    public function setDescription(?string $description): AmountType
    {
        $this->description = $description;
        return $this;
    }
}
