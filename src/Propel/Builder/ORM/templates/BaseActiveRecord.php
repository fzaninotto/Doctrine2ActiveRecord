<?php

{% use 'BaseActiveRecord/Properties.php' %}
{% use 'BaseActiveRecord/GetterSetter.php' %}
{% use 'BaseActiveRecord/Mapping.php' %}
{% use 'BaseActiveRecord/ActiveEntity.php' %}

{% block NamespaceDeclaration %}
{% if namespace %}
namespace {{ namespace }}\Base;
{% else %}
namespace Base;
{% endif %}
{% endblock %}

{% block UseDeclaration %}
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
{{ block('Properties') }}
{{ block('GetterSetter') }}
{{ block('Mapping') }}
{{ block('ActiveEntity') }}
{% block AdditionalMethods '' %}

{% endblock Body %}
}
