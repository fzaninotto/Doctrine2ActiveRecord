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
{% for key, associationMapping in metadata.associationMappings %}
{% set associationDetail = associationDetails[key] %}

    /**
     * Get the {{ associationMapping.fieldName }} association value
     * @return {{ associationDetail.targetEntity }} {{ associationDetail.targetEntityDescription }}
     */
    public function get{{ associationMapping.fieldName|ucfirst }}()
    {
        return $this->{{ associationMapping.fieldName }};
    }

    /**
     * Set the {{ associationMapping.fieldName }} association value
     * @param {{ associationDetail.targetEntity }} ${{ associationMapping.fieldName }} {{ associationDetail.targetEntityDescription }}
     */
    public function set{{ associationMapping.fieldName|ucfirst }}(${{ associationMapping.fieldName }})
    {
        $this->{{ associationMapping.fieldName }} = ${{ associationMapping.fieldName }};
    }
{% endfor %}
{% endblock %}