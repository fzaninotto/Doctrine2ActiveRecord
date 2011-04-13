{% block Properties %}
{{ parent() }}
    protected $updated_at;
{% endblock %}

{% block AdditionalMethods %}
{{ parent() }}
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
{% endblock %}

{% block preSave %}
{{ parent() }}
        // Timestampable behavior
        $this->updated_at = time();
{% endblock %}