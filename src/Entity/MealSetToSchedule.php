<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\EntityProcesses\MealSetToSchedule\MealSetToScheduleDeleteProcess;
use App\EntityProcesses\MealSetToSchedule\MealSetToSchedulePostProcess;
use App\EntityProcesses\MealSetToSchedule\MealSetToSchedulePutProcess;
use App\Repository\MealSetToScheduleRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Core\Database\HelperEntity\SoftDelete;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(
    repositoryClass: MealSetToScheduleRepository::class
)]
#[ApiResource]
#[Get(
    normalizationContext: ['groups' => ['meal_set_to_schedule_get']],
    security: "is_granted('ROLE_MEAL_SET_TO_SCHEDULE_GET')",
)]
#[GetCollection(
    normalizationContext: ['groups' => ['meal_set_to_schedule_get']],
    security: "is_granted('ROLE_MEAL_SET_TO_SCHEDULE_GET')",
)]
#[Post(
    normalizationContext: ['groups' => ['meal_set_to_schedule_get']],
    denormalizationContext: ['groups' => ['meal_set_to_schedule_post']],
    security: "is_granted('ROLE_MEAL_SET_TO_SCHEDULE_POST')",
    processor: MealSetToSchedulePostProcess::class
)]
#[Put(
    normalizationContext: ['groups' => ['meal_set_to_schedule_get']],
    denormalizationContext: ['groups' => ['meal_set_to_schedule_put']],
    security: "is_granted('ROLE_MEAL_SET_TO_SCHEDULE_PUT')",
    processor: MealSetToSchedulePutProcess::class
)]
#[Delete(
    denormalizationContext: ['groups' => ['meal_set_to_schedule_delete']],
    security: "is_granted('ROLE_MEAL_SET_TO_SCHEDULE_DELETE', object)",
    processor: MealSetToScheduleDeleteProcess::class
)]
class MealSetToSchedule extends SoftDelete
{
    #[Orm\Id, ORM\Column(name: 'id', type:'integer'), ORM\GeneratedValue]
    #[Groups(['meal_set_to_schedule_get', 'meal_set_to_schedule_post','meal_set_to_schedule_put', 'meal_set_to_schedule_delete'])]
    private ?int $id = null;

    #[Orm\Column(name:'meal_set_id',type: 'integer')]
    #[Groups(['meal_set_to_schedule_get', 'meal_set_to_schedule_post','meal_set_to_schedule_put', 'meal_set_to_schedule_delete'])]
    private int $mealSetId;

    #[ORM\OneToOne(targetEntity: MealSet::class, cascade: ['persist'])]
    #[Groups(['meal_set_to_schedule_get', 'meal_set_to_schedule_post','meal_set_to_schedule_put', 'meal_set_to_schedule_delete'])]
    private ?MealSet $mealSet = null;

    #[Orm\Column(name:'schedule_id', type: 'integer')]
    #[Groups(['meal_set_to_schedule_get', 'meal_set_to_schedule_post','meal_set_to_schedule_put', 'meal_set_to_schedule_delete'])]
    private int $scheduleId;

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
     * @return MealSetToSchedule
     */
    public function setMealSetId(int $mealSetId): MealSetToSchedule
    {
        $this->mealSetId = $mealSetId;
        return $this;
    }

    /**
     * @return MealSet|null
     */
    public function getMealSet(): ?MealSet
    {
        return $this->mealSet;
    }

    /**
     * @param MealSet|null $mealSet
     * @return MealSetToSchedule
     */
    public function setMealSet(?MealSet $mealSet): MealSetToSchedule
    {
        $this->mealSet = $mealSet;
        return $this;
    }

    /**
     * @return int
     */
    public function getScheduleId(): int
    {
        return $this->scheduleId;
    }

    /**
     * @param int $scheduleId
     * @return MealSetToSchedule
     */
    public function setScheduleId(int $scheduleId): MealSetToSchedule
    {
        $this->scheduleId = $scheduleId;
        return $this;
    }

}
