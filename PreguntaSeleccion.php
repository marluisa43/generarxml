<?php
require_once('Answer.php');
require_once('ComunPreguntas.php');

class PreguntaSeleccion extends ComunPreguntas
{

    private $single;
    private $answernumbering;
    private $answers = array();

    /**
     * PreguntaSeleccion constructor.
     */
    public function __construct($root)
    {
        $this->setType('multichoice');
        parent::__construct($root);
    }


    /**
     * @return mixed
     */
    public function getSingle()
    {
        return $this->single;
    }

    /**
     * @param mixed $single
     */
    public function setSingle($single)
    {
        $this->single = $single;
    }

    /**
     * @return mixed
     */
    public function getAnswernumbering()
    {
        return $this->answernumbering;
    }

    /**
     * @param mixed $answernumbering
     */
    public function setAnswernumbering($answernumbering)
    {
        $this->answernumbering = $answernumbering;
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
        $this->answers = $answers;
    }



    /**
     * @param $xml
     * @return mixed
     * Devuelve xml de pregunta multichoice.
     */
    public function createMultiChoice($xml){

        $this->InitQuestion($xml);

        $question = $this->getQuestion();

        // Rellenamos con el valor si la pregunta es de respuesta simple (true) o múltiple (false)
        $single = $xml->createElement('single',$this->getSingle());
        $question->appendChild($single);

        // Rellenamos con el valor si barajar respuestas
        $shuffleanswers = $xml->createElement('shuffleanswers',$this->getShuffleanswers());
        $question->appendChild($shuffleanswers);

        // Rellenamos con el tipo de enumeración de las elecciones que pueden tomar los valores: none,abc,ABCD,123,iii,III
        $answernumbering = $xml->createElement('answernumbering',$this->getAnswernumbering());
        $question->appendChild($answernumbering);

       $xml=$this->feedbackresposta($xml);

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
            $answernodo = $xml->createElement('answer');
            $answernodo = $question->appendChild($answernodo);
            $answernodo->setAttribute('fraction',$answer->getAttriFraction());
            $answernodo->setAttribute('format',$answer->getAttriFormat());
            $text=$xml->createElement('text',$answer->getText());
            $answernodo->appendChild($text);


            $feedback = $xml->createElement('feedback');
            $feedback = $answernodo->appendChild($feedback);
            $feedback->setAttribute('format','html');
            $textfeedback = $xml->createElement('text',$answer->getTextfeedback());
            $feedback->appendChild($textfeedback);
        }
        return $xml;
    }

}

