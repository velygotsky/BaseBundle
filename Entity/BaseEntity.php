<?php

namespace Velygotsky\BaseBundle\Entity;

/**
 * BaseEntity.
 */
abstract class BaseEntity
{
    /**
     * Returns the array of properties allowed to call.
     *
     * @return array The array of properties allowed to call.
     */
    protected function getAllowedProperties()
    {
        // Get current object constants.
        $reflection = new \ReflectionClass($this->getClassNamespace());
        $constants = $reflection->getConstants();

        // Get current object properties.
        $properties = $reflection->getProperties();
        unset($reflection);

        $callable = array();
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            foreach ($constants as $constantName => $constantValue) {
                $matches = array();
                if (preg_match('/^'.$propertyName.'(.+)$/', strtolower($constantName), $matches)) {
                    if (false === isset($callable[$propertyName])) {
                        $callable[$propertyName] = array();
                    }
                    $callable[$propertyName][] = $constantValue;
                }
            }
        }

        return $callable;
    }

    protected function getClassNamespace()
    {
        $classNamespace = get_called_class();
        if (false !== strpos($classNamespace, '\\__CG__\\')) {
            $e = explode('\\__CG__\\', $classNamespace);
            $lastElement = end($e);
            if (false !== $lastElement) {
                $classNamespace = $lastElement;
            }
        }

        return $classNamespace;
    }

    /**
     * Is triggered when invoking inaccessible methods in an object context.
     *
     * @param string $method The method name.
     * @param array  $args   The arguments of method.
     *
     * @return bool True if attribute equals to value. Otherwise, False.
     *
     * @throws \LogicException When method is not supported.
     */
    public function __call($method, $args)
    {
        // Allowed properties with array of all possible values.
        foreach ($this->getAllowedProperties() as $allowedProperty => $allowedValues) {
            $matches = array();
            if (preg_match('/^is'.ucfirst($allowedProperty).'(.+)$/', $method, $matches)) {
                // Get the underscored property value.
                $propertyValue = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $matches[1]));
                // Check is current property value is one of possible attribute values.
                if (false === in_array($propertyValue, $allowedValues)) {
                    throw new \LogicException(sprintf(
                        '%s "%s" is not supported by %s entity.',
                        ucfirst($allowedProperty), $propertyValue, get_class($this)
                    ));
                }
                // Check is getter exists.
                $getter = 'get'.ucfirst($allowedProperty);
                if (!method_exists(get_class($this), $getter)) {
                    throw new \LogicException(sprintf(
                        'Method "%s" is not supported by "%s".',
                        $method, get_class($this)
                    ));
                }

                // Return the result of comparison.
                return $this->$getter() == $propertyValue;
            }
        }

        throw new \LogicException(sprintf(
            'Method "%s" is not supported by "%s".',
            $method, get_class($this)
        ));
    }
}
