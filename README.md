#SilverStripe Twig

##Overview

SilverStripe Twig enables the use of the Twig templating engine in SilverStripe 2.4. SilverStripe Twig appears to work in SilverStripe 3 but isn't throughly tested.

If you are not familiar with Twig, check out the [docs](http://twig.sensiolabs.org/).

##Installation

###Composer

Create or edit a `composer.json` file in the root of your SilverStripe project, and make sure the following is present.

```json
{
    "require": {
        "camspiers/silverstripe-twig": "0.0.*",
		"camspiers/autoloader-composer-silverstripe": "1.0.*"
    }
}
```

After completing this step, navigate in Terminal or similar to the SilverStripe root directory and run `composer install` or `composer update` depending on whether or not you have composer already in use.

##Getting started

###What to name and where to put your templates

Create a folder called `twig` in your current theme. This is where twig will look for your templates. By default Twig expects your templates to be named with the `.twig` extension, but can be easily configured to look for others (see `twig.extensions`).

The way SilverStripe twig decides which template to use is the same way SilverStripe selects `.ss` templates.

It builds a ranked list of candidate templates based on the class name of the current controller or dataRecord and the action being called. Using the template list it selects the first template that it finds.

For example, for page of PageType `Page`. If there is a `Page.twig` template in the twig folder it will use that.

###How to enable twig

Twig rendering is enabled by extending the functionality of your SilverStripe controller. This can be done in two ways depending on what version of PHP you have.

####PHP 5.3

If you want to use twig for all controllers that extend `Page_Controller`, set up is as follows:

`Page.php`

```php
class Page_Controller extends TwigContentController
{
}
```

If you want to use twig in a `Controller`, set up is as follows:

`MyController.php`

```php
class MyController extends TwigController
{
}
```

####PHP 5.4

The PHP 5.3 classes above are actually auto-generated from a trait. To use the trait add a `use` statement in your controller as follows:

```php
class Page_Controller extends ContentController
{
	use TwigControllerTrait;	
}
```
or:

```php
class MyController extends Controller
{
	use TwigControllerTrait;	
}
```

###Accessing your Controller in twig

By default twig makes your controller (and therefore your dataRecord) available in your template by the variable `c`.

```jinja
{% for Page in c.Pages %}
	{{ Page.Title }}
{% endfor %}
```

```jinja
<title>{{ c.Title }}</title>
```

```jinja
<ul>
{% for Page in c.Menu(1) %}
	<li>{{ Page.Title }}</li>
{% else %}
	<li>No pages</li>
{% endfor %}
</ul>
```

###Practical usage example

Achieving similar functionality to SilverStripe's `$Layout` variable is easy with twig.

Twig has the concepts of `extends` and `blocks` which enable flexible template reuse.

`Page.twig`

```jinja
{% extends "layouts/layout.twig" %}

{% block head %}
	{{ parent() }}
	{# add some extra assets here #}
{% endblock %}

{% block header %}
	{# add some header content here #}
{% endblock %}

{% block content %}
	<h1>{{ c.Title }}</h1>
{% endblock %}
```

`layouts/layout.twig`

```jinja
<html>
	<head>
		{% block head %}
			{# default assets here #}
		{% endblock %}
	</head>
	<body>
		{% block header %}{% endblock %}
		{% block content %}{% endblock %}
	</body>
</html>
```

###Configuration

SilverStripe Twig uses a dependency injection container (an extension of `Pimple`) to allow configuration and DI for all objects used.

**Options**

* twig.environment_options
* twig.extensions
* twig.compilation_cache
* twig.template_paths
* twig.controller_variable_name

An example:

`mysite/_config.php`

```php
TwigContainer::extendConfig(array(
	'twig.environment_options' => array(
        'debug' => true
    ),
    'twig.extensions' => array(
    	'.twig',
    	'.html'
    ),
    'twig.compilation_cache' => BASE_PATH . '/silverstripe-cache',
    'twig.template_paths' => array(
    	THEMES_PATH . '/my-theme/templates'
    ),
    'twig.controller_variable_name' => 'controller'
));
```

Any service provided by SilverStripe Twig can be accessed by instantiating the Container.

```php
$dic = new TwigContainer;
$dic['twig']->loadTemplate('template.twig')->render();
```

See [Pimple](http://pimple.sensiolabs.org/) for more information.

##Using Twig and Haml together
SilverStripe twig supports the use of haml through the [SilverStripe haml](https://github.com/camspiers/silverstripe-haml) module.

Install the SilverStripe haml module and you are ready to go.

You can now name your files `.haml` (though you don't have to).

###Usage

To get Twig to process your file as `Haml` add:

```jinja
{% haml %}
```

To the top of any template you want to be processed as haml.

Example:

```haml
{% haml %}
!!!
%html
	%head
		%title #{ c.Title } | haml and twig
		- block head
			:javascript
				console.log('yay');
	%body
		- block content
			%h1 #{ c.Title }
			%p #{ c.Content|raw }
			%span.created #{ c.Created|date("d/m/Y") }
```


##Contributing

###Code guidelines

This project follows the standards defined in:

* [PSR-1](https://github.com/pmjones/fig-standards/blob/psr-1-style-guide/proposed/PSR-1-basic.md)
* [PSR-2](https://github.com/pmjones/fig-standards/blob/psr-1-style-guide/proposed/PSR-2-advanced.md)

---
##License

SilverStripe Twig is released under the [MIT license](http://camspiers.mit-license.org/)