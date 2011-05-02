{% block Properties %}
{% for fieldMapping in metadata.fieldMappings %}
    /**
     * @var {{ fieldMapping.type }} ${{ fieldMapping.fieldName }} {{ fieldMapping.columnDefinition is defined ? fieldMapping.columnDefinition : '' }}
     */
    protected ${{ fieldMapping.fieldName }}{% if fieldMapping.default is defined %} = {{ fieldMapping.default|var_export(true) }}{% endif %};

{% endfor %}
{% for key, associationMapping in metadata.associationMappings %}
{% set associationDetail = associationDetails[key] %}
    /**
     * @var {{ associationDetail.targetEntity }} ${{ associationMapping.fieldName }}
     */
    protected ${{ associationMapping.fieldName }};

{% endfor %}
{% block AdditionalProperties '' %}
{% endblock %}