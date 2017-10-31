<?php


class Answer
{
    private $attriFraction;
    private $attriFormat;
    private $text;
    private $textfeedback;

    /**
     * @return mixed
     */
    public function getAttriFraction()
    {
        return $this->attriFraction;
    }

    /**
     * @param mixed $attriFraction
     */
    public function setAttriFraction($attriFraction)
    {
        $this->attriFraction = $attriFraction;
    }

    /**
     * @return mixed
     */
    public function getAttriFormat()
    {
        return $this->attriFormat;
    }

    /**
     * @param mixed $attriFormat
     */
    public function setAttriFormat($attriFormat)
    {
        $this->attriFormat = $attriFormat;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = htmlspecialchars($text);
    }

    /**
     * @return mixed
     */
    public function getTextfeedback()
    {
        return $this->textfeedback;
    }

    /**
     * @param mixed $textfeedback
     */
    public function setTextfeedback($textfeedback)
    {
        $this->textfeedback = htmlspecialchars($textfeedback);
    }



}