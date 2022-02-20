<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MealToMealSetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_MEAL_TO_MEAL_SET_GET')",
 *              "normalization_context"={"groups"={"meal_to_meal_set_read"}}
 *          },
 *          "post"={
 *              "security"="is_granted('ROLE_MEAL_TO_MEAL_SET_POST')",
 *              "normalization_context"={"groups"={"meal_to_meal_set_read"}},
 *              "denormalization_context"={"groups"={"meal_to_meal_set_write"}}
 *          },
 *     },
 *     itemOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_MEAL_TO_MEAL_SET_GET')",
 *              "normalization_context"={"groups"={"meal_to_meal_set_read"}}
 *          },
 *          "put"={
 *              "security"="is_granted('ROLE_MEAL_TO_MEAL_SET_PUT')",
 *              "normalization_context"={"groups"={"meal_to_meal_set_read"}},
 *              "denormalization_context"={"groups"={"meal_to_meal_set_update"}}
 *          },
 *          "delete"={
 *              "security"="is_granted('ROLE_MEAL_TO_MEAL_SET_DELETE')",
 *              "denormalization_context"={"groups"={"meal_set_delete"}}
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass=MealToMealSetRepository::class)
 */
class MealToMealSet
{
    /**
     * @Groups({"meal_to_meal_set_read"})
     * @ApiProperty(identifier=true)
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\SequenceGenerator(sequenceName="meal_to_meal_set_id_seq")
     * @ORM\Column(type="integer", name="id")
     */
    private ?int $id = null;

    /**
     * @Groups({"meal_to_meal_set_read", "meal_to_meal_set_write","meal_to_meal_set_update"})
     * @ORM\Column(type="integer",  name="meal_set_id", nullable=false)
     */
    private int $mealSetId;

    /**
     * @Groups({"meal_to_meal_set_read", "meal_to_meal_set_write","meal_to_meal_set_update"})
     * @ORM\Column(type="integer", name="meal_id", nullable=false)
     */
    private int $mealId;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getMealSetId(): int
    {
        return $this->mealSetId;
    }

    /**
     * @param int $mealSetId
     * @return MealToMealSet
     */
    public function setMealSetId(int $mealSetId): MealToMealSet
    {
        $this->mealSetId = $mealSetId;
        return $this;
    }

    /**
     * @return int
     */
    public function getMealId(): int
    {
        return $this->mealId;
    }

    /**
     * @param int $mealId
     * @return MealToMealSet
     */
    public function setMealId(int $mealId): MealToMealSet
    {
        $this->mealId = $mealId;
        return $this;
    }
}
