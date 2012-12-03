<?php

// If haml is available allow it to be used
if (class_exists('HamlSilverStripeContainer')) {

    TwigContainer::extendConfig(array(
        'haml.dic' => function () {
            return new HamlSilverStripeContainer(array(
                'environment.type' => 'twig'
            ));
        },
        'twig.extra_loader' => function ($c) {
            return new MtHaml\Support\Twig\Loader($c['haml.env'], $c['twig.loader']);
        },
        'twig.extension' => '.haml',
        'shared' => array(
            'haml.env' => function ($c) {
                return $c['haml.dic']['environment'];
            }
        ),
        'extensions' => array(
            'twig' => function ($twig, $c) {
                $twig->addExtension(new MtHaml\Support\Twig\Extension);

                return $twig;
            }
        )
    ));

}
