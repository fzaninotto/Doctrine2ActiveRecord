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
{% endblock %}
