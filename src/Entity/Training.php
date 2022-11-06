<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;

use App\Core\Database\HelperEntity\UserExtension;

///**
// * @ApiResource(
// *      collectionOperations={
// *          "get"={
// *              "security"="is_granted('ROLE_TRAINING_GET')",
// *              "normalization_context"={"groups"={"training_read"}}
// *          },
// *          "post"={
// *              "security"="is_granted('ROLE_TRAINING_POST')",
// *              "normalization_context"={"groups"={"training_read"}},
// *              "denormalization_context"={"groups"={"training_write"}}
// *          },
// *     },
// *     itemOperations={
// *          "get"={
// *              "security"="is_granted('ROLE_TRAINING_GET')",
// *              "normalization_context"={"groups"={"training_read"}}
// *          },
// *          "put"={
// *              "security"="is_granted('ROLE_TRAINING_PUT')",
// *              "normalization_context"={"groups"={"training_read"}},
// *              "denormalization_context"={"groups"={"training_update"}}
// *          },
// *          "delete"={
// *              "security"="is_granted('ROLE_TRAINING_DELETE')",
// *              "denormalization_context"={"groups"={"training_delete"}}
// *          }
// *     }
// * )
// * @ORM\Entity(repositoryClass=TrainingRepository::class)
// * @ApiFilter(SearchFilter::class, properties={"name": "ipartial", "description": "ipartial"})
// * @ApiFilter(OrderFilter::class, properties={"id","name", "description"}, arguments={"orderParameterName"="order"})
// */

#[ORM\Entity]
#[ApiResource]
class Training extends UserExtension
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

    /**
     * @param string|null $name
     * @return Training
     */
    public function setName(string $name): Training
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
     * @return Training
     */
    public function setDescription(?string $description): Training
    {
        $this->description = $description;
        return $this;
    }
}
