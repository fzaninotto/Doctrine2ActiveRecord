{% block EntityManager %}

    static public function getEntityManager()
    {
        return \EntityManagerContainer::getContainer();
    }
{% endblock %}