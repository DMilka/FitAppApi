<?php

namespace App\Core\Helpers;

use Doctrine\ORM\EntityManager;
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
                if (method_exists($className, 'set' . ClassCastHelper::camelize($propertyName))) {
                    return 'set' . ClassCastHelper::camelize($propertyName);
                }
            }
        }

        return null;
    }

    public static function camelize($input, $separator = '_')
    {
        return str_replace($separator, '', ucwords($input, $separator));
    }

    public static function updateObject(object $entity, object $object, EntityManager $entityManager): void
    {
        $classMetaData = $entityManager->getClassMetadata(get_class($object));
        $columnNames = $classMetaData->getColumnNames();

        foreach ($columnNames as $columnName) {
            $fieldName = $classMetaData->getFieldForColumn($columnName);

            /**
             * @TODO: find way to skip id assign when someone names it e.g example_id
             */
            if ($fieldName === 'id') {
                continue;
            }

            $getter = 'get' . ClassCastHelper::camelize($fieldName);
            if (!method_exists(get_class($object), $getter)) {
                $getter = 'is' . ClassCastHelper::camelize($fieldName);

                if (!method_exists(get_class($object), $getter)) {
                    if (property_exists(get_class($object), $fieldName)) {
                        $entity->{$fieldName} = $object->{$fieldName};
                        continue;
                    }
                }
            }

            $setter = ClassCastHelper::getEntitySetter(get_class($entity), $fieldName);
            $entity->$setter($object->$getter());
        }
    }
}