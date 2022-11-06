<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Core\Database\HelperEntity\SoftDelete;
use App\Core\Database\HelperEntity\UserExtension;
use App\Persisters\AmountTypePersister;
use App\Repository\AmountTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

///**
// * @ApiResource(
// *      collectionOperations={
// *          "get"={
// *              "security"="is_granted('ROLE_AMOUNT_TYPE_GET')",
// *              "normalization_context"={"groups"={"amount_type_read"}}
// *          },
// *          "post"={
// *              "security"="is_granted('ROLE_AMOUNT_TYPE_POST')",
// *              "normalization_context"={"groups"={"amount_type_read"}},
// *              "denormalization_context"={"groups"={"amount_type_write"}}
// *          },
// *     },
// *     itemOperations={
// *          "get"={
// *              "security"="is_granted('ROLE_AMOUNT_TYPE_GET')",
// *              "normalization_context"={"groups"={"amount_type_read"}}
// *          },
// *          "put"={
// *              "security"="is_granted('ROLE_AMOUNT_TYPE_PUT')",
// *              "normalization_context"={"groups"={"amount_type_read"}},
// *              "denormalization_context"={"groups"={"amount_type_update"}}
// *          },
// *          "delete"={
// *              "security"="is_granted('ROLE_AMOUNT_TYPE_DELETE')",
// *              "denormalization_context"={"groups"={"amount_type_delete"}}
// *          }
// *     }
// * )
// * @ORM\Entity(repositoryClass=AmountTypeRepository::class)
// * @ApiFilter(SearchFilter::class, properties={"name": "ipartial", "description": "ipartial"})
// * @ApiFilter(OrderFilter::class, properties={"id","name", "description"}, arguments={"orderParameterName"="order"})
// */

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
    processor: AmountTypePersister::class
)]
#[Delete(
    security: "is_granted('ROLE_AMOUNT_TYPE_DELETE', object)",
    processor: AmountTypePersister::class
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
