<?php
require_once('Pregunta.php');
require_once('Answer.php');

class PreguntaSeleccion extends Pregunta
{
    private $name;
    private $question;
    private $questiontext;
    private $generalfeedback;
    private $defaultgrade;
    private $penalty;
    private $hidden;
    private $single;
    private $shuffleanswers;
    private $answernumbering;
    private $textCorrectfeedback;
    private $textPartiallycorrectfeedback;
    private $textIncorrectfeedback;
    private $answers=array();

    /**
     * PreguntaSeleccion constructor.
     */
    public function __construct()
    {
        $this->setType('multichoice');
        parent::__construct($this->getType());
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
    public function getShuffleanswers()
    {
        return $this->shuffleanswers;
    }

    /**
     * @param mixed $shuffleanswers
     */
    public function setShuffleanswers($shuffleanswers)
    {
        $this->shuffleanswers = $shuffleanswers;
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
     * @return mixed
     */
    public function getTextCorrectfeedback()
    {
        return $this->textCorrectfeedback;
    }

    /**
     * @param mixed $textCorrectfeedback
     */
    public function setTextCorrectfeedback($textCorrectfeedback)
    {
        $this->textCorrectfeedback = $textCorrectfeedback;
    }

    /**
     * @return mixed
     */
    public function getTextPartiallycorrectfeedback()
    {
        return $this->textPartiallycorrectfeedback;
    }

    /**
     * @param mixed $textPartiallycorrectfeedback
     */
    public function setTextPartiallycorrectfeedback($textPartiallycorrectfeedback)
    {
        $this->textPartiallycorrectfeedback = $textPartiallycorrectfeedback;
    }

    /**
     * @return mixed
     */
    public function getTextIncorrectfeedback()
    {
        return $this->textIncorrectfeedback;
    }

    /**
     * @param mixed $textIncorrectfeedback
     */
    public function setTextIncorrectfeedback($textIncorrectfeedback)
    {
        $this->textIncorrectfeedback = $textIncorrectfeedback;
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
     * Devuelve la cabecera de pregunta multichoice.
     */
    public function createHeadMultiChoice($xml){
        $head=$xml->createElement('question');
        $root=$this->getRoot();
        $question=$root->appendChild($head);
        $question->setAttribute('type',$this->getType());

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
        $answers=$this->getAnswers();
        $question=$this->getQuestion();

        foreach ($answers as $answer){
            $answernodo=$xml->createElement('answer');
            $answernodo=$question->appendChild($answernodo);

            $answernodo->setAttribute('format',$answer->getAttriFormat());
            $text=$xml->createElement('text',$answer->getText());
            $text=$answernodo->appendChild($text);
        }


        return $xml;
    }
}

