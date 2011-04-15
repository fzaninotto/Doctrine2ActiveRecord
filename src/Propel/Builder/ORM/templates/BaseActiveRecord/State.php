{% block State %}

    /**
     * Returns if the entity is new.
     *
     * @return bool If the entity is new.
     */
    public function isNew()
    {
        return !static::getEntityManager()->getUnitOfWork()->isInIdentityMap($this);
    }

    /**
     * Returns if the entity is modified.
     *
     * @return bool If the entity is modified.
     */
    public function isModified()
    {
        return (bool) count($this->getModified());
    }

    /**
     * Returns the entity modifications
     *
     * @return array The entity modifications.
     */
    public function getModified()
    {
        if ($this->isNew()) {
            return array();
        }

        $originalData = static::getEntityManager()->getUnitOfWork()->getOriginalEntityData($this);

        return array_diff($originalData, $this->toArray());
    }

    /**
     * Refresh the entity from the database.
     *
     * @return void
     */
    public function reload()
    {
        static::getEntityManager()->getUnitOfWork()->refresh($this);
    }

    /**
     * Returns the change set of the entity.
     *
     * @return array The change set.
     */
    public function changeSet()
    {
        return static::getEntityManager()->getUnitOfWork()->getEntityChangeSet($this);
    }
{% endblock %}