<?php
require_once("ComunPreguntas.php");
require_once("Drag.php");
require_once("Drop.php");


class Ddimageortext extends ComunPreguntas
{
    private $backgroundImage;
    private $widthBackgroundImage;
    private $heightBackgroundImage;
    private $drags=array();
    private $drops=array();

    /**
     * Ddimageortext constructor.
     */
    public function __construct($root)
    {
        $this->setType('ddimageortext');
        parent::__construct($root);
    }

    /**
     * @return mixed
     */
    public function getBackgroundImage()
    {
        return $this->backgroundImage;
    }

    /**
     * @param mixed $backgroundImage
     */
    public function setBackgroundImage($backgroundImage)
    {
        $this->backgroundImage = $backgroundImage;
    }

    /**
     * @return array
     */
    public function getDrags()
    {
        return $this->drags;
    }

    /**
     * @param array $drags
     */
    public function setDrags($drags)
    {
        $this->drags = $drags;
    }

    /**
     * @return array
     */
    public function getDrops()
    {
        return $this->drops;
    }

    /**
     * @param array $drops
     */
    public function setDrops($drops)
    {
        $this->drops = $drops;
    }

    /**
     * @return mixed
     */
    public function getWidthBackgroundImage()
    {
        return $this->widthBackgroundImage;
    }

    /**
     * @param mixed $width
     */
    public function setWidthBackgroundImage($widthBackgroundImage)
    {
        $this->widthBackgroundImage = $widthBackgroundImage;
    }

    /**
     * @return mixed
     */
    public function getHeightBackgroundImage()
    {
        return $this->heightBackgroundImage;
    }

    /**
     * @param mixed $height
     */
    public function setHeightBackgroundImage($heightBackgroundImage)
    {
        $this->heightBackgroundImage = $heightBackgroundImage;
    }


    public function createDdimageortext($xml){
        $this->InitQuestion($xml);
        $question = $this->getQuestion();

        // Añadimos los feedbacks
        $xml=$this->feedbackresposta($xml);

        $xml=$this->loadBackgroundImage($xml,$question,$this->getBackgroundImage(),BeginXml::getRuta());


        $xml=$this->createDrags($xml,BeginXml::getRuta());
        $xml=$this->createDrops($xml);
        // Añadir las pistas
        $xml=$this->createHint($xml);

        return $xml;


    }

    private function loadBackgroundImage ($xml,$question,$image,$ruta){
        if (is_file($ruta.'/'.$image) and $image!=""){
            $this->redimensionarImage($ruta,$image,$this->getWidthBackgroundImage(),$this->getHeightBackgroundImage());

            $bgimg=file_get_contents($ruta.'/'.$image);
            $bgimgBase64=base64_encode($bgimg);

            $file=$xml->createElement('file',$bgimgBase64);
            $question->appendChild($file);
            $file->setAttribute('name',$image);
            $file->setAttribute('path','/');
            $file->setAttribute('encoding',"base64");
        }


        return ($xml);

    }

    private function createDrags($xml,$ruta){
        $drags=$this->getDrags();
        $question = $this->getQuestion();

        foreach ($drags as $drag){
            $dragnodo=$xml->createElement('drag');
            $question->appendChild($dragnodo);
            $no=$xml->createElement('no',$drag->getNo());
            $dragnodo->appendChild($no);
            $textet=$xml->createElement('text',$drag->getText());
            $dragnodo->appendChild($textet);
            $draggroupet=$xml->createElement('draggroup',$drag->getDraggroup());
            $dragnodo->appendChild($draggroupet);

            if (!is_null($drag->getFile())){
                if (is_file($ruta.'/'.$drag->getFile())){
                    $this->redimensionarImage($ruta,$drag->getFile(),$drag->getWidth(),$drag->getHeight());
                    $fileImage=file_get_contents($ruta.'/'.$drag->getFile());
                    $fileImageBase64=base64_encode($fileImage);
                    $fileimg=$xml->createElement('file',$fileImageBase64);
                    $dragnodo->appendChild($fileimg);
                    $fileimg->setAttribute('name',$drag->getFile());
                    $fileimg->setAttribute('path','/');
                    $fileimg->setAttribute('encoding',"base64");
                }

            }
        }
        return $xml;
    }

    private function createDrops($xml){
        $drops=$this->getDrops();
        $question = $this->getQuestion();

        foreach ($drops as $drop){
            $dropnodo=$xml->createElement('drop');
            $question->appendChild($dropnodo);
            $text=$xml->createElement('text',$drop->getText());
            $dropnodo->appendChild($text);
            $no=$xml->createElement('no',$drop->getNo());
            $dropnodo->appendChild($no);
            $choice=$xml->createElement('choice',$drop->getChoice());
            $dropnodo->appendChild($choice);
            $xleft=$xml->createElement('xleft',$drop->getXleft());
            $dropnodo->appendChild($xleft);
            $ytop=$xml->createElement('ytop',$drop->getYtop());
            $dropnodo->appendChild($ytop);

        }
        return $xml;
    }

    private function redimensionarImage($ruta,$image,$width,$height){
        $imageR=$ruta.'/'.$image;
        switch (exif_imagetype($imageR)){
            case IMAGETYPE_BMP:
                $recourseImage=imagecreatefromwbmp($imageR);
                break;
            case IMAGETYPE_JPEG:
                $recourseImage=imagecreatefromjpeg($imageR);
                break;
            case IMAGETYPE_PNG:
                $recourseImage=imagecreatefrompng($imageR);
                break;
            case IMAGETYPE_GIF:
                $recourseImage=imagecreatefromgif($imageR);
                break;
        }

        $imageNew = imagescale($recourseImage,$width,$height);
        switch (exif_imagetype($imageR)){
            case IMAGETYPE_BMP:
                imagewbmp($imageNew,$imageR);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($imageNew,$imageR);
                break;
            case IMAGETYPE_PNG:
                imagepng($imageNew,$imageR);
                break;
            case IMAGETYPE_GIF:
                imagegif($imageNew,$imageR);
                break;
        }
    }

}