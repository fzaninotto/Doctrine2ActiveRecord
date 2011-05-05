{% block EntityManager %}

    /**
     * Get the entity manager for this class
     */
    static public function getEntityManager()
    {
        return \EntityManagerContainer::getContainer();
    }
{% endblock %}