{% block Properties %}
{% for fieldMapping in metadata.fieldMappings %}

    /**
     * @var {{ fieldMapping.type }} ${{ fieldMapping.fieldName }} {{ fieldMapping.columnDefinition }}
     */
    protected ${{ fieldMapping.fieldName }}{% if fieldMapping.default %} = {{ fieldMapping.default|var_export(true) }}{% endif %};
{% endfor %}
{% for associationMapping in metadata.associationMappings %}

    /**
     * @var mixed ${{ associationMapping.fieldName }}
     */
    protected ${{ associationMapping.fieldName }};
{% endfor %}
{% block AdditionalProperties '' %}
{% endblock %}