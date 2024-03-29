<?php


namespace App\Controllers;

class BaseController
{
    /** @var array */
    protected $params;

    /** @var array */
    protected $data;

    /** @var string */
    protected $template = null;

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }


    /**
     * Base constructor.
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->params = $params;
    }


    /**
     * Throw 404 status & page
     */
    public function page404()
    {
        header('HTTP/1.1 404 Not Found');
        $this->template = ROOT.DS.'views'.DS.'default'.DS.'pages'.DS.'404.php';
    }
}
