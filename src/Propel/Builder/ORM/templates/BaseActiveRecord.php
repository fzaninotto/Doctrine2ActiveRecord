<?php

{% use 'BaseActiveRecord/Properties.php' %}
{% use 'BaseActiveRecord/GetterSetter.php' %}
{% use 'BaseActiveRecord/GenericGetterSetter.php' %}
{% use 'BaseActiveRecord/Metadata.php' %}
{% use 'BaseActiveRecord/EntityManager.php' %}
{% use 'BaseActiveRecord/ArrayConverter.php' %}
{% use 'BaseActiveRecord/State.php' %}
{% use 'BaseActiveRecord/ActiveEntity.php' %}
{% use 'BaseActiveRecord/ArrayAccess.php' %}

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
class {{ classname }}{% if implements is defined %} implements {{ implements }}{% endif %} 
{% endblock %}
{
{% block Body %}
{{ block('Properties') }}
{{ block('GetterSetter') }}
{{ block('GenericGetterSetter') }}
{{ block('Metadata') }}
{{ block('EntityManager') }}
{{ block('ArrayConverter') }}
{{ block('State') }}
{{ block('ActiveEntity') }}
{# block('ArrayAccess') #}
{% block AdditionalMethods '' %}

{% endblock Body %}
}
