{% use 'BaseActiveRecord/Properties.php' %}
{% use 'BaseActiveRecord/Construct.php' %}
{% use 'BaseActiveRecord/GetterSetter.php' %}
{% use 'BaseActiveRecord/GenericGetterSetter.php' %}
{% use 'BaseActiveRecord/Metadata.php' %}
{% use 'BaseActiveRecord/ArrayConverter.php' %}
{% use 'BaseActiveRecord/ArrayAccess.php' %}
<?php

{% block NamespaceDeclaration %}
namespace {{ namespace }};
{% endblock %}

{% block UseDeclaration %}
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\Collections\ArrayCollection;
use Propel\ActiveEntity;
{% endblock %}

{% block DocBlock %}
/**
 * Base class providing ActiveRecord features to {{ classname }}.
 * Do not modify this class: it will be overwritten each time you regenerate
 * ActiveRecord.
{% block AdditionalDocBlock '' %}
 */
{% endblock %}
{% block ClassDeclaration %}
class {{ classname }} extends ActiveEntity{% if implements is defined %} implements {{ implements }}{% endif %} 
{% endblock %}
{
{% block Body %}
{{- block('Properties') -}}
{{- block('Construct') -}}
{{ block('GetterSetter') -}}
{{ block('GenericGetterSetter') -}}
{{ block('Metadata') -}}
{{ block('ArrayConverter') -}}
{# block('ArrayAccess') #}
{% block AdditionalMethods '' %}
{% endblock Body %}
}
