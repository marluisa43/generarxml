<?php
require_once("Pregunta.php");
/**
 * Created by PhpStorm.
 * User: vmarzo
 * Date: 5/09/17
 * Time: 12:23
 */
class PreguntaCorta extends Pregunta
{

    private $name;
    private $question;
    private $questiontext;
    private $answertext;
    private $generalfeedback;
    private $defaultgrade;
    private $penalty;
    private $hidden;
    private $usecase;


    /**
     * PreguntaCorta constructor.
     */
    public function __construct()
    {
        parent::__construct("shortanswer");

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
    public function getAnswertext()
    {
        return $this->answertext;
    }

    /**
     * @param mixed $answertext
     */
    public function setAnswertext($answertext)
    {
        $this->answertext = $answertext;
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
     * @param $xml
     * @return mixed
     * Devuelve la cabecera de pregunta corta.
     */
    public function createHeadShortanswer($xml){
        $head=$xml->createElement('question');
        $root=$this->getRoot();
        $question=$root->appendChild($head);
        $question->setAttribute('type','shortanswer');
        $this->setQuestion($question);

        $name=$xml->createElement('name');
        $name=$question->appendChild($name);
        $text=$xml->createElement('text',$this->getName());
        $text=$name->appendChild($text);

        $enum=$xml->createElement('questiontext');
        $enum=$question->appendChild($enum);
        $enum->setAttribute('format','html');
        $text=$xml->createElement('text',$this->getQuestiontext());
        $text=$enum->appendChild($text);

        return $xml;
    }

    public function createAnswer($xml){
        $answer=$xml->createElement('answer');
        $question=$this->getQuestion();
        $answer=$question->appendChild($answer);
        $answer->setAttribute('format','moodle_auto_format');
        $text=$xml->createElement('text',$this->getAnswertext());
        $text=$answer->appendChild($text);

        return $xml;
    }

}