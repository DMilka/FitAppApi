<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\EntityProcesses\Schedule\ScheduleDeleteProcess;
use App\EntityProcesses\Schedule\SchedulePostProcess;
use App\EntityProcesses\Schedule\SchedulePutProcess;
use App\Repository\ScheduleRepository;
use Doctrine\ORM\Mapping as ORM;

use App\Core\Database\HelperEntity\UserExtension;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(
    repositoryClass: ScheduleRepository::class
)]
#[ApiResource]
#[Get(
    normalizationContext: ['groups' => ['schedule_get']],
    security: "is_granted('ROLE_SCHEDULE_GET')",
)]
#[GetCollection(
    normalizationContext: ['groups' => ['schedule_get']],
    security: "is_granted('ROLE_SCHEDULE_GET')",
)]
#[Post(
    normalizationContext: ['groups' => ['schedule_get']],
    denormalizationContext: ['groups' => ['schedule_post']],
    security: "is_granted('ROLE_SCHEDULE_POST')",
    processor: SchedulePostProcess::class
)]
#[Put(
    normalizationContext: ['groups' => ['schedule_get']],
    denormalizationContext: ['groups' => ['schedule_put']],
    security: "is_granted('ROLE_SCHEDULE_PUT')",
    processor: SchedulePutProcess::class
)]
#[Delete(
    denormalizationContext: ['groups' => ['schedule_delete']],
    security: "is_granted('ROLE_SCHEDULE_DELETE', object)",
    processor: ScheduleDeleteProcess::class
)]
class Schedule extends UserExtension
{
    #[Orm\Id, ORM\Column(name: 'id', type:'integer'), ORM\GeneratedValue]
    #[Groups(['schedule_get'])]
    private ?int $id = null;

    #[Orm\Column(name:'planned_at',type: 'date')]
    #[Groups(['schedule_get', 'schedule_post', 'schedule_put', 'schedule_delete'])]
    private \DateTime $plannedAt;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getPlannedAt(): \DateTime
    {
        return $this->plannedAt;
    }

    /**
     * @param \DateTime $plannedAt
     * @return Schedule
     */
    public function setPlannedAt(\DateTime $plannedAt): Schedule
    {
        $this->plannedAt = $plannedAt;
        return $this;
    }

}
