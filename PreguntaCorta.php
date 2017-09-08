<?php
require_once("Answer.php");
require_once('ComunPreguntas.php');

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
        $head=$xml->createElement('question');
        $root=$this->getRoot();
        $question=$root->appendChild($head);
        $question->setAttribute('type',$this->getType());

        $this->setQuestion($question);

        $name=$xml->createElement('name');
        $name=$question->appendChild($name);
        $text=$xml->createElement('text',$this->getName());
        $name->appendChild($text);

        $enum=$xml->createElement('questiontext');
        $enum=$question->appendChild($enum);
        $enum->setAttribute('format','html');
        $text=$xml->createElement('text',$this->getQuestiontext());
        $enum->appendChild($text);

        return $xml;
    }

    public function createAnswer($xml){
        $answers=$this->getAnswers();
        $question=$this->getQuestion();

        foreach ($answers as $answer){
            $answernodo=$xml->createElement('answer');
            $answernodo=$question->appendChild($answernodo);
            $answernodo->setAttribute('fraction',$answer->getAttriFraction());
            $answernodo->setAttribute('format',$answer->getAttriFormat());
            $text=$xml->createElement('text',$answer->getText());
            $answernodo->appendChild($text);
        }


        return $xml;
    }

}