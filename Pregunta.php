<?php

/**
 * Created by PhpStorm.
 * User: vmarzo
 * Date: 5/09/17
 * Time: 12:14
 */
class Pregunta{

    private $cabecera;

    /**
     * Pregunta constructor.
     */
    public function __construct()
    {
        $this->setCabecera("1","utf8");
    }

    /**
     * @return mixed
     */
    public function getCabecera()
    {
        return $this->cabecera;
    }

    /**
     * @param mixed $cabecera
     */
    public function setCabecera($version,$encoding)
    {
        $this->cabecera = new DOMDocument($version,$encoding);
    }

}