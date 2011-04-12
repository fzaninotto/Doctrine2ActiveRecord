{% block AdditionalDocBlock %}{{ parent() }} * Generated on {{ timestamp }}
{% endblock %}

{% block AdditionalMethods %}
{{ parent() }}
    static public function getGenerationDate()
    {
        return '{{ timestamp }}';
    }
{% endblock %}