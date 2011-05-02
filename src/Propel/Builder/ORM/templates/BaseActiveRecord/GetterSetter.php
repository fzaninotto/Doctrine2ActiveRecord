{% block GetterSetter %}
{% block FieldMappingGetterSetter %}
{% for fieldMapping in metadata.fieldMappings %}
    /**
     * Get the {{ fieldMapping.fieldName }} field value
     * @return {{ fieldMapping.type }}
     */
    public function get{{ fieldMapping.fieldName|ucfirst }}()
    {
        return $this->{{ fieldMapping.fieldName }};
    }

    /**
     * Set the {{ fieldMapping.fieldName }} field value
     * @param ${{ fieldMapping.fieldName }} {{ fieldMapping.type }}
     */
    public function set{{ fieldMapping.fieldName|ucfirst }}(${{ fieldMapping.fieldName }})
    {
        $this->{{ fieldMapping.fieldName }} = ${{ fieldMapping.fieldName }};
    }

{% endfor %}
{% endblock %}
{% block AssociationMappingGetterSetter %}
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

{% if not associationDetail.isToOne %}
{% set singularFieldName = associationMapping.fieldName|makeSingular %}
    /**
     * Add an element to the {{ associationMapping.fieldName }} association value
     * @param {{ associationMapping.targetEntity }} ${{ singularFieldName }}
     */
    public function add{{ singularFieldName|ucfirst }}(${{ singularFieldName }})
    {
        $this->{{ associationMapping.fieldName }}->add(${{ singularFieldName }});
    }

    /**
     * Remove an element from the {{ associationMapping.fieldName }} association value
     * @param {{ associationMapping.targetEntity }} ${{ singularFieldName }}
     */
    public function remove{{ singularFieldName|ucfirst }}(${{ singularFieldName }})
    {
        $this->{{ associationMapping.fieldName }}->removeElement(${{ singularFieldName }});
    }

{% endif %}
{% endfor %}
{% endblock %}
{% endblock %}