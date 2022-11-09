<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Core\Database\HelperEntity\UserExtension;
use App\EntityProcesses\AmountType\AmountTypeDeleteProcess;
use App\EntityProcesses\AmountType\AmountTypePostProcess;
use App\EntityProcesses\AmountType\AmountTypePutProcess;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ApiResource]
#[Get(
    security: "is_granted('ROLE_AMOUNT_TYPE_GET')",
)]
#[GetCollection(
    security: "is_granted('ROLE_AMOUNT_TYPE_GET')",
)]
#[Post(
    security: "is_granted('ROLE_AMOUNT_TYPE_POST')",
    processor: AmountTypePostProcess::class
)]
#[Put(
    security: "is_granted('ROLE_AMOUNT_TYPE_PUT')",
    processor: AmountTypePutProcess::class
)]
#[Delete(
    security: "is_granted('ROLE_AMOUNT_TYPE_DELETE', object)",
    processor: AmountTypeDeleteProcess::class
)]
class AmountType extends UserExtension
{
    #[Orm\Id, ORM\Column(name: 'id', type:'integer'), ORM\GeneratedValue]
    private ?int $id = null;

    #[Orm\Column(name:'name',type: 'string')]
    private string $name;

    #[Orm\Column(name:'description',type: 'string', nullable: true)]
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
