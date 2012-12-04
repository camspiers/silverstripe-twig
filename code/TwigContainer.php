<?php

class TwigContainer extends Pimple
{
    //Default config
    protected static $config = array(
        'twig.loader_class' => 'Twig_Loader_Filesystem',
        'twig.environment_options' => array(
            'auto_reload' => true
        ),
        'twig.extensions' => array(
            '.twig'
        )
    );

    protected static $extensions = array();
    protected static $shared = array();

    public function __construct()
    {

        parent::__construct();

        //Shared services
        $this['twig'] = $this->share(function ($c) {

            $envOptions = array_merge(
                array(
                    'cache' => $c['twig.compilation_cache']
                ),
                $c['twig.environment_options']
            );

            $twig = new Twig_Environment(
                $c['twig.loader'],
                $envOptions
            );

            if (isset($envOptions['debug']) && $envOptions['debug']) {
                $twig->addExtension(new Twig_Extension_Debug());
            }

            return $twig;

        });

        $this['twig.loader'] = $this->share(function ($c) {
            return new $c['twig.loader_class']($c['twig.template_paths']);
        });

        //Dynamic props
        $this['twig.compilation_cache'] = BASE_PATH . '/twig-cache';
        $this['twig.template_paths'] = THEMES_PATH . '/' . SSViewer::current_theme() . '/twig';

        //Default config
        foreach (self::$config as $key => $value) {
            $this[$key] = $value;
        }

        //Extensions
        if (is_array(self::$extensions)) {
            foreach (self::$extensions as $value) {
                $this->extend($value[0], $value[1]);
            }
        }

        //Shared
        if (is_array(self::$shared)) {
            foreach (self::$shared as $value) {
                $this[$value[0]] = $this->share($value[1]);
            }
        }

    }

    public static function addExtension($name, $extension)
    {
        self::$extensions[] = array($name, $extension);
    }

    public static function addShared($name, $shared)
    {
        self::$shared[] = array($name, $shared);
    }

    public static function extendConfig($config)
    {
        if (is_array($config)) {
            self::$config = array_merge(self::$config, $config);
        }
    }

}
