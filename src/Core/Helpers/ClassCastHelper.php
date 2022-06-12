<?php

namespace App\Core\Helpers;

use ReflectionObject;

class ClassCastHelper
{
    /**
     * Class casting
     *
     * @param string|object $destination
     * @param object $sourceObject
     * @return object
     */
    public static function cast($destination, $sourceObject)
    {
        if (is_string($destination)) {
            $destination = new $destination();
        }
        $sourceReflection = new ReflectionObject($sourceObject);
        $destinationReflection = new ReflectionObject($destination);
        $sourceProperties = $sourceReflection->getProperties();
        foreach ($sourceProperties as $sourceProperty) {
            $sourceProperty->setAccessible(true);
            $name = $sourceProperty->getName();
            $value = $sourceProperty->getValue($sourceObject);
            if ($destinationReflection->hasProperty($name)) {
                $propDest = $destinationReflection->getProperty($name);
                $propDest->setAccessible(true);
                $propDest->setValue($destination, $value);
            } else {
                $destination->$name = $value;
            }
        }
        return $destination;
    }

    public static function getClassNameSpace(string $className): ?string
    {
        try {
            $class = new \ReflectionClass($className);
            $classNameSpace = $class->getNamespaceName();

            if ($classNameSpace) {
                return $classNameSpace;
            }
        } catch (\Exception $exception) {
            throw new $exception;
        }

        return null;
    }

    public static function getEntitySetter(string $className, string $propertyName): ?string
    {
        if (class_exists($className)) {
            if (property_exists($className, $propertyName)) {
                if (method_exists($className, 'set' . ucfirst($propertyName))) {
                    return 'set' . ucfirst($propertyName);
                }
            }
        }

        return null;
    }
}