<?php
require_once('ComunPreguntas.php');
require_once('Hint.php');

class PreguntaCloze extends ComunPreguntas
{

    /**
     * PreguntaClose constructor.
     */
    public function __construct($root)
    {
        $this->setType('cloze');
        parent::__construct($root);
    }

    public function createCloze($xml){

        $this->InitQuestion($xml);

        // Añadir las pistas
        $xml=$this->createHint($xml);

        return $xml;
    }
}