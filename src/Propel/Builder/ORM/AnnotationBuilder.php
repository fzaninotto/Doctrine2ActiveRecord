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
    
    public function getAssociationMappingAnnotation(array $associationMapping)
    {
        $type = null;
        switch ($associationMapping['type']) {
            case ClassMetadataInfo::ONE_TO_ONE:
                $type = 'OneToOne';
                break;
            case ClassMetadataInfo::MANY_TO_ONE:
                $type = 'ManyToOne';
                break;
            case ClassMetadataInfo::ONE_TO_MANY:
                $type = 'OneToMany';
                break;
            case ClassMetadataInfo::MANY_TO_MANY:
                $type = 'ManyToMany';
                break;
        }
        $typeOptions = array();

        if (isset($associationMapping['targetEntity'])) {
            $typeOptions[] = 'targetEntity="' . $associationMapping['targetEntity'] . '"';
        }

        if (isset($associationMapping['inversedBy'])) {
            $typeOptions[] = 'inversedBy="' . $associationMapping['inversedBy'] . '"';
        }

        if (isset($associationMapping['mappedBy'])) {
            $typeOptions[] = 'mappedBy="' . $associationMapping['mappedBy'] . '"';
        }

        if ($associationMapping['cascade']) {
            $cascades = array();

            if ($associationMapping['isCascadePersist']) $cascades[] = '"persist"';
            if ($associationMapping['isCascadeRemove']) $cascades[] = '"remove"';
            if ($associationMapping['isCascadeDetach']) $cascades[] = '"detach"';
            if ($associationMapping['isCascadeMerge']) $cascades[] = '"merge"';
            if ($associationMapping['isCascadeRefresh']) $cascades[] = '"refresh"';

            $typeOptions[] = 'cascade={' . implode(',', $cascades) . '}';            
        }

        if (isset($associationMapping['orphanRemoval']) && $associationMapping['orphanRemoval']) {
            $typeOptions[] = 'orphanRemoval=' . ($associationMapping['orphanRemoval'] ? 'true' : 'false');
        }

        return $type . '(' . implode(', ', $typeOptions) . ')';
   }
   
   public function getJoinColumnAnnotation($joinColumn)
   {
        $joinColumnAnnot = array();

        if (isset($joinColumn['name'])) {
            $joinColumnAnnot[] = 'name="' . $joinColumn['name'] . '"';
        }

        if (isset($joinColumn['referencedColumnName'])) {
            $joinColumnAnnot[] = 'referencedColumnName="' . $joinColumn['referencedColumnName'] . '"';
        }

        if (isset($joinColumn['unique']) && $joinColumn['unique']) {
            $joinColumnAnnot[] = 'unique=' . ($joinColumn['unique'] ? 'true' : 'false');
        }

        if (isset($joinColumn['nullable'])) {
            $joinColumnAnnot[] = 'nullable=' . ($joinColumn['nullable'] ? 'true' : 'false');
        }

        if (isset($joinColumn['onDelete'])) {
            $joinColumnAnnot[] = 'onDelete=' . ($joinColumn['onDelete'] ? 'true' : 'false');
        }

        if (isset($joinColumn['onUpdate'])) {
            $joinColumnAnnot[] = 'onUpdate=' . ($joinColumn['onUpdate'] ? 'true' : 'false');
        }

        if (isset($joinColumn['columnDefinition'])) {
            $joinColumnAnnot[] = 'columnDefinition="' . $joinColumn['columnDefinition'] . '"';
        }

        return 'JoinColumn(' . implode(', ', $joinColumnAnnot) . ')';
   }

   public function getJoinTableAnnotation($joinTable)
   {
        $joinTableAnnot = array();
        $joinTableAnnot[] = 'name="' . $joinTable['name'] . '"';

        if (isset($joinTable['schema'])) {
            $joinTableAnnot[] = 'schema="' . $joinTable['schema'] . '"';
        }

        return 'JoinTable(' . implode(', ', $joinTableAnnot) . ',';
   }
}