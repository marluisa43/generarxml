<?php

require_once('Hint.php');

class ComunPreguntas
{
    private $name;
    private $type;
    private $question;
    private $questiontext;
    private $generalfeedback;
    private $defaultgrade;
    private $penalty;
    private $hidden;
    private $shuffleanswers;
    private $textCorrectfeedback;
    private $textPartiallycorrectfeedback;
    private $textIncorrectfeedback;
    private $hints = array();

    private $root;

    /**
     * ComunPreguntas constructor.
     * @param $root
     */
    public function __construct($root)
    {
        $this->root = $root;
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
    public function getHints()
    {
        return $this->hints;
    }

    /**
     * @param array $hints
     */
    public function setHints($hints)
    {
        $this->hints = $hints;
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

    public function InitQuestion($xml){
        $head=$xml->createElement('question');
        $root=$this->getRoot();
        $question=$root->appendChild($head);
        $question->setAttribute('type',$this->getType());

        $this->setQuestion($question);

        // Rellenamos el nombre de la pregunta
        $name=$xml->createElement('name');
        $name=$question->appendChild($name);
        $text=$xml->createElement('text',$this->getName());
        $name->appendChild($text);

        // Rellenamos con el enunciado de la pregunta
        $enum=$xml->createElement('questiontext');
        $enum=$question->appendChild($enum);
        $enum->setAttribute('format','html');
        $text=$xml->createElement('text',$this->getQuestiontext());
        $enum->appendChild($text);

        if(!is_null($this->getGeneralfeedback())){
            // Rellenamos la retroalimentación general de la pregunta.
            $generalfeedback=$xml->createElement('generalfeedback');
            $generalfeedback=$question->appendChild($generalfeedback);
            $generalfeedback->setAttribute('format','html');
            $xml->createElement('text',$this->getGeneralfeedback());
        }

        if($this->getDefaultgrade()!=0){
            // Rellenamos con el valor de la pregunta por defecto.
            $defaultgrade= $xml->createElement('defaultgrade',$this->getDefaultgrade());
            $question->appendChild($defaultgrade);
        }

        if($this->getPenalty()!=0){
            // Rellenamos con la penalización por cada intento incorrecto.
            $penalty = $xml->createElement('penalty',$this->getPenalty());
            $question->appendChild($penalty);
        }

        // Rellenamos con el valor si es oculta la pregunta (0:Visible, 1: Oculta)
        $hidden = $xml->createElement('hidden',$this->getHidden());
        $question->appendChild($hidden);
        return ($xml);

    }


    public function feedbackresposta($xml){
        $question = $this->getQuestion();

        if (!is_null($this->getTextCorrectfeedback())){
            // Rellenamos con el feedback de respuesta correcta.
            $correctfeedback = $xml->createElement('correctfeedback');
            $correctfeedback = $question->appendChild($correctfeedback);
            $correctfeedback->setAttribute('format','html');
            $textcorrectfeedback = $xml->createElement('text',$this->getTextCorrectfeedback());
            $correctfeedback->appendChild($textcorrectfeedback);
        }

        if (!is_null($this->getTextPartiallycorrectfeedback())){
            // Rellenamos con el feedback de respuesta parcialmente correcta.
            $partiallycorrectfeedback = $xml->createElement('partiallycorrectfeedback');
            $partiallycorrectfeedback = $question->appendChild($partiallycorrectfeedback);
            $partiallycorrectfeedback->setAttribute('format','html');
            $textpartiallycorrectfeedback = $xml->createElement('text',$this->getTextPartiallycorrectfeedback());
            $partiallycorrectfeedback->appendChild($textpartiallycorrectfeedback);
        }

        if (!is_null($this->getTextIncorrectfeedback())){
            // Rellenamos con el feedback de respuesta incorrecta.
            $incorrectfeedback = $xml->createElement('incorrectfeedback');
            $incorrectfeedback = $question->appendChild($incorrectfeedback);
            $incorrectfeedback->setAttribute('format','html');
            $textincorrectfeedback = $xml->createElement('text',$this->getTextIncorrectfeedback());
            $incorrectfeedback->appendChild($textincorrectfeedback);
        }


        return($xml);
    }

    public function createHint($xml){
        $hints = $this->getHints();
        $question = $this->getQuestion();
        if (!is_null($hints)){
            foreach ($hints as $hint){
                $hintnodo = $xml->createElement('hint');
                $hintnodo = $question->appendChild($hintnodo);
                $hintnodo->setAttribute('format','html');
                $texthint = $xml->createElement('text',$hint->getText());
                $hintnodo->appendChild($texthint);

                if ($hint->getShownumcorrect()){
                    $shownumcorrect = $xml->createElement('shownumcorrect');
                    $hintnodo->appendChild($shownumcorrect);
                }
                if ($hint->getClearwrong()){
                    $clearwrong = $xml->createElement('clearwrong');
                    $hintnodo->appendChild($clearwrong);
                }
            }
        }
        return $xml;
    }
}