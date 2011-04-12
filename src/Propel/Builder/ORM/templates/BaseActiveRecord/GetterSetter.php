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