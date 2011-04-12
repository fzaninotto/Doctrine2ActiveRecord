<?php

{% block NamespaceDeclaration %}
{% if namespace %}
namespace {{ namespace }}\Base;
{% else %}
namespace Base;
{% endif %}
{% endblock %}

{% block DocBlock %}
/**
 * Base class providing ActiveRecord features to {{ classname }}.
 * Do not modify this class: it will be overwritten each time you regenerate ActiveRecord.
{% block AdditionalDocBlock '' %}
 */
{% endblock %}
{% block ClassDeclaration %}
class {{ classname }}
{% endblock %}
{
{% block Body %}

{% block Properties %}
{% include 'BaseActiveRecord/Properties.php' %}
{% endblock %}

{% block GetterSetter %}
{% include 'BaseActiveRecord/GetterSetter.php' %}
{% endblock %}

{% block ActiveEntity %}
{% include 'BaseActiveRecord/ActiveEntity.php' %}
{% endblock %}

{% block EntityManager %}
{% include 'BaseActiveRecord/EntityManager.php' %}
{% endblock %}

{% block AdditionalMethods '' %}

{% endblock Body %}
}
