<?php
require_once('ComunPreguntas.php');
require_once('Selectoption.php');
require_once('Hint.php');

class PreguntaGapselect extends ComunPreguntas
{
    private $shownumcorrect;
    private $selectoptions = array();

    /**
     * PreguntaGapselect constructor.
     */
    public function __construct($root)
    {
        $this->setType('gapselect');
        parent::__construct($root);
    }

    /**
     * @return mixed
     */
    public function getShownumcorrect()
    {
        return $this->shownumcorrect;
    }

    /**
     * @param mixed $shownumcorrect
     */
    public function setShownumcorrect($shownumcorrect)
    {
        $this->shownumcorrect = $shownumcorrect;
    }

    /**
     * @return array
     */
    public function getSelectoptions()
    {
        return $this->selectoptions;
    }

    /**
     * @param array $selectoptions
     */
    public function setSelectoptions($selectoptions)
    {
        $this->selectoptions = $selectoptions;
    }


    public function createGapselect($xml)
    {
        $this->InitQuestion($xml);

        $question = $this->getQuestion();

        // Rellenamos con el valor si barajar respuestas
        $shuffleanswers = $xml->createElement('shuffleanswers',$this->getShuffleanswers());
        $question->appendChild($shuffleanswers);

        $xml=$this->feedbackresposta($xml);

        if ($this->getShownumcorrect()){
            $shownumcorrect = $xml->createElement('shownumcorrect');
            $question->appendChild($shownumcorrect);
        }

        // Añadir las selección posibles
        $xml = $this->createSelectoption($xml);

        // Añadir las pistas
        $xml = $this->createHint($xml);

        return $xml;
    }

    public function createSelectoption($xml){
        $selectoptions = $this->getSelectOptions();
        $question = $this->getQuestion();

        foreach ($selectoptions as $selectoption){
            $selectoptionnodo = $xml->createElement('selectoption');
            $selectoptionnodo = $question->appendChild($selectoptionnodo);
            $text=$xml->createElement('text',$selectoption->getText());
            $selectoptionnodo->appendChild($text);
            $group = $xml->createElement('group',$selectoption->getGroup());
            $selectoptionnodo->appendChild($group);
        }
        return $xml;
    }
}