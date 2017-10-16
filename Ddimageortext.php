<?php
require_once("ComunPreguntas.php");


class Ddimageortext extends ComunPreguntas
{
    private $backgroundImage;

    /**
     * Ddimageortext constructor.
     */
    public function __construct($root)
    {
        $this->setType('ddimageortext');
        parent::__construct($root);
    }

    /**
     * @return mixed
     */
    public function getBackgroundImage()
    {
        return $this->backgroundImage;
    }

    /**
     * @param mixed $backgroundImage
     */
    public function setBackgroundImage($backgroundImage)
    {
        $this->backgroundImage = $backgroundImage;
    }

    public function createDdimageortext($xml){
        $this->InitQuestion($xml);
        $question = $this->getQuestion();

        // Añadimos los feedbacks
        $xml=$this->feedbackresposta($xml);

        $xml=$this->loadBackgroundImage($xml,$question,$this->getBackgroundImage(),BeginXml::getRuta());




        // Añadir las pistas
        $xml=$this->createHint($xml);

        return $xml;


    }

    private function loadBackgroundImage ($xml,$question,$image,$ruta){
        $bgimg=file_get_contents($ruta.'/'.$image);
        $bgimgBase64=base64_encode($bgimg);

        $file=$xml->createElement('file',$bgimgBase64);
        $question->appendChild($file);
        return ($xml);

    }
}