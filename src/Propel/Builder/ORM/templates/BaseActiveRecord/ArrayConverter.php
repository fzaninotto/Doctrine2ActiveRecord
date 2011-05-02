{% block ArrayConverter %}
   /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST). This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the set[ColumnName]() method is called for that column.
     *
     * @param array $array An array to populate the object from.
     */
    public function fromArray($array)
    {
{% for fieldMapping in metadata.fieldMappings %}
        if (array_key_exists('{{ fieldMapping.fieldName }}', $array)) {
            $this->set{{ fieldMapping.fieldName|ucfirst }}($array['{{ fieldMapping.fieldName }}']);
        }
{% endfor %}
    }

    /**
     * Exports the object as an array.
     *
     * @return array An associative array containing the field names (as keys) and field values.
     */
    public function toArray()
    {
        return array(
{% for fieldMapping in metadata.fieldMappings %}
            '{{ fieldMapping.fieldName }}' => $this->get{{ fieldMapping.fieldName|ucfirst }}(),
{% endfor %}
        );
    }

{% endblock %}