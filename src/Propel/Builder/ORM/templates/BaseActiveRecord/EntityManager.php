{% block EntityManager %}

    static public function getEntityManager()
    {
        return \Propel\EntityManagerContainer::getEntityManager();
    }
{% endblock %}