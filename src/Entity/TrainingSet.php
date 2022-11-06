<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Core\Database\HelperEntity\UserExtension;
use App\Repository\TrainingSetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
//
///**
// * @ApiResource(
// *      collectionOperations={
// *          "get"={
// *              "security"="is_granted('ROLE_TRAINING_SET_GET')",
// *              "normalization_context"={"groups"={"training_set_read"}}
// *          },
// *          "post"={
// *              "security"="is_granted('ROLE_TRAINING_SET_POST')",
// *              "normalization_context"={"groups"={"training_set_read"}},
// *              "denormalization_context"={"groups"={"training_set_write"}}
// *          },
// *     },
// *     itemOperations={
// *          "get"={
// *              "security"="is_granted('ROLE_TRAINING_SET_GET')",
// *              "normalization_context"={"groups"={"training_set_read"}}
// *          },
// *          "put"={
// *              "security"="is_granted('ROLE_TRAINING_SET_PUT')",
// *              "normalization_context"={"groups"={"training_set_read"}},
// *              "denormalization_context"={"groups"={"training_set_update"}}
// *          },
// *          "delete"={
// *              "security"="is_granted('ROLE_TRAINING_SET_DELETE')",
// *              "denormalization_context"={"groups"={"training_set_delete"}}
// *          }
// *     }
// * )
// * @ORM\Entity(repositoryClass=TrainingSetRepository::class)
// * @ApiFilter(SearchFilter::class, properties={"name": "ipartial", "description": "ipartial"})
// * @ApiFilter(OrderFilter::class, properties={"id","name", "description"}, arguments={"orderParameterName"="order"})
// */

#[ORM\Entity]
#[ApiResource]
class TrainingSet extends UserExtension
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
     * @return TrainingSet
     */
    public function setName(string $name): TrainingSet
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
     * @return TrainingSet
     */
    public function setDescription(?string $description): TrainingSet
    {
        $this->description = $description;
        return $this;
    }
}
