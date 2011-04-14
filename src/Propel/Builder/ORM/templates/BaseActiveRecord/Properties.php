{% block Properties %}
{% for fieldMapping in metadata.fieldMappings %}

    /**
     * @var {{ fieldMapping.type }} ${{ fieldMapping.fieldName }} {{ fieldMapping.columnDefinition is defined ? fieldMapping.columnDefinition : '' }}
     */
    protected ${{ fieldMapping.fieldName }}{% if fieldMapping.default is defined %} = {{ fieldMapping.default|var_export(true) }}{% endif %};
{% endfor %}
{% for associationMapping in metadata.associationMappings %}

    /**
     * @var mixed ${{ associationMapping.fieldName }}
     */
    protected ${{ associationMapping.fieldName }};
{% endfor %}
{% block AdditionalProperties '' %}
{% endblock %}
