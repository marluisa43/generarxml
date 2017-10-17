<?php


class Drop
{
    private $text;
    private $no;
    private $choice;
    private $xleft;
    private $ytop;

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
    public function getNo()
    {
        return $this->no;
    }

    /**
     * @param mixed $no
     */
    public function setNo($no)
    {
        $this->no = $no;
    }

    /**
     * @return mixed
     */
    public function getChoice()
    {
        return $this->choice;
    }

    /**
     * @param mixed $choice
     */
    public function setChoice($choice)
    {
        $this->choice = $choice;
    }

    /**
     * @return mixed
     */
    public function getXleft()
    {
        return $this->xleft;
    }

    /**
     * @param mixed $xleft
     */
    public function setXleft($xleft)
    {
        $this->xleft = $xleft;
    }

    /**
     * @return mixed
     */
    public function getYtop()
    {
        return $this->ytop;
    }

    /**
     * @param mixed $ytop
     */
    public function setYtop($ytop)
    {
        $this->ytop = $ytop;
    }


}