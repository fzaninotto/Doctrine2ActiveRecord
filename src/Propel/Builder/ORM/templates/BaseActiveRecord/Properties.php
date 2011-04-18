{% block Properties %}
{% for fieldMapping in metadata.fieldMappings %}

    /**
     * @var {{ fieldMapping.type }} ${{ fieldMapping.fieldName }} {{ fieldMapping.columnDefinition is defined ? fieldMapping.columnDefinition : '' }}
     */
    protected ${{ fieldMapping.fieldName }}{% if fieldMapping.default is defined %} = {{ fieldMapping.default|var_export(true) }}{% endif %};
{% endfor %}
{% for associationMapping in metadata.associationMappings %}
{% if associationMapping.type in [1, 2, 3] %}
{% set targetEntity %}\{{ associationMapping.targetEntity }}{% endset %}
{% else %}
{% set targetEntity %}\Doctrine\Common\Collections\ArrayCollection{% endset %}
{% endif %}

    /**
     * @var {{ targetEntity }} ${{ associationMapping.fieldName }}
     */
    protected ${{ associationMapping.fieldName }};
{% endfor %}
{% block AdditionalProperties '' %}
{% endblock %}
