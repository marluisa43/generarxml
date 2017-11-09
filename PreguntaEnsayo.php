<?php

require_once("ComunPreguntas.php");

class PreguntaEnsayo extends ComunPreguntas
{
    private $responseformat;
    private $responserequired;
    private $responsefieldlines;
    private $attachments;
    private $attachementsrequired;
    private $gradeinfo;
    private $responsetemplate;


    /**
     * PreguntaEnsayo constructor.
     */
    public function __construct($root)
    {
        $this->setType('essay');
        parent::__construct($root);
    }

    /**
     * @return mixed
     */
    public function getResponseformat()
    {
        return $this->responseformat;
    }

    /**
     * @param mixed $responseformat
     */
    public function setResponseformat($responseformat)
    {
        $this->responseformat = $responseformat;
    }

    /**
     * @return mixed
     */
    public function getResponserequired()
    {
        return $this->responserequired;
    }

    /**
     * @param mixed $responserequired
     */
    public function setResponserequired($responserequired)
    {
        $this->responserequired = $responserequired;
    }

    /**
     * @return mixed
     */
    public function getResponsefieldlines()
    {
        return $this->responsefieldlines;
    }

    /**
     * @param mixed $responsefieldlines
     */
    public function setResponsefieldlines($responsefieldlines)
    {
        $this->responsefieldlines = $responsefieldlines;
    }

    /**
     * @return mixed
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param mixed $attachments
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
    }

    /**
     * @return mixed
     */
    public function getAttachementsrequired()
    {
        return $this->attachementsrequired;
    }

    /**
     * @param mixed $attachementsrequired
     */
    public function setAttachementsrequired($attachementsrequired)
    {
        $this->attachementsrequired = $attachementsrequired;
    }

    /**
     * @return mixed
     */
    public function getGradeinfo()
    {
        return $this->gradeinfo;
    }

    /**
     * @param mixed $gradeinfo
     */
    public function setGradeinfo($gradeinfo)
    {
        $this->gradeinfo = $gradeinfo;
    }

    /**
     * @return mixed
     */
    public function getResponsetemplate()
    {
        return $this->responsetemplate;
    }

    /**
     * @param mixed $responsettemplate
     */
    public function setResponsetemplate($responsetemplate)
    {
        $this->responsetemplate = $responsetemplate;
    }


    /*
     * Crea la pregunta de ensayo
     */
    public function createEnsayo($xml){

        $this->InitQuestion($xml);

        $question = $this->getQuestion();

        // Rellenamos con el valor de formato de respuesta
        $responseformat = $xml->createElement('responseformat',$this->getResponseformat());
        $question->appendChild($responseformat);

        // Rellenamos con el valor de requerir texto
        $responserequired = $xml->createElement('responserequired',$this->getResponserequired());
        $question->appendChild($responserequired);

        // Rellenamos con el valor de tamaño de la caja de entrada
        $responsefieldlines = $xml->createElement('responsefieldlines',$this->getResponsefieldlines());
        $question->appendChild($responsefieldlines);

        // Rellenamos con el valor de Permitir archicos adjuntos
        $attachment = $xml->createElement('attachment',$this->getAttachments());
        $question->appendChild($attachment);

        // Rellenamos con el valor los archivos adjuntos permitidos
        $attachmentsrequired = $xml->createElement('attachmentsrequired',$this->getAttachementsrequired());
        $question->appendChild($attachmentsrequired);

        // Rellenamos con la información para evaluadores
        $graderinfo = $xml->createElement('graderinfo');
        $graderinfo = $question->appendChild($graderinfo);
        $graderinfo->setAttribute('format',"html");
        $text=$xml->createElement('text',$this->getGradeinfo());
        $graderinfo->appendChild($text);

        // Rellenamos con la información para la plantilla de respuesta
        $responsetemplate = $xml->createElement('responsetemplate');
        $responsetemplate = $question->appendChild($responsetemplate);
        $responsetemplate->setAttribute('format',"html");
        $text=$xml->createElement('text',$this->getResponsetemplate());
        $responsetemplate->appendChild($text);

        return $xml;

    }
}