<?php

namespace Szykra\NamingStrategy;

use Doctrine\ORM\Mapping\NamingStrategy;
use ICanBoogie\Inflector;

class ResourceNamingStrategy implements NamingStrategy
{

    /**
     * @var Inflector
     */
    private $inflector;

    public function __construct($locale = "en")
    {
        $this->inflector = Inflector::get($locale);
    }

    /**
     * Returns a table name for an entity class.
     *
     * @param string $className The fully-qualified class name.
     *
     * @return string A table name.
     */
    function classToTableName($className)
    {
        if (strpos($className, "\\") !== false) {
            $className = substr($className, strrpos($className, "\\") + 1);
        }

        $tableName = $this->inflector->pluralize($className);
        $tableName = $this->inflector->underscore($tableName);

        return $tableName;
    }

    /**
     * Returns a column name for a property.
     *
     * @param string      $propertyName A property name.
     * @param string|null $className    The fully-qualified class name.
     *
     * @return string A column name.
     */
    function propertyToColumnName($propertyName, $className = null)
    {
        return $this->inflector->underscore($propertyName);
    }

    /**
     * Returns a column name for an embedded property.
     *
     * @param string $propertyName
     * @param string $embeddedColumnName
     *
     * @return string
     */
    function embeddedFieldToColumnName($propertyName, $embeddedColumnName, $className = null, $embeddedClassName = null)
    {
        $propertyName = $this->propertyToColumnName($propertyName);
        $embeddedColumnName = $this->propertyToColumnName($embeddedColumnName);

        return $propertyName . "_" . $embeddedColumnName;
    }

    /**
     * Returns the default reference column name.
     *
     * @return string A column name.
     */
    function referenceColumnName()
    {
        return 'id';
    }

    /**
     * Returns a join column name for a property.
     *
     * @param string      $propertyName A property name.
     * @param string|null $className    The fully-qualified class name.
     *                                  This parameter is omitted from the signature due to BC
     *
     * @return string A join column name.
     */
    function joinColumnName($propertyName/*, $className = null*/)
    {
        return $this->propertyToColumnName($propertyName) . '_' . $this->referenceColumnName();
    }

    /**
     * Returns a join table name.
     *
     * @param string      $sourceEntity The source entity.
     * @param string      $targetEntity The target entity.
     * @param string|null $propertyName A property name.
     *
     * @return string A join table name.
     */
    function joinTableName($sourceEntity, $targetEntity, $propertyName = null)
    {
        $names = [
            $this->propertyToColumnName($sourceEntity),
            $this->propertyToColumnName($targetEntity)
        ];

        sort($names);

        return implode("_", $names);
    }

    /**
     * Returns the foreign key column name for the given parameters.
     *
     * @param string      $entityName           An entity.
     * @param string|null $referencedColumnName A property.
     *
     * @return string A join column name.
     */
    function joinKeyColumnName($entityName, $referencedColumnName = null)
    {
        return $this->propertyToColumnName($entityName) . "_" . ($referencedColumnName ?: $this->referenceColumnName());
    }

}
