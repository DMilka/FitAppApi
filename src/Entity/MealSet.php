<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Core\Database\Autofill\Entity\UserFill;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\MealRepository;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"meal_set_read"}}
 *          },
 *          "post"={
 *              "normalization_context"={"groups"={"meal_set_read"}},
 *              "denormalization_context"={"groups"={"meal_set_write"}}
 *          },
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"meal_set_read"}}
 *          },
 *          "put"={
 *              "normalization_context"={"groups"={"meal_set_read"}},
 *              "denormalization_context"={"groups"={"meal_set_update"}}
 *          },}
 * )
 * @ORM\Entity(repositoryClass=MealRepository::class)
 */
class MealSet extends UserFill
{
    /**
     * @Groups({"meal_set_set_read"})
     * @ApiProperty(identifier=true)
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\SequenceGenerator(sequenceName="meal_set_id_seq")
     * @ORM\Column(type="integer", name="id")
     */
    private ?int $id = null;

    /**
     * @Groups({"meal_set_read", "meal_set_write","meal_set_update"})
     * @ORM\Column(type="string", length=255, name="name")
     */
    private string $name;

    /**
     * @Groups({"meal_set_read", "meal_set_write","meal_set_update"})
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
     * @return MealSet
     */
    public function setDescription(?string $description): MealSet
    {
        $this->description = $description;
        return $this;
    }
}
