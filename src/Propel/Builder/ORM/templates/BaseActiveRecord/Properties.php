{% block Properties %}
{% for fieldMapping in metadata.fieldMappings %}

    protected ${{ fieldMapping.fieldName }}{% if fieldMapping.default is defined %} = {{ fieldMapping.default|var_export(true) }}{% endif %};
{% endfor %}
{% block AdditionalProperties '' %}
{% endblock %}
