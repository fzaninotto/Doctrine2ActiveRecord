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