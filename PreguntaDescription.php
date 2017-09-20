<?php
require_once("ComunPreguntas.php");

class PreguntaDescription extends ComunPreguntas
{

    /**
     * PreguntaDescription constructor.
     */
    public function __construct($root)
    {
        $this->setType('description');
        $this->setHidden(0);
        $this->setDefaultgrade(0.0000000);
        $this->setPenalty(0.0000000);
        parent::__construct($root);
    }

    /**
     * @param $xml
     * @return mixed
     * Devuelve la cabecera de pregunta corta.
     */
    public function createDescription($xml){

         return $this->InitQuestion($xml);
    }
}