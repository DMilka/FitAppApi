<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
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
class AmountType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @Groups({"amount_type_read", "amount_type_write"})
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $userId;

    /**
     * @Groups({"amount_type_read", "amount_type_write"})
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @Groups({"amount_type_read", "amount_type_write"})
     * @ORM\Column(type="string", length=255)
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

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return AmountType
     */
    public function setUserId(int $userId): AmountType
    {
        $this->userId = $userId;
        return $this;
    }


}
