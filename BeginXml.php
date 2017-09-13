<?php


class BeginXml{

    private $cabecera;
    private $category;
    private $root;
    private static $ruta;


    /**
     * Pregunta constructor.
     */
    public function __construct()
    {
        $this->xml=null;
        $this->cabecera = new DOMDocument("1.0","UTF-8");
    }


    /**
     * @return mixed
     */
    public function getCabecera()
    {
        return $this->cabecera;
    }

    /**
     * @param mixed $cabecera
     */
    public function setCabecera($version,$encoding)
    {
        $this->cabecera = new DOMDocument($version,$encoding);
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
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
    public static function getRuta()
    {
        return self::$ruta;
    }

    /**
     * @param mixed $ruta
     */
    public static function setRuta($ruta)
    {
        self::$ruta = $ruta;
    }




    /**
     * @return mixed
     * Nos pone en el xml la parte común a todas las preguntas.
     */
    public function getInicioXML(){
        $xml=$this->getCabecera();
        $xml->preserveWhiteSpace = false;
        $xml->formatOutput = true;

        $root = $xml->createElement('quiz');
        $root = $xml->appendChild($root);
        $this->setRoot($root);

        if (!is_null($this->getCategory())){
            $question = $xml->createElement('question');
            $question = $root->appendChild($question);
            $question->setAttribute('type','category');
            $categoria = $xml->createElement('category');
            $categoria = $question->appendChild($categoria);
            $text=$xml->createElement('text',$this->getCategory());
            $categoria->appendChild($text);

        }

        return $xml;
    }

}