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
{% if fieldMapping.length is defined %}
            'length' => {{ fieldMapping.length }},
{% endif %}
{% if fieldMapping.id is defined %}
            'id' => true,
{% endif %}
{% if fieldMapping.nullable is defined %}
            'nullable' => true,
{% endif %}
{% if fieldMapping.columnDefinition is defined %}
            'columnDefinition' => '{{ fieldMapping.columnDefinition }}',
{% endif %}
{% if fieldMapping.precision is defined %}
            'precision' => {{ fieldMapping.precision }},
{% endif %}
{% if fieldMapping.scale is defined %}
            'scale' => {{ fieldMapping.scale }},
{% endif %}
{% if fieldMapping.unique is defined %}
            'unique' => '{{ fieldMapping.unique }}',
{% endif %}
        ));
{% endfor %}
{% set associationTypes = { 1: 'OneToOne', 2:'ManyToOne', 3: 'ToOne', 4: 'OneToMany', 8: 'ManyToMany', 12: 'ToMany' } %}
{% for associationMapping in metadata.associationMappings %}
        $metadata->map{{ associationTypes[associationMapping.type] }}(array(
            'fieldName' => '{{ associationMapping.fieldName }}',
            'targetEntity' => '{{ associationMapping.targetEntity }}',
{% if associationMapping.mappedBy is defined %}
            'mappedBy' => '{{ associationMapping.mappedBy }}',
{% endif %}
{% if associationMapping.inversedBy is defined %}
            'inversedBy' => '{{ associationMapping.inversedBy }}',
{% endif %}
{% if associationMapping.cascade is defined %}
            'cascade' => {{ associationMapping.cascade|exportArray }},
{% endif %}
{% if associationMapping.orderBy is defined %}
            'orderBy' => {{ associationMapping.orderBy|exportArray }},
{% endif %}
{% if associationMapping.fetch is defined %}
{% set fetchTypes = { 2: 'FETCH_LAZY', 3: 'FETCH_EAGER', 4: 'FETCH_EXTRA_LAZY' } %}
            'fetch' => \Doctrine\ORM\Mapping\ClassMetadata::{{ fetchTypes[associationMapping.fetch] }},
{% endif %}
{% if associationMapping.joinTable is defined %}
            'joinTable' => {{ associationMapping.joinTable|exportArray }},
{% endif %}
{% if associationMapping.joinColumns is defined %}
            'joinColumns' => {{ associationMapping.joinColumns|exportArray }},
{% endif %}
{% if associationMapping.indexBy is defined %}
            'indexBy' => '{{ associationMapping.indexBy }}',
{% endif %}
        ));
{% endfor %}
{% block AdditionalMapping '' %}
    }
{% endblock %}
