<?php

namespace Propel\Builder\ORM;

use Propel\Builder\ORM\ORMBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

class BaseActiveRecord extends ORMBuilder
{
    public function getAdditionalMetadata()
    {
        $additionalMetadata = array(
            'generatorType'        => self::getGeneratorTypeName($this->metadata->generatorType),
            'changeTrackingPolicy' => self::getChangeTrackingPolicyName($this->metadata->changeTrackingPolicy),
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
    
    static protected function getConstantName($value, $names = array())
    {
        foreach ($names as $name) {
            if (constant('\Doctrine\ORM\Mapping\ClassMetadata::' . $name) == $value) {
                return $name;
            }
        }
        return false;
    }
    
    public function getVariables()
    {
        return array_merge(parent::getVariables(), array(
            'additionalMetadata' => $this->getAdditionalMetadata(),
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