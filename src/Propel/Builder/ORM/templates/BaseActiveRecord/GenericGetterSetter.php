{% block GenericGetterSetter %}
    /**
     * Set a property of the entity by name passed in as a string
     *
     * @param string $name  The property name
     * @param mixed  $value The value
     *
     * @throws \InvalidArgumentException If the property does not exists
     */
    public function setByName($name, $value)
    {
{% for fieldMapping in metadata.fieldMappings %}
        if ($name === '{{ fieldMapping.fieldName }}') {
            return $this->set{{ fieldMapping.fieldName|ucfirst }}($value);
        }
{% endfor %}

        throw new \InvalidArgumentException(sprintf('The property "%s" does not exists.', $name));
    }

    /**
     * Retrieve a property from the entity by name passed in as a string
     *
     * @param string $name  The property name
     *
     * @return mixed The value
     *
     * @throws \InvalidArgumentException If the property does not exists
     */
    public function getByName($name)
    {
{% for fieldMapping in metadata.fieldMappings %}
        if ($name === '{{ fieldMapping.fieldName }}') {
            return $this->get{{ fieldMapping.fieldName|ucfirst }}();
        }
{% endfor %}

        throw new \InvalidArgumentException(sprintf('The property "%s" does not exists.', $name));
    }

{% endblock %}