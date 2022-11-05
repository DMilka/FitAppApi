<?php

namespace App\Entity;

use App\Core\Database\HelperEntity\SoftDelete;
use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Core\Authentication\RegisterController;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"users_read"}}
 *          },
 *          "post"={
 *              "normalization_context"={"groups"={"users_read"}},
 *              "denormalization_context"={"groups"={"users_write"}}
 *          },
 *          "register"={
 *              "normalization_context"={"groups"={"users_read"}},
 *              "denormalization_context"={"groups"={"users_write"}},
 *              "method"="POST",
 *              "path"="/api/register",
 *              "controller"=RegisterController::class,
 *          }
 *
 *     }
 * )
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users extends SoftDelete implements UserInterface
{
    /**
     * @Groups({"users_read", "users_write"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"users_read", "users_write"})
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles()
    {
        return ['ROLE_USER',
                'ROLE_INGREDIENT_GET',
                'ROLE_INGREDIENT_POST',
                'ROLE_INGREDIENT_GET',
                'ROLE_INGREDIENT_PUT',
                'ROLE_INGREDIENT_DELETE',
                'ROLE_AMOUNT_TYPE_POST',
                'ROLE_AMOUNT_TYPE_GET',
                'ROLE_AMOUNT_TYPE_PUT',
                'ROLE_AMOUNT_TYPE_DELETE',
                'ROLE_INGREDIENT_TO_MEAL_POST',
                'ROLE_INGREDIENT_TO_MEAL_GET',
                'ROLE_INGREDIENT_TO_MEAL_PUT',
                'ROLE_INGREDIENT_TO_MEAL_DELETE',
                'ROLE_MEAL_POST',
                'ROLE_MEAL_GET',
                'ROLE_MEAL_PUT',
                'ROLE_MEAL_DELETE',
                'ROLE_MEAL_SET_POST',
                'ROLE_MEAL_SET_GET',
                'ROLE_MEAL_SET_PUT',
                'ROLE_MEAL_SET_DELETE',
                'ROLE_MEAL_TO_MEAL_SET_POST',
                'ROLE_MEAL_TO_MEAL_SET_GET',
                'ROLE_MEAL_TO_MEAL_SET_PUT',
                'ROLE_MEAL_TO_MEAL_SET_DELETE',
                'ROLE_TRAINING_POST',
                'ROLE_TRAINING_GET',
                'ROLE_TRAINING_PUT',
                'ROLE_TRAINING_DELETE',
                'ROLE_TRAINING_SET_POST',
                'ROLE_TRAINING_SET_GET',
                'ROLE_TRAINING_SET_PUT',
                'ROLE_TRAINING_SET_DELETE',
                "ROLE_ENTITY_CONNECTOR_CREATOR",
                "ROLE_ENTITY_CONNECTOR_CREATOR_POST",
                "ROLE_ENTITY_CONNECTOR_CREATOR_PUT"
        ];
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        return null;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }

    public function getUserIdentifier(): string
    {
        // TODO: Implement getUserIdentifier() method.
        return '';
    }
}
