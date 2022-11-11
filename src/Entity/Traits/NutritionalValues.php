<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;


trait NutritionalValues
{
    #[Orm\Column(name:'protein',type: 'float')]
    protected float $protein = 0.0;

    #[Orm\Column(name:'carbohydrate',type: 'float')]
    protected float $carbohydrate = 0.0;

    #[Orm\Column(name:'fat',type: 'float')]
    protected float $fat = 0.0;

    #[Orm\Column(name:'calorie',type: 'float')]
    protected float $calorie = 0.0;
}