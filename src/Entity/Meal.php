<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\MealRepository;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"meal_read"}}
 *          },
 *          "post"={
 *              "normalization_context"={"groups"={"meal_read"}},
 *              "denormalization_context"={"groups"={"meal_write"}}
 *          },
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"meal_read"}}
 *          },
 *          "put"={
 *              "normalization_context"={"groups"={"meal_read"}},
 *              "denormalization_context"={"groups"={"meal_update"}}
 *          },}
 * )
 * @ORM\Entity(repositoryClass=MealRepository::class)
 */
class Meal
{
    /**
     * @Groups({"meal_read"})
     * @ApiProperty(identifier=true)
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\SequenceGenerator(sequenceName="meal_id_seq")
     * @ORM\Column(type="integer", name="id")
     */
    private ?int $id = null;

    /**
     * @Groups({"meal_write"})
     * @ORM\Column(type="integer", nullable=false, name="user_id")
     */
    private int $userId;

    /**
     * @Groups({"meal_read", "meal_write","meal_update"})
     * @ORM\Column(type="string", length=255, name="name")
     */
    private string $name;

    /**
     * @Groups({"meal_read", "meal_write","meal_update"})
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
     * @return Meal
     */
    public function setDescription(?string $description): Meal
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
     * @return Meal
     */
    public function setUserId(int $userId): Meal
    {
        $this->userId = $userId;
        return $this;
    }


}
