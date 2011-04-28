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
            'associationDetails' => self::getAssociationDetails($this->metadata->associationMappings),
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
    
    protected function getAssociationDetails()
    {
        $associationTypes = array(
            ClassMetadata::ONE_TO_ONE   => 'OneToOne',
            ClassMetadata::MANY_TO_ONE  => 'ManyToOne',
            ClassMetadata::TO_ONE       => 'ToOne',
            ClassMetadata::ONE_TO_MANY  => 'OneToMany',
            ClassMetadata::MANY_TO_MANY => 'ManyToMany',
            ClassMetadata::TO_MANY      => 'ToMany',
        );
        $toOneAssociationTypes = array(
            ClassMetadata::ONE_TO_ONE,
            ClassMetadata::MANY_TO_ONE,
            ClassMetadata::TO_ONE,
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
            if (in_array($associationMapping['type'], $toOneAssociationTypes)) {
                $associationDetail['targetEntity'] = '\\' .  $associationMapping['targetEntity'];
                $associationDetail['targetEntityDescription'] = 'The related entity';
            } else {
                $associationDetail['targetEntity'] = '\\Doctrine\\Common\\Collections\\ArrayCollection';
                $associationDetail['targetEntityDescription'] = 'The collection of related entities';
            }
            if (isset($associationMapping['fetch'])) {
                $associationDetail['fetch'] = self::getConstantName($associationMapping['fetch'], $fetchTypes);
            }
            $associationDetails[$key] = $associationDetail;
        }
        return $associationDetails;
    }
    
    public function getVariables()
    {
        return array_merge(parent::getVariables(), array(
            'additionalMetadata' => $this->getAdditionalMetadata(),
            'associationDetails' => $this->getAssociationDetails(),
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