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
{% block AdditionalMapping '' %}
    }
{% endblock %}
