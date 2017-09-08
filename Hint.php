<?php


class Hint
{
    private $text;
    private $shownumcorrect;
    private $clearwrong;

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
        $this->text = $text;
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
     * @return mixed
     */
    public function getClearwrong()
    {
        return $this->clearwrong;
    }

    /**
     * @param mixed $clearwrong
     */
    public function setClearwrong($clearwrong)
    {
        $this->clearwrong = $clearwrong;
    }



}