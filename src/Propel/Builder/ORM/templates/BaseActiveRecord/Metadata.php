{% block Metadata %}

    /**
     * Load the metadata for a Doctrine\ORM\Mapping\Driver\StaticPHPDriver.
     *
     * @param \Doctrine\ORM\Mapping\ClassMetadata $metadata The metadata class.
     */
    static public function loadMetadata(\Doctrine\ORM\Mapping\ClassMetadata $metadata)
    {
{% set generatorTypes = { 1: 'GENERATOR_TYPE_AUTO', 2:'GENERATOR_TYPE_SEQUENCE', 3: 'GENERATOR_TYPE_TABLE', 4: 'GENERATOR_TYPE_IDENTITY', 5: 'GENERATOR_TYPE_NONE' } %}
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::{{ generatorTypes[metadata.generatorType] }});
{% for fieldMapping in metadata.fieldMappings %}
        $metadata->mapField(array(
            'fieldName' => '{{ fieldMapping.fieldName }}',
            'type' => '{{ fieldMapping.type }}',
{% if fieldMapping.columnName %}
            'columnName' => '{{ fieldMapping.columnName }}',
{% endif %}
{% if fieldMapping.length %}
            'length' => {{ fieldMapping.length }},
{% endif %}
{% if fieldMapping.id %}
            'id' => true,
{% endif %}
{% if fieldMapping.nullable %}
            'nullable' => true,
{% endif %}
{% if fieldMapping.columnDefinition %}
            'columnDefinition' => '{{ fieldMapping.columnDefinition }}',
{% endif %}
{% if fieldMapping.precision %}
            'precision' => {{ fieldMapping.precision }},
{% endif %}
{% if fieldMapping.scale %}
            'scale' => {{ fieldMapping.scale }},
{% endif %}
{% if fieldMapping.unique %}
            'unique' => '{{ fieldMapping.unique }}',
{% endif %}
        ));
{% endfor %}
{% set associationTypes = { 1: 'OneToOne', 2:'ManyToOne', 3: 'ToOne', 4: 'OneToMany', 8: 'ManyToMany', 12: 'ToMany' } %}
{% for associationMapping in metadata.associationMappings %}
        $metadata->map{{ associationTypes[associationMapping.type] }}(array(
            'fieldName' => '{{ associationMapping.fieldName }}',
            'targetEntity' => '{{ associationMapping.targetEntity }}',
{% if associationMapping.mappedBy %}
            'mappedBy' => '{{ associationMapping.mappedBy }}',
{% endif %}
{% if associationMapping.inversedBy %}
            'inversedBy' => '{{ associationMapping.inversedBy }}',
{% endif %}
{% if associationMapping.cascade %}
            'cascade' => {{ associationMapping.cascade|var_export(true) }},
{% endif %}
{% if associationMapping.orderBy %}
            'orderBy' => {{ associationMapping.orderBy|var_export(true) }},
{% endif %}
{% if associationMapping.fetch %}
{% set fetchTypes = { 2: 'FETCH_LAZY', 3: 'FETCH_EAGER', 4: 'FETCH_EXTRA_LAZY' } %}
            'fetch' => Doctrine\ORM\Mapping\ClassMetadata::{{ fetchTypes[associationMapping.fetch] }},
{% endif %}
{% if associationMapping.joinTable %}
            'joinTable' => {{ associationMapping.joinTable|var_export(true) }},
{% endif %}
{% if associationMapping.indexBy %}
            'indexBy' => '{{ associationMapping.indexBy }}',
{% endif %}
        ));
{% endfor %}
{% block AdditionalMapping '' %}
    }
{% endblock %}
