<?php

namespace App\Entity\Interfaces;

interface NutritionalValuesInterface
{
    public function getProtein(): ?float;
    public function setProtein(?float $protein);

    public function getCarbohydrate(): ?float;
    public function setCarbohydrate(?float $carbohydrate);

    public function getFat(): ?float;
    public function setFat(?float $fat);

    public function getCalorie(): ?float;
    public function setCalorie(?float $calorie);
}