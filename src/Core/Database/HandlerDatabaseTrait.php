<?php

namespace App\Core\Database;

use App\Entity\AmountType;
use App\Entity\Ingredient;
use App\Entity\IngredientToMeal;
use App\Entity\Meal;
use App\Entity\MealSet;
use App\Entity\MealToMealSet;
use App\Entity\Users;
use App\Repository\AmountTypeRepository;
use App\Repository\IngredientRepository;
use App\Repository\IngredientToMealRepository;
use App\Repository\MealRepository;
use App\Repository\MealSetRepository;
use App\Repository\MealToMealSetRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

trait HandlerDatabaseTrait
{
    private function getRepositoryForClass(string $className): EntityRepository
    {
        /** @var EntityRepository $repository */
        $repository = $this->getManager()->getRepository($className);
        return $repository;
    }

    public function getManager(): EntityManager
    {
        /** @var EntityManager $manager */
        $manager = $this->managerRegistry->getManager();
        return $manager;
    }

    public function getUserRepository(): UsersRepository
    {
        return $this->getRepositoryForClass(Users::class);
    }

    public function getAmountTypeRepository(): AmountTypeRepository
    {
        return $this->getRepositoryForClass(AmountType::class);
    }

    public function getIngredientRepository(): IngredientRepository
    {
        return $this->getRepositoryForClass(Ingredient::class);
    }

    public function getIngredientToMealRepository(): IngredientToMealRepository
    {
        return $this->getRepositoryForClass(IngredientToMeal::class);
    }

    public function getMealSetRepository(): MealSetRepository
    {
        return $this->getRepositoryForClass(MealSet::class);
    }

    public function getMealRepository(): MealRepository
    {
        return $this->getRepositoryForClass(Meal::class);
    }

    public function getMealToMealSetRepository(): MealToMealSetRepository
    {
        return $this->getRepositoryForClass(MealToMealSet::class);
    }
}