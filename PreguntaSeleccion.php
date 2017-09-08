<?php
require_once('BeginXml.php');
require_once('Answer.php');
require_once('Hint.php');

class PreguntaSeleccion
{
    private $name;
    private $type;
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
    private $answers = array();
    private $hints = array();
    private $root;

    /**
     * PreguntaSeleccion constructor.
     */
    public function __construct($root)
    {
        $this->setType('multichoice');
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
     * @param $xml
     * @return mixed
     * Devuelve la cabecera de pregunta multichoice.
     */
    public function createMultiChoice($xml){
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

        // Rellenamos la retroalimentación general de la pregunta.
        $generalfeedback=$xml->createElement('generalfeedback');
        $generalfeedback=$question->appendChild($generalfeedback);
        $generalfeedback->setAttribute('format','html');
        $xml->createElement('text',$this->getGeneralfeedback());

        // Rellenamos con el valor de la pregunta por defecto.
        $defaultgrade= $xml->createElement('defaultgrade',$this->getDefaultgrade());
        $question->appendChild($defaultgrade);

        // Rellenamos con la penalización por cada intento incorrecto.
        $penalty = $xml->createElement('penalty',$this->getPenalty());
        $question->appendChild($penalty);

        // Rellenamos con el valor si es oculta la pregunta (0:Visible, 1: Oculta)
        $hidden = $xml->createElement('hidden',$this->getHidden());
        $question->appendChild($hidden);

        // Rellenamos con el valor si la pregunta es de respuesta simple (true) o múltiple (false)
        $single = $xml->createElement('single',$this->getSingle());
        $question->appendChild($single);

        // Rellenamos con el valor si barajar respuestas
        $shuffleanswers = $xml->createElement('shuffleanswers',$this->getShuffleanswers());
        $question->appendChild($shuffleanswers);

        // Rellenamos con el tipo de enumeración de las elecciones que pueden tomar los valores: none,abc,ABCD,123,iii,III
        $answernumbering = $xml->createElement('answernumbering',$this->getAnswernumbering());
        $question->appendChild($answernumbering);

        // Rellenamos con el feedback de respuesta correcta.
        $correctfeedback = $xml->createElement('correctfeedback');
        $correctfeedback = $question->appendChild($correctfeedback);
        $correctfeedback->setAttribute('format','html');
        $textcorrectfeedback = $xml->createElement('text',$this->getTextCorrectfeedback());
        $correctfeedback->appendChild($textcorrectfeedback);

        // Rellenamos con el feedback de respuesta parcialmente correcta.
        $partiallycorrectfeedback = $xml->createElement('partiallycorrectfeedback');
        $partiallycorrectfeedback = $question->appendChild($partiallycorrectfeedback);
        $partiallycorrectfeedback->setAttribute('format','html');
        $textpartiallycorrectfeedback = $xml->createElement('text',$this->getTextPartiallycorrectfeedback());
        $partiallycorrectfeedback->appendChild($textpartiallycorrectfeedback);

        // Rellenamos con el feedback de respuesta incorrecta.
        $incorrectfeedback = $xml->createElement('incorrectfeedback');
        $incorrectfeedback = $question->appendChild($incorrectfeedback);
        $incorrectfeedback->setAttribute('format','html');
        $textincorrectfeedback = $xml->createElement('text',$this->getTextIncorrectfeedback());
        $incorrectfeedback->appendChild($textincorrectfeedback);

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

    public function createHint($xml){
        $hints = $this->getHints();
        $question = $this->getQuestion();

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
        return $xml;
    }

}

