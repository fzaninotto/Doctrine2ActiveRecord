<?php

namespace Propel\Builder\ORM;

use Propel\Builder\ORM\ORMBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

class BaseActiveRecord extends ORMBuilder
{
    const MAPPING_STATIC_PHP = 1;
    const MAPPING_ANNOTATION = 2;
    
    protected $mappingDriver = self::MAPPING_STATIC_PHP;
    protected $annotationPrefix = '';
    
    public function setMappingDriver($mappingDriver)
    {
        $this->mappingDriver = $mappingDriver;
    }
    
    public function isMappingStaticPhp()
    {
        return (bool) ($this->mappingDriver & self::MAPPING_STATIC_PHP);
    }
        
    public function isMappingAnnotation()
    {
        return (bool) ($this->mappingDriver & self::MAPPING_ANNOTATION);
    }
    
    public function getAnnotationBuilder()
    {
        return new AnnotationBuilder($this->metadata);
    }

    public function setAnnotationPrefix($annotationPrefix)
    {
        $this->annotationPrefix = $annotationPrefix;
    }
        
    public function getAnnotationPrefix()
    {
        if ($prefix = $this->annotationPrefix) {
            return $prefix . ':';
        }
        return '';
    }
    
    public function getAdditionalMetadata()
    {
        $additionalMetadata = array(
            'generatorType'         => self::getGeneratorTypeName($this->metadata->generatorType),
            'changeTrackingPolicy'  => self::getChangeTrackingPolicyName($this->metadata->changeTrackingPolicy),
            'hasToManyAssociations' => self::getHasToManyAssociations($this->metadata->associationMappings),
        );
        
        return $additionalMetadata;
    }
    
    static protected function getGeneratorTypeName($generatorTypeNumber)
    {
        if ($generatorTypeNumber == ClassMetadata::GENERATOR_TYPE_NONE) {
            return false;
        }

        $generatorTypes  = array(
            'GENERATOR_TYPE_AUTO',
            'GENERATOR_TYPE_SEQUENCE',
            'GENERATOR_TYPE_TABLE',
            'GENERATOR_TYPE_IDENTITY', 
            'GENERATOR_TYPE_NONE',
        );

        return self::getConstantName($generatorTypeNumber, $generatorTypes);
    }
    
    public function getGeneratorTypeShortName($generatorTypeNumber)
    {
        return substr(self::getGeneratorTypeName($generatorTypeNumber), 45);
    }
    
    static protected function getChangeTrackingPolicyName($changeTrackingPolicyNumber)
    {
        if ($changeTrackingPolicyNumber == ClassMetadata::CHANGETRACKING_DEFERRED_IMPLICIT) {
            return false;
        }
        $changeTrackingPolicies = array(
            'CHANGETRACKING_DEFERRED_IMPLICIT',
            'CHANGETRACKING_DEFERRED_EXPLICIT',
            'CHANGETRACKING_NOTIFY',
        );

        return self::getConstantName($changeTrackingPolicyNumber, $changeTrackingPolicies);
    }
    
    static protected function getHasToManyAssociations($associationMappings = array())
    {
        foreach ($associationMappings as $associationMapping) {
            if (!self::isToOneAssociation($associationMapping['type'])) {
                return true;
            }
        }

        return false;
    }
    
    static protected function getConstantName($value, $names = array())
    {
        foreach ($names as $name) {
            if (constant('\Doctrine\ORM\Mapping\ClassMetadata::' . $name) == $value) {
                return $name;
            }
        }

        return false;
    }
    
    static protected function isToOneAssociation($associationType)
    {
        return (bool) ($associationType & ClassMetadata::TO_ONE);
    }

    static protected function isToManyAssociation($associationType)
    {
        return (bool) ($associationType & ClassMetadata::TO_MANY);
    }    
    
    protected function getAssociationDetails()
    {
        $associationTypes = array(
            ClassMetadata::ONE_TO_ONE   => 'OneToOne',
            ClassMetadata::MANY_TO_ONE  => 'ManyToOne',
            ClassMetadata::ONE_TO_MANY  => 'OneToMany',
            ClassMetadata::MANY_TO_MANY => 'ManyToMany',
        );
        $fetchTypes = array(
            'FETCH_LAZY',
            'FETCH_EAGER',
            'FETCH_EXTRA_LAZY',
        );
        $associationDetails = array();
        foreach ($this->metadata->associationMappings as $key => $associationMapping) {
            $associationDetail = array();
            $associationDetail['type'] = $associationTypes[$associationMapping['type']];
            if (self::isToOneAssociation($associationMapping['type'])) {
                $associationDetail['isToOne'] = true;
                $associationDetail['targetEntity'] = '\\' .  $associationMapping['targetEntity'];
             } else {
                $associationDetail['isToOne'] = false;
                $associationDetail['targetEntity'] = '\\Doctrine\\Common\\Collections\\ArrayCollection';
             }
            if (isset($associationMapping['fetch'])) {
                $associationDetail['fetch'] = self::getConstantName($associationMapping['fetch'], $fetchTypes);
            }
            $associationDetails[$key] = $associationDetail;
        }

        return $associationDetails;
    }
    
    public function getInheritanceDetails()
    {
        $inheritanceTypes = array(
            'INHERITANCE_TYPE_NONE',
            'INHERITANCE_TYPE_JOINED',
            'INHERITANCE_TYPE_SINGLE_TABLE',
            'INHERITANCE_TYPE_TABLE_PER_CLASS',
        );
        $inheritanceDetails = array();
        if ($this->metadata->inheritanceType != ClassMetadata::INHERITANCE_TYPE_NONE) {
            $inheritanceDetails['type'] = self::getConstantName($this->metadata->inheritanceType, $inheritanceTypes);
            
        }

        return $inheritanceDetails;
    }
    
    public function getVariables()
    {
        return array_merge(parent::getVariables(), array(
            'additionalMetadata' => $this->getAdditionalMetadata(),
            'associationDetails' => $this->getAssociationDetails(),
            'inheritanceDetails' => $this->getInheritanceDetails(),
        ));
    }
    
    public function getNamespace()
    {
        if ($namespace = parent::getNamespace()) {
            return $namespace . '\\Base';
        }

        return 'Base';
    }
}
