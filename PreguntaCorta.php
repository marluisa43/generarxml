<?php
require_once("BeginXml.php");
require_once("Answer.php");

class PreguntaCorta
{

    private $name;
    private $type;
    private $question;
    private $questiontext;
    private $generalfeedback;
    private $defaultgrade;
    private $penalty;
    private $hidden;
    private $usecase;
    private $answers=array();
    private $root;


    /**
     * PreguntaCorta constructor.
     */
    public function __construct($root)
    {
        $this->setType('shortanswer');
        $this->setRoot($root);

    }

    /**
     * @return mixed
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param mixed $root
     */
    public function setRoot($root)
    {
        $this->root = $root;
    }



    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param mixed $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }



    /**
     * @return mixed
     */
    public function getQuestiontext()
    {
        return $this->questiontext;
    }

    /**
     * @param mixed $questiontext
     */
    public function setQuestiontext($questiontext)
    {
        $this->questiontext = $questiontext;
    }


    /**
     * @return mixed
     */
    public function getGeneralfeedback()
    {
        return $this->generalfeedback;
    }

    /**
     * @param mixed $generalfeedback
     */
    public function setGeneralfeedback($generalfeedback)
    {
        $this->generalfeedback = $generalfeedback;
    }

    /**
     * @return mixed
     */
    public function getDefaultgrade()
    {
        return $this->defaultgrade;
    }

    /**
     * @param mixed $defaultgrade
     */
    public function setDefaultgrade($defaultgrade)
    {
        $this->defaultgrade = $defaultgrade;
    }

    /**
     * @return mixed
     */
    public function getPenalty()
    {
        return $this->penalty;
    }

    /**
     * @param mixed $penalty
     */
    public function setPenalty($penalty)
    {
        $this->penalty = $penalty;
    }

    /**
     * @return mixed
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @param mixed $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
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
    public function createHeadShortanswer($xml){
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

            $answernodo->setAttribute('format',$answer->getAttriFormat());
            $text=$xml->createElement('text',$answer->getText());
            $answernodo->appendChild($text);
        }


        return $xml;
    }

}