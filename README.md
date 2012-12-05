#SilverStripe Twig

##Overview

SilverStripe Twig enables the use of the Twig templating engine in SilverStripe. 

##Installation

###Composer

Create or edit a `composer.json` file in the root of your SilverStripe project, and make sure the following is present.

```json
{
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/camspiers/silverstripe-twig.git"
        }
    ],
    "require": {
        "camspiers/silverstripe-twig": "dev-master"
    },
    "minimum-stability": "dev"
}
```

Currently SilverStripe Twig is in development so it isn't available through packagist.

After completing this step, navigate in Terminal or similar to the SilverStripe root directory and run `composer install` or `composer update` depending on whether or not you have composer already in use.

##Getting started

If you are not familiar with Twig, check out the [docs](http://twig.sensiolabs.org/).

###What to call and where to put your templates

Create a folder called `twig` in your current theme. This is where twig will look for your templates. By default Twig expects your templates to be named with the `.twig` extension, but can be easily configured to look for others.

The way SilverStripe twig decides which template to use is the same way SilverStripe selects `.ss` templates.

It builds a ranked list of candidate templates based on the class name of the current controller or dataRecord and the action being called. Using the template list it selects the first template that it finds.

For example, for page of PageType `Page`. If there is a `Page.twig` template in the twig folder it will use that.

###Enabling twig usage on your controller

If you want to use twig for all controllers that extend `Page_Controller`, set up is as follows:

`Page.php`

```
class Page_Controller extends TwigContentController
{

}
```

If you want to use twig in a non-`ContentController`, set up is as follows:
`MyController.php`

```
class MyController extends TwigController
{

}
```

Or alternatively you can use traits:

```
class Page_Controller extends ContentController
{
	use TwigControllerTrait;	
}
```
or:

```
class MyController extends Controller
{
	use TwigControllerTrait;	
}
```

###Configuration

SilverStripe Twig uses a dependency injection container (an extension of `Pimple`) to allow configuration and DI for all objects used.

**Options**

* twig.environment_options
* twig.extensions
* twig.compilation_cache
* twig.template_paths

`mysite/_config.php`

```
TwigContainer::extendConfig(array(
	'twig.environment_options' => array(
        'debug' => true
    )
));
```

Any service provided by SilverStripe Twig can be accessed by instantiating the Container.

```
$dic = new Twig;
$dic['twig']->loadTemplate('template.twig')->render();

```

See [Pimple](http://pimple.sensiolabs.org/) for more information.


##Contributing

###Code guidelines

This project follows the standards defined in:

* [PSR-1](https://github.com/pmjones/fig-standards/blob/psr-1-style-guide/proposed/PSR-1-basic.md)
* [PSR-2](https://github.com/pmjones/fig-standards/blob/psr-1-style-guide/proposed/PSR-2-advanced.md)

---
##License

SilverStripe Twig is released under the [MIT license](http://camspiers.mit-license.org/)