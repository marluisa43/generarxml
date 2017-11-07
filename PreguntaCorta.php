<?php
require_once("Answer.php");
require_once("ComunPreguntas.php");

class PreguntaCorta extends ComunPreguntas
{

    private $usecase;
    private $answers=array();

    /**
     * PreguntaCorta constructor.
     */
    public function __construct($root)
    {
        $this->setType('shortanswer');
        parent::__construct($root);
    }

    /**
     * @return mixed
     */
    public function getUsecase()
    {
        return $this->usecase;
    }

    /**
     * @param mixed $usecase
     */
    public function setUsecase($usecase)
    {
        $this->usecase = $usecase;
    }

    /**
     * @return array
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param array $answers
     */
    public function setAnswers($answers)
    {
        $this->answers= $answers;
    }



    /**
     * @param $xml
     * @return mixed
     * Devuelve la cabecera de pregunta corta.
     */
    public function createShortanswer($xml){

        $this->InitQuestion($xml);

        $question = $this->getQuestion();

        // Rellenamos con el valor de sensible a mayúsculas/minúsculas que puede ser 0/1
        $usecase = $xml->createElement('usecase',$this->getUsecase());
        $question->appendChild($usecase);

        // Añadir las preguntas con sus feedbacks
        $xml=$this->createAnswer($xml);

        // Añadir las pistas
        $xml=$this->createHint($xml);

        return $xml;
    }

    public function createAnswer($xml){
        $answers = $this->getAnswers();
        $question = $this->getQuestion();

        foreach ($answers as $answer){
            $answernodo=$xml->createElement('answer');
            $answernodo = $question->appendChild($answernodo);
            $answernodo->setAttribute('fraction',$answer->getAttriFraction());
            $answernodo->setAttribute('format',$answer->getAttriFormat());
            $text=$xml->createElement('text',$answer->getText());
            $answernodo->appendChild($text);

            $xml = $this->insertImage($xml,$answernodo,$answer->getText(),BeginXml::getRuta());
            $xml = $this->insertHTML($xml,$answernodo,$answer->getText(),BeginXml::getRuta());
            $xml = $this->insertSon($xml,$answernodo,$answer->getText(),BeginXml::getRuta());
            $xml = $this->insertFlash($xml,$answernodo,$answer->getText(),BeginXml::getRuta());

            $feedback = $xml->createElement('feedback');
            $feedback = $answernodo->appendChild($feedback);
            $feedback->setAttribute('format','html');
            $textfeedback = $xml->createElement('text',$answer->getTextfeedback());
            $feedback->appendChild($textfeedback);
        }

        return $xml;
    }
}