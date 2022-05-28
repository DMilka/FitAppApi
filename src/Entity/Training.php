<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Core\Database\HelperEntity\UserExtension;
use App\Repository\TrainingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_TRAINING_GET')",
 *              "normalization_context"={"groups"={"training_read"}}
 *          },
 *          "post"={
 *              "security"="is_granted('ROLE_TRAINING_POST')",
 *              "normalization_context"={"groups"={"training_read"}},
 *              "denormalization_context"={"groups"={"training_write"}}
 *          },
 *     },
 *     itemOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_TRAINING_GET')",
 *              "normalization_context"={"groups"={"training_read"}}
 *          },
 *          "put"={
 *              "security"="is_granted('ROLE_TRAINING_PUT')",
 *              "normalization_context"={"groups"={"training_read"}},
 *              "denormalization_context"={"groups"={"training_update"}}
 *          },
 *          "delete"={
 *              "security"="is_granted('ROLE_TRAINING_DELETE')",
 *              "denormalization_context"={"groups"={"training_delete"}}
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass=TrainingRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"name": "ipartial", "description": "ipartial"})
 * @ApiFilter(OrderFilter::class, properties={"id","name", "description"}, arguments={"orderParameterName"="order"})
 */
class Training extends UserExtension
{
    /**
     * @Groups({"training_read"})
     * @ApiProperty(identifier=true)
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\SequenceGenerator(sequenceName="training_id_seq")
     * @ORM\Column(type="integer", name="id")
     */
    private ?int $id = null;

    /**
     * @Groups({"training_read", "training_write", "training_update"})
     * @ORM\Column(type="string", length=255, name="name")
     */
    private string $name;

    /**
     * @Groups({"training_read", "training_write", "training_update"})
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
