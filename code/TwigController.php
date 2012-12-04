<?php

require_once __DIR__ . '/TwigControllerTrait.php';

class TwigController extends Controller
{

    use TwigControllerTrait;

    protected $dic;

    public function __construct()
    {
        $this->dic = new TwigContainer;
        parent::__construct();
    }

}
