{% block GetterSetter %}
{% for fieldMapping in metadata.fieldMappings %}

    /**
     * Get the {{ fieldMapping.fieldName }} field value
     * @return mixed
     */
    public function get{{ fieldMapping.fieldName|ucfirst }}()
    {
        return $this->{{ fieldMapping.fieldName }};
    }

    /**
     * Set the {{ fieldMapping.fieldName }} field value
     * @param ${{ fieldMapping.fieldName }} mixed
     */
    public function set{{ fieldMapping.fieldName|ucfirst }}(${{ fieldMapping.fieldName }})
    {
        $this->{{ fieldMapping.fieldName }} = ${{ fieldMapping.fieldName }};
    }
{% endfor %}
{% for associationMapping in metadata.associationMappings %}
{% if associationMapping.type in [1, 2, 3] %}
{% set targetEntity %}\{{ associationMapping.targetEntity }}{% endset %}
{% set targetEntityDescription %}The related entity{% endset %}
{% else %}
{% set targetEntity %}mixed{% endset %}
{% set targetEntityDescription %}The collection of related entities{% endset %}
{% endif %}

    /**
     * Get the {{ associationMapping.fieldName }} association value
     * @return {{ targetEntity }} {{ targetEntityDescription }}
     */
    public function get{{ associationMapping.fieldName|ucfirst }}()
    {
        return $this->{{ associationMapping.fieldName }};
    }

    /**
     * Set the {{ associationMapping.fieldName }} association value
     * @param {{ targetEntity }} ${{ associationMapping.fieldName }} {{ targetEntityDescription }}
     */
    public function set{{ associationMapping.fieldName|ucfirst }}(${{ associationMapping.fieldName }})
    {
        $this->{{ associationMapping.fieldName }} = ${{ associationMapping.fieldName }};
    }
{% endfor %}
{% endblock %}