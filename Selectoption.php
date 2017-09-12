<?php
/**
 * Created by PhpStorm.
 * User: msuarez
 * Date: 12/09/17
 * Time: 8:20
 */

class Selectoption
{
    private $text;
    private $group;

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
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }


}