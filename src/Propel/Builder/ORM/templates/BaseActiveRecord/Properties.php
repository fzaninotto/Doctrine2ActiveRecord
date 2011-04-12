{% for fieldMapping in metadata.fieldMappings %}

    protected ${{ fieldMapping.fieldName }}{% if fieldMapping.default %} = {{ fieldMapping.default|var_export(true) }}{% endif %};
{% endfor %}