<?php

class TwigContainer extends Pimple
{

    protected static $config = array(
        'twig.environment_options' => array(
            'auto_reload' => true
        ),
        'twig.templates_path'      => false,
        'twig.extension'           => '.twig'
    );

    public function __construct()
    {

        parent::__construct();

        $this['twig'] = $this->share(function ($c) {
            return new Twig_Environment(
                $c->offsetExists('twig.extra_loader') ? $c['twig.extra_loader'] : $c['twig.loader'],
                array_merge(
                    array(
                        'cache' => $c['twig.compilation_cache']
                    ),
                    $c['twig.environment_options']
                )
            );

        });

        $this['twig.loader'] = $this->share(function ($c) {
            return new Twig_Loader_Filesystem(
                $c['twig.templates_path'] ? $c['twig.templates_path'] : THEMES_PATH . '/' . SSViewer::current_theme() . '/twig'
            );

        });

        $this['twig.compilation_cache'] = BASE_PATH . '/twig-cache';

        foreach (self::$config as $key => $value) {
            $this[$key] = $value;
        }

        if (is_array($this['extensions'])) {
            foreach ($this['extensions'] as $key => $value) {
                $this->extend($key, $value);
            }
        }

        if (is_array($this['shared'])) {
            foreach ($this['shared'] as $key => $value) {
                $this[$key] = $this->share($value);
            }
        }

    }

    public static function extendConfig($config)
    {
        if (is_array($config)) {
            self::$config = array_merge(self::$config, $config);
        }
    }

}
