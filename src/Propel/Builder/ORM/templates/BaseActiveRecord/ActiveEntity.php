
    /**
     * Persist the current object and flush the entity manager
     */
    public function save()
    {
{{ builder.hook('preSave') }}
        $em = self::getEntityManager();
        $em->persist($this);
        $em->flush();
    }

    /**
     * Remove the current object and flush the entity manager
     */
    public function delete()
    {
        $em = self::getEntityManager();
        $em->remove($this);
        $em->flush();
    }