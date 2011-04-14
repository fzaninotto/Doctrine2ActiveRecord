{% block ActiveEntity %}
{% block Save %}

    /**
     * Persist the current object and flush the entity manager
     */
    public function save()
    {
{% block preSave '' %}
        $em = self::getEntityManager();
        $em->persist($this);
        $em->flush();
{% block postSave '' %}
    }
{% endblock %}
{% block Delete %}

    /**
     * Remove the current object and flush the entity manager
     */
    public function delete()
    {
{% block preDelete '' %}
        $em = self::getEntityManager();
        $em->remove($this);
        $em->flush();
{% block postDelete '' %}
    }
{% endblock %}
{% block LoadMetadata %}

    /**
     * Load the metadata.
     *
     * @param \Doctrine\ORM\Mapping\ClassMetadata $metadata The metadata class.
     */
    static public function loadMetadata(\Doctrine\ORM\Mapping\ClassMetadata $metadata)
    {
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_AUTO);
{% for fieldMapping in metadata.fieldMappings %}
        $metadata->mapField(array(
            'fieldName' => '{{ fieldMapping.fieldName }}',
            'type' => '{{ fieldMapping.type }}',
{% if fieldMapping.id %}
            'id' => true,
{% endif %}
        ));
{% endfor %}
    }
{% endblock %}
{% block EntityManager %}

    static public function getEntityManager()
    {
        return \Propel\EntityManagerContainer::getEntityManager();
    }
{% endblock %}
{% endblock %}
