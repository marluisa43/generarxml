<?php
/**
 * Created by PhpStorm.
 * User: msuarez
 * Date: 21/09/17
 * Time: 12:42
 */

class PreguntaOrden extends ComunPreguntas
{
    private $layouttype;
    private $selecttype;
    private $selectcount;
    private $gradingtype;
    private $showgrading;

    /**
     * @return mixed
     */
    public function getLayouttype()
    {
        return $this->layouttype;
    }

    /**
     * @param mixed $layouttype
     */
    public function setLayouttype($layouttype)
    {
        $this->layouttype = $layouttype;
    }

    /**
     * @return mixed
     */
    public function getSelecttype()
    {
        return $this->selecttype;
    }

    /**
     * @param mixed $selecttype
     */
    public function setSelecttype($selecttype)
    {
        $this->selecttype = $selecttype;
    }

    /**
     * @return mixed
     */
    public function getSelectcount()
    {
        return $this->selectcount;
    }

    /**
     * @param mixed $selectcount
     */
    public function setSelectcount($selectcount)
    {
        $this->selectcount = $selectcount;
    }

    /**
     * @return mixed
     */
    public function getGradingtype()
    {
        return $this->gradingtype;
    }

    /**
     * @param mixed $gradingtype
     */
    public function setGradingtype($gradingtype)
    {
        $this->gradingtype = $gradingtype;
    }

    /**
     * @return mixed
     */
    public function getShowgrading()
    {
        return $this->showgrading;
    }

    /**
     * @param mixed $showgrading
     */
    public function setShowgrading($showgrading)
    {
        $this->showgrading = $showgrading;
    }



    /**
     * PreguntaOrden constructor.
     */
    public function __construct($root)
    {
        $this->setType('ordering');
        parent::__construct($root);
    }


    /**
     * @param $xml
     * @return mixed
     * Crea la pregunta de orden
     */

    public function createOrdering($xml){

        $this->InitQuestion($xml);

        $question = $this->getQuestion();

        // Ver las opciones en vertical u horizontal
        $layouttype = $xml->createElement('layouttype',$this->getLayouttype());
        $question->appendChild($layouttype);
        // Ver todas las opciones o un subconjunto de opciones
        $selecttype = $xml->createElement('selecttype',$this->getSelecttype());
        $question->appendChild($selecttype);
        // Numeros de opciones cuando la pregunta aparece en un cuestionario
        $selectcount = $xml->createElement('selectcount',$this->getSelecttype());
        $question->appendChild($selectcount);
        // Elije como se corrije
        $gradingtype = $xml->createElement('gradingtype',$this->getSelecttype());
        $question->appendChild($gradingtype);
        // Elije si se muestra u oculta los detalles en el calculo de la puntuación cuando un estudiante
        // revisa las respuestas de este tipo de pregunta.
        $showgrading = $xml->createElement('showgrading',$this->getSelecttype());
        $question->appendChild($showgrading);

        // Añadimos los feedbacks
        $xml=$this->feedbackresposta($xml);


        // Añadir las preguntas
        $xml=$this->createAnswer($xml);

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
            $xml = $this->insertSon($xml,$answernodo,$answer->getText(),BeginXml::getRuta());
        }

        return $xml;
    }

}