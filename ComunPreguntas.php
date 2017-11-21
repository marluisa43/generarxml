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

        $questiontext=str_replace('./','@@PLUGINFILE@@/',$questiontext);

        $questiontext=$this->addSRC($questiontext);
        $questiontext=$this->addHref($questiontext);
        $questiontext=$this->addSon($questiontext);
        $questiontext=$this->addFlash($questiontext);

        $this->questiontext = htmlspecialchars($questiontext);

    }

    public function addSRC($text) {

        $images = array();
        $re_extractImages='/< *img[^>]*src *= *["\']?([^"\']*)/ims';
        $texto=$text;
        $valor=strpos($text,'<img ');

        while ($valor) {
            preg_match_all( $re_extractImages  , $text , $matches);
            $images=$matches[1];
            $posicion= strpos($text,'<img src=');
            $text = substr($text,$posicion);
            $valor=strpos($text,'<img src=');
        }

        $introducidas=array();
        foreach ($images as $image){
            if (!strpos($image,'/')){
                $valorSustituir=$image;
                $sustituto='@@PLUGINFILE@@/'.$image;
                if(!in_array($sustituto,$introducidas)){
                    $texto=str_replace($valorSustituir,$sustituto,$texto);
                    $introducidas[]=$sustituto;
                }
            }
        }

        // Comprobar cuales son internas, y cuales son externas.
        $textoB=$texto;
        $images = array();
        $valor=strpos($textoB,'<img ');

        while ($valor) {
            preg_match_all( $re_extractImages  , $textoB , $matches);
            $images=$matches[1];
            $posicion= strpos($textoB,'<img src=');
            $textoB = substr($textoB,$posicion);
            $valor=strpos($textoB,'<img src=');
        }

        foreach($images as $image){
            if (strpos($image,'@@PLUGINFILE@@')===false){
                if (strpos($image,'/')!==false){
                    $urlexists = $this->url_exists( $image );
                    echo ("<br>ENLACE EXTERIOR: ".$image."<br>");
                }
            }
        }


       // Sino comienza con <![CDATA[ lo añade
       if(mb_substr($texto,0,9)!='<![CDATA['){
            if ( mb_substr($texto,-3,3)== ']]>'){
                $texto="<![CDATA[".$texto;
            }
        }

        return $texto;
    }

    public function addHref($text) {

        $htmls = array();
        $re_extractImages='/< *a[^>]*href *= *["\']?([^"\']*)/ims';
        $texto=$text;
        $valor=strpos($text,'<a ');

        while ($valor) {
            preg_match_all( $re_extractImages  , $text , $matches);
            $htmls=$matches[1];
            $posicion= strpos($text,'<a href=');
            $text = substr($text,$posicion);
            $valor=strpos($text,'<a href=');
        }


        $introducidas=array();
        foreach ($htmls as $html){
            if (!strpos($html,'/')){
                $valorSustituir=$html;
                $sustituto='@@PLUGINFILE@@/'.$html;
                if (!strpos($html,'?')){
                    if(!in_array($sustituto,$introducidas)){
                        $texto=str_replace($valorSustituir,$sustituto,$texto);
                        $introducidas[]=$sustituto;
                    }
                }
            }
        }


        // Comprobar cuales son internas, y cuales son externas.
        $textoB=$texto;
        $htmls = array();
        $valor=strpos($textoB,'<a ');

        while ($valor) {
            preg_match_all( $re_extractImages  , $textoB , $matches);
            $htmls=$matches[1];
            $posicion= strpos($textoB,'<a href=');
            $textoB = substr($textoB,$posicion);
            $valor=strpos($textoB,'<a href=');
        }

        foreach($htmls as $html){
            if (strpos($html,'@@PLUGINFILE@@')===false){
                if (strpos($html,'/')!==false){
                    $urlexists = $this->url_exists( $html );
                    echo ("<br>ENLACE EXTERIOR: ".$html."<br>");
                }
            }
        }


        // Sino comienza con <![CDATA[ lo añade
        if(mb_substr($texto,0,9)!='<![CDATA['){
            if ( mb_substr($texto,-3,3)== ']]>'){
                $texto="<![CDATA[".$texto;
            }
        }


        return $texto;
    }

    public function addSon($text) {

        $sons = array();
        $re_extractSons='/< *source[^>]*src *= *["\']?([^"\']*)/ims';
        $texto=$text;
        $valor=strpos($text,'<source ');

        while ($valor) {
            preg_match_all( $re_extractSons  , $text , $matches);
            $sons=$matches[1];
            $posicion= strpos($text,'<source src=');
            $text = substr($text,$posicion);
            $valor=strpos($text,'<source src=');
        }

        $introducidas=array();
        foreach ($sons as $son){
            if (!strpos($son,'/')){
                $valorSustituir=$son;
                $sustituto='@@PLUGINFILE@@/'.$son;
                if(!in_array($sustituto,$introducidas)){
                    $texto=str_replace($valorSustituir,$sustituto,$texto);
                    $introducidas[]=$sustituto;
                }
            }
        }

        // Comprobar cual es exterior
        $textoB=$texto;
        $sons = array();
        $valor=strpos($textoB,'<source ');

        while ($valor) {
            preg_match_all( $re_extractSons  , $textoB , $matches);
            $sons=$matches[1];
            $posicion= strpos($textoB,'<source src=');
            $textoB = substr($textoB,$posicion);
            $valor=strpos($textoB,'<source src=');
        }
        foreach($sons as $son){
            if (strpos($son,'@@PLUGINFILE@@')===false){
                if (strpos($son,'/')!==false) {
                    $urlexists = $this->url_exists( $son );
                    echo("<br>ENLACE EXTERIOR: " . $son . "<br>");
                }
            }
        }


        // Sino comienza con <![CDATA[ lo añade
        if(mb_substr($texto,0,9)!='<![CDATA['){
            if ( mb_substr($texto,-3,3)== ']]>'){
                $texto="<![CDATA[".$texto;
            }
        }
        return $texto;
    }

    public function addFlash($text) {

        $flashs = array();
        $re_extractFlash='/< *embed[^>]*src *= *["\']?([^"\']*)/ims';
        $texto=$text;
        $valor=strpos($text,'<embed ');

        while ($valor) {
            preg_match_all( $re_extractFlash  , $text , $matches);
            $flashs=$matches[1];
            $posicion= strpos($text,'<embed src=');
            $text = substr($text,$posicion);
            $valor=strpos($text,'<embed src=');
        }

        $introducidas=array();
        foreach ($flashs as $flash){
            if (!strpos($flash,'/')){
                $valorSustituir=$flash;
                $sustituto='@@PLUGINFILE@@/'.$flash;
                if(!in_array($sustituto,$introducidas)){
                    $texto=str_replace($valorSustituir,$sustituto,$texto);
                    $introducidas[]=$sustituto;
                }
            }
        }

        // Comprobar si es exterior el enlace
        $textoB=$texto;
        $flashs = array();
        $valor=strpos($textoB,'embed');

        while ($valor) {
            preg_match_all( $re_extractFlash  , $textoB , $matches);
            $flashs=$matches[1];

            $posicion= strpos($textoB,'embed src=');
            $textoB = substr($textoB,$posicion);
            $valor=strpos($textoB,'embed src=');
        }
        foreach($flashs as $flash){
            if (strpos($flash,'@@PLUGINFILE@@')===false){
                if (strpos($flash,'/')!==false) {
                    $urlexists = $this->url_exists( $flash );
                    echo("<br>ENLACE EXTERIOR: " . $flash . "<br>");
                }
            }
        }



        // Sino comienza con <![CDATA[ lo añade
        if(mb_substr($texto,0,9)!='<![CDATA['){
            if ( mb_substr($texto,-3,3)== ']]>'){
                $texto="<![CDATA[".$texto;
            }
        }
        return $texto;
    }

    /**
     * @param null $url
     * @return bool
     * Comprueba si una url existe.
     */
    public function url_exists( $url = NULL ) {

        if( empty( $url ) ){
            return false;
        }

        $ch = curl_init( $url );

        //Establecer un tiempo de espera
        curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );

        //establecer NOBODY en true para hacer una solicitud tipo HEAD
        curl_setopt( $ch, CURLOPT_NOBODY, true );
        //Permitir seguir redireccionamientos
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        //recibir la respuesta como string, no output
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        $data = curl_exec( $ch );

        //Obtener el código de respuesta
        $httpcode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        //cerrar conexión
        curl_close( $ch );

        //Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal)
        $accepted_response = array( 200, 301, 302 );
        echo("Codigo: $httpcode");
        if( in_array( $httpcode, $accepted_response ) ) {
            return true;
        } else {
            return false;
        }

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
        $this->generalfeedback = htmlspecialchars($generalfeedback);
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
        $this->textCorrectfeedback = htmlspecialchars($textCorrectfeedback);
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
        $this->textPartiallycorrectfeedback = htmlspecialchars($textPartiallycorrectfeedback);
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
        $this->textIncorrectfeedback = htmlspecialchars($textIncorrectfeedback);
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
        $xml = $this->insertImage($xml,$enum,$this->getQuestiontext(),BeginXml::getRuta());
        $xml = $this->insertHTML($xml,$enum,$this->getQuestiontext(),BeginXml::getRuta());
        $xml = $this->insertSon($xml,$enum,$this->getQuestiontext(),BeginXml::getRuta());
        $xml = $this->insertFlash($xml,$enum,$this->getQuestiontext(),BeginXml::getRuta());

        if(!is_null($this->getGeneralfeedback())){
            // Rellenamos la retroalimentación general de la pregunta.
            $generalfeedback=$xml->createElement('generalfeedback');
            $generalfeedback=$question->appendChild($generalfeedback);
            $generalfeedback->setAttribute('format','html');
            $text=$xml->createElement('text',$this->getGeneralfeedback());
            $generalfeedback->appendChild($text);
            $xml = $this->insertImage($xml,$generalfeedback,$this->getGeneralfeedback(),BeginXml::getRuta());
            $xml = $this->insertHTML($xml,$generalfeedback,$this->getGeneralfeedback(),BeginXml::getRuta());
            $xml = $this->insertSon($xml,$generalfeedback,$this->getGeneralfeedback(),BeginXml::getRuta());
            $xml = $this->insertFlash($xml,$generalfeedback,$this->getGeneralfeedback(),BeginXml::getRuta());
        }

        if(is_numeric($this->getDefaultgrade())){
            // Rellenamos con el valor de la pregunta por defecto.
            $defaultgrade= $xml->createElement('defaultgrade',$this->getDefaultgrade());
            $question->appendChild($defaultgrade);
        }

        if(is_numeric($this->getPenalty())){
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

    /*
     * Inserta las imagenes que están en la ristra
     * para la pregunta $answernodo
     *
     */
    public function insertImage($xml,$answernodo,$ristra,$ruta){
        $text = $ristra;
        $images = array();
        $text = htmlspecialchars_decode($text);
        // Nuestra expresión regular, que busca los src dentro
        // de las etiquetas <img/>
        // y que no tenga en cuenta mayusculas o minusculas
        $re_extractImages='/< *img[^>]*src *= *["\']?([^"\']*)/ims';

        $valor=strpos($text,'<img ');

        while ($valor) {
            preg_match_all( $re_extractImages  , $text , $matches);
            $images=$matches[1];
            $posicion= strpos($text,'<img src=');
            $text = substr($text,$posicion);
            $valor=strpos($text,'<img src=');
        }

        $images = array_reverse($images);

        foreach($images as $image) {
            if (substr($image, 0, 15) == '@@PLUGINFILE@@/') {
                if (is_file($ruta . '/' . substr($image, 15))){
                    $im = file_get_contents($ruta . '/' . substr($image, 15));
                    $imgBase64 = base64_encode($im);

                    $file = $xml->createElement('file', $imgBase64);
                    $answernodo->appendChild($file);
                    $file->setAttribute('name', substr($image, 15));
                    $file->setAttribute('path', '/');
                    $file->setAttribute('encoding', "base64");
                }else{
                    echo '****** NO EXISTE LA IMAGEN DE FONDO '.substr($image,15)."<br>";
                }

            }

        }
        return ($xml);
    }


    /*
     * Inserta las páginas html que están en la ristra
     * para la pregunta $answernodo
     *
     */
    public function insertHTML($xml,$answernodo,$ristra,$ruta){
        $text = $ristra;
        $htmls = array();
        $text = htmlspecialchars_decode($text);
        // Nuestra expresión regular, que busca los src dentro
        // de las etiquetas <img/>
        // y que no tenga en cuenta mayusculas o minusculas
        $re_extractImages='/< *a[^>]*href *= *["\']?([^"\']*)/ims';

        $valor=strpos($text,'<a ');

        while ($valor) {
            preg_match_all( $re_extractImages  , $text , $matches);
            $htmls=$matches[1];
            $posicion= strpos($text,'<a href=');
            $text = substr($text,$posicion);
            $valor=strpos($text,'<a href=');
        }

        $htmls = array_reverse($htmls);

        foreach($htmls as $html) {
            if (substr($html, 0, 15) == '@@PLUGINFILE@@/') {
                if (is_file($ruta . '/' . substr($html, 15))){
                    $ht = file_get_contents($ruta . '/' . substr($html, 15));
                    $htmlBase64 = base64_encode($ht);

                    $file = $xml->createElement('file', $htmlBase64);
                    $answernodo->appendChild($file);
                    $file->setAttribute('name', substr($html, 15));
                    $file->setAttribute('path', '/');
                    $file->setAttribute('encoding', "base64");
                }else{
                    echo '****** NO EXISTE HTML '.substr($html,15)."<br>";
                }

            }

        }
        return ($xml);
    }



    public function insertSon($xml,$answernodo,$ristra,$ruta){
        $text = $ristra;
        $sons = array();
        $text = htmlspecialchars_decode($text);
        // Nuestra expresión regular, que busca los src dentro
        // de las etiquetas <img/>
        // y que no tenga en cuenta mayusculas o minusculas
        $re_extractSons='/< *source[^>]*src *= *["\']?([^"\']*)/ims';

        $valor=strpos($text,'<source ');

        while ($valor) {
            preg_match_all( $re_extractSons  , $text , $matches);
            $sons=$matches[1];
            $posicion= strpos($text,'<source src=');
            $text = substr($text,$posicion);
            $valor=strpos($text,'<source src=');
        }

        $sons = array_reverse($sons);
        foreach($sons as $son){
            if (substr($son, 0, 15) == '@@PLUGINFILE@@/') {
                if (is_file($ruta . '/' . substr($son, 15))) {
                    $sn = file_get_contents($ruta . '/' . substr($son, 15));
                    $sonBase64 = base64_encode($sn);

                    $file = $xml->createElement('file', $sonBase64);
                    $answernodo->appendChild($file);
                    $file->setAttribute('name', substr($son, 15));
                    $file->setAttribute('path', '/');
                    $file->setAttribute('encoding', "base64");
                }else{
                    echo '****** NO EXISTE MULTIMEDIA '.substr($son,15)."<br>";
                }
            }
        }
        return ($xml);
    }


    /*
    * Inserta los Flash que están en la ristra
    * para la pregunta $answernodo
    *
    */
    public function insertFlash($xml,$answernodo,$ristra,$ruta){
        $text = $ristra;
        $flashs = array();
        $text = htmlspecialchars_decode($text);
        // Nuestra expresión regular, que busca los embed dentro
        // de las etiquetas <embed/>
        // y que no tenga en cuenta mayusculas o minusculas
        $re_extractImages='/< *embed[^>]*src *= *["\']?([^"\']*)/ims';

        $valor=strpos($text,'<embed ');

        while ($valor) {
            preg_match_all( $re_extractImages  , $text , $matches);
            $flashs=$matches[1];
            $posicion= strpos($text,'<embed src=');
            $text = substr($text,$posicion);
            $valor=strpos($text,'<embed src=');
        }

        $flashs = array_reverse($flashs);

        foreach($flashs as $flash) {
            if (substr($flash, 0, 15) == '@@PLUGINFILE@@/') {
                if (is_file($ruta . '/' . substr($flash, 15))){
                    $fs = file_get_contents($ruta . '/' . substr($flash, 15));
                    $imgBase64 = base64_encode($fs);

                    $file = $xml->createElement('file', $imgBase64);
                    $answernodo->appendChild($file);
                    $file->setAttribute('name', substr($flash, 15));
                    $file->setAttribute('path', '/');
                    $file->setAttribute('encoding', "base64");
                }else{
                    echo '****** NO EXISTE EL FICHERO FLASH '.substr($flash,15)."<br>";
                }

            }

        }
        return ($xml);
    }

}