{% block Construct %}
{% if additionalMetadata.hasToManyAssociations %}
    /**
     * Class constructor.
     * Initializes -to-many associations
     */
    public function __construct()
    {
{% for key, associationMapping in metadata.associationMappings %}
{% if not associationDetails[key].isToOne %}
        $this->{{ associationMapping.fieldName }} = new ArrayCollection();
{% endif %}
{% endfor %}
    }
{% endif %}
{% endblock %}