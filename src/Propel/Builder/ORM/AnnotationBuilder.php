<?php

namespace Propel\Builder\ORM;

use Doctrine\ORM\Mapping\ClassMetadataInfo;

class AnnotationBuilder
{
    protected $metadata;

    public function __construct(ClassMetadataInfo $metadata)
    {
        $this->metadata = $metadata;
    }
    
    public static function getFieldMappingColumnAnnotation(array $fieldMapping)
    {
        $column = array();
        if (isset($fieldMapping['columnName'])) {
            $column[] = 'name="' . $fieldMapping['columnName'] . '"';
        }

        if (isset($fieldMapping['type'])) {
            $column[] = 'type="' . $fieldMapping['type'] . '"';
        }

        if (isset($fieldMapping['length'])) {
            $column[] = 'length=' . $fieldMapping['length'];
        }

        if (isset($fieldMapping['precision'])) {
            $column[] = 'precision=' .  $fieldMapping['precision'];
        }

        if (isset($fieldMapping['scale'])) {
            $column[] = 'scale=' . $fieldMapping['scale'];
        }

        if (isset($fieldMapping['nullable'])) {
            $column[] = 'nullable=' .  var_export($fieldMapping['nullable'], true);
        }

        if (isset($fieldMapping['columnDefinition'])) {
            $column[] = 'columnDefinition="' . $fieldMapping['columnDefinition'] . '"';
        }

        if (isset($fieldMapping['unique'])) {
            $column[] = 'unique=' . var_export($fieldMapping['unique'], true);
        }

        return 'Column(' . implode(', ', $column) . ')';
    }
    
    
    public function getSequenceGeneratorAnnotation()
    {
        $sequenceGenerator = array();

        if (isset($this->metadata->sequenceGeneratorDefinition['sequenceName'])) {
            $sequenceGenerator[] = 'sequenceName="' . $this->metadata->sequenceGeneratorDefinition['sequenceName'] . '"';
        }

        if (isset($this->metadata->sequenceGeneratorDefinition['allocationSize'])) {
            $sequenceGenerator[] = 'allocationSize="' . $this->metadata->sequenceGeneratorDefinition['allocationSize'] . '"';
        }

        if (isset($this->metadata->sequenceGeneratorDefinition['initialValue'])) {
            $sequenceGenerator[] = 'initialValue="' . $this->metadata->sequenceGeneratorDefinition['initialValue'] . '"';
        }

        return 'SequenceGenerator(' . implode(', ', $sequenceGenerator) . ')';
    }

    public function getDiscriminatorColumnAnnotation()
    {
        $discrColumn = $this->metadata->discriminatorColumn;
        $discrColumnDetails = array();
        if (isset($discrColumn['name'])) {
            $discrColumnDetails[] = 'name="' . $discrColumn['name'] . '"';
        }
        if (isset($discrColumn['type'])) {
            $discrColumnDetails[] = 'type="' . $discrColumn['type'] . '"';
        }
        if (isset($discrColumn['length']) && '' !== $discrColumn['length']) {
            $discrColumnDetails[] = 'length=' . $discrColumn['length'];
        }

        return 'DiscriminatorColumn(' . implode(', ', $discrColumnDetails) . ')';
    }

    public function getDiscriminatorMapAnnotation()
    {
        $inheritanceClassMap = array();

        foreach ($this->metadata->discriminatorMap as $type => $class) {
            $inheritanceClassMap[] .= '"' . $type . '" = "' . $class . '"';
        }

        return 'DiscriminatorMap({' . implode(', ', $inheritanceClassMap) . '})';
    }

    public function getEntityAnnotation()
    {
        if ($this->metadata->isMappedSuperclass) {
            $annotation = 'MappedSupperClass';
        } else {
            $annotation = 'Entity';
        }

        if ($this->metadata->customRepositoryClassName) {
            $annotation .= '(repositoryClass="' . $this->metadata->customRepositoryClassName . '")';
        }
        
        return $annotation;
    }
}