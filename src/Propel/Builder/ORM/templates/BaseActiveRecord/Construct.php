{% block Construct %}
    /**
     * Class constructor.
     * Initializes -to-many associations
     */
    public function __construct()
    {
{% for associationMapping in metadata.associationMappings %}
{% if associationMapping.type not in [1, 2, 3] %}
        $this->{{ associationMapping.fieldName }} = new ArrayCollection();
{% endif %}
{% endfor %}
    }
{% endblock %}