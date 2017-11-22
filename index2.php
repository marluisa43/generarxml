<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<?php

require_once("PreguntaCorta.php");
require_once("PreguntaGapselect.php");
require_once("PreguntaDescription.php");
require_once ("Category.php");
require_once ("BeginXml.php");
require_once ("libLectura.php");


$directorio = 'xml/';
$ficheros  = scandir($directorio);
$contador=0;
$mixta=0;
$ensayo=0;
$cerrada=0;
$seleccion=0;
$ordenar=0;
$unir_puntos=0;
$zona_imagen=0;
$puntos_imagen=0;
$abierta=0;
$arrastrar=0;
$preg_dibujo=0;
$descripcion=0;
$contador_pregunta=0;
$numSection=0;
$flash=0;
$contador_applet=0;


foreach ($ficheros as $fichero){
    //Cargar el xml
    if (is_dir($directorio . $fichero) && $fichero!="." && $fichero!="..") {
        $numSection=0;
        $numPregunta=0;
        $contador++;
        /////////////////////////// CONTADOR
        if($contador!=0){

        $nombre_fichero = $directorio . $fichero . "/".$fichero.".xml";
        $ruta=$directorio . $fichero;
        echo "<br><br>".$nombre_fichero."<br><hr>";


        $folder = $fichero;
        $archivoxml=file_get_contents($nombre_fichero);
        $archivoxml=utf8_encode($archivoxml);
        $archivoxml= str_replace("","'",$archivoxml);
        $archivoxml= str_replace("",'"',$archivoxml);
        $archivoxml= str_replace("",'"',$archivoxml);
        $archivoxml= str_replace("","&euro;",$archivoxml);
        $archivoxml= str_replace("","&#150;",$archivoxml);
        $archivoxml= str_replace("","&#133;",$archivoxml);
        $archivoxml= str_replace("","&#149;",$archivoxml);
        $archivoxml= str_replace("","&#151;",$archivoxml);
        $archivoxml= str_replace("\'","'",$archivoxml);
        $archivoxml=utf8_decode($archivoxml);

        //fclose($gestor);
        $dom = new DOMDocument;
        $dom->loadXML($archivoxml);

        //INICIO XML
        $inicioXml = new BeginXml();
        $inicioXml->setCategory($fichero);
        //$categoria = new Category();
        //$inicioXml -> setCategory('$system$'.$categoria->getCategory($folder));
        $inicioXml->setRuta($directorio.$fichero);




        $xml=$inicioXml->getInicioXML();

        $sections=$dom->getElementsByTagName('section');

        foreach ($sections as $key=>$section) {
            $sectionPresentation=$section->getElementsByTagName('presentation_material');
            if($sectionPresentation->length!=0){
                $sectionPresentationMaterial=$section->getElementsByTagName('material');
                if($sectionPresentationMaterial->item(0)->nodeValue!=''){
                    //DESCRIPCION DE PREGUNTA
                    $descripcion++;
                    $numPregunta++;
                    informacionPregunta($contador,$numPregunta,"DESCRIPCION");
                    $xml=pregDescripcion($sectionPresentation->item(0),$inicioXml->getRoot(),$xml,$numPregunta,"Secció");
                }
            }

            //seleccionar cada pregunta del xml
            $preguntas = $section->getElementsByTagName('item');
            foreach ($preguntas as $key=>$pregunta) {
                
                $contador_pregunta++;
                $numPregunta++;
                //Identificar de que tipo es cada pregunta
                $choice = $pregunta->getElementsByTagName('render_choice');
                if($choice->length!=0){
                    /*Antigua comprobacion para diferenciar de multichoice de normal
                     * if($choice->item(0)->hasAttribute("display")){*/
                    $str = $pregunta->getElementsByTagName('flow');
                    if ($str->length >1) {
                        $str = $pregunta->getElementsByTagName('response_str');
                        if ($str->length != 0) {
                            //Pregunta MIXTA
                            informacionPregunta($contador,$numPregunta,"MIXTA");
                            $mixta++;
                            $xml=pregCloze($pregunta,$inicioXml->getRoot(),$xml,$numPregunta);
                        } else {
                            $flow_mat = $pregunta->getElementsByTagName('flow_mat');
                            if ($flow_mat->length != 0) {
                                //Pregunta CERRADA
                                informacionPregunta($contador,$numPregunta,"MULTICHOICE");
                                $cerrada++;
                                $xml=pregCloze($pregunta,$inicioXml->getRoot(),$xml,$numPregunta);
                            }
                            else{
                                //Pregunta SELECCION MULTIPLE
                                informacionPregunta($contador,$numPregunta,"SELECCION MULTIPLE");
                                $xml=pregCloze($pregunta,$inicioXml->getRoot(),$xml,$numPregunta);
                                $seleccion++;
                            }
                        }
                    }else{
                        //Pregunta SELECCION
                        informacionPregunta($contador,$numPregunta,"SELECCION");
                        $seleccion++;
                        $xml=pregSeleccion($pregunta,$inicioXml->getRoot(),$xml,$numPregunta);
                    }
                }else{
                    $lid = $pregunta->getElementsByTagName('response_lid');
                    if ($lid->length != 0) {
                        //Pregunta ORDENAR
                        if($lid->item(0)->getAttribute('rcardinality')=="Ordered") {
                            if ($lid->length>1) {
                                foreach ($lid as $keyPregOrd=>$elePregOrd){
                                    $numOrde=$numPregunta.".".($keyPregOrd+1);
                                    informacionPregunta($contador,$numPregunta,"ORDENAR MULTIPLE");
                                    $ordenar++;
                                    $xml=pregOrdenar($pregunta,$inicioXml->getRoot(),$xml,$numOrde,$keyPregOrd);
                                }
                            }else{
                                informacionPregunta($contador,$numPregunta,"ORDENAR SIMPLE");
                                $ordenar++;
                                $xml=pregOrdenar($pregunta,$inicioXml->getRoot(),$xml,$numPregunta,0);
                            }
                        }else{
                            $zona_processing = $pregunta->getElementsByTagName('resprocessing');
                            if ($zona_processing->length != 0) {
                                $zona_feed = $pregunta->getElementsByTagName('or');
                                if ($zona_feed->length != 0) {
                                    //Pregunta UNIR PUNTOS
                                    informacionPregunta($contador,$numPregunta,"UNIR PUNTOS (APPLET)");
                                    $xml=pregDescripcion($pregunta,$inicioXml->getRoot(),$xml,$numPregunta,"applet");
                                    $unir_puntos++;
                                }else{
                                    $zona_and = $pregunta->getElementsByTagName('and');
                                    $zona_no = $zona_and->item(0)->getElementsByTagName('not');
                                    if ($zona_no->length != 0) {
                                        //pregunta ZONA IMAGEN
                                        informacionPregunta($contador,$numPregunta,"ZONA IMAGEN (APPLET)");
                                        $xml=pregDescripcion($pregunta,$inicioXml->getRoot(),$xml,$numPregunta,"applet");
                                        $zona_imagen++;
                                    }else{
                                        //pregunta PUNTOS IMAGEN
                                        informacionPregunta($contador,$numPregunta,"PUNTOS IMAGEN (APPLET)");
                                        $xml=pregDescripcion($pregunta,$inicioXml->getRoot(),$xml,$numPregunta,"applet");
                                        $puntos_imagen++;
                                    }
                                }
                            }else{
                                //DESCRIPCION DE PREGUNTA
                                $descripcion++;
                                informacionPregunta($contador,$numPregunta,"DESCRIPCION");
                                $xml=pregDescripcion($pregunta,$inicioXml->getRoot(),$xml,$numPregunta,"Descripció");
                            }

                        }
                    }else {
                        $str = $pregunta->getElementsByTagName('response_str');
                        if ($str->length != 0) {

                            $varequal = $pregunta->getElementsByTagName('varequal');
                            if($varequal->length != 0){
                                //Pregunta ABIERTA
                                informacionPregunta($contador,$numPregunta,"ABIERTA");
                                $abierta++;
                                $xml=pregCloze($pregunta,$inicioXml->getRoot(),$xml,$numPregunta);
                            }else{
                                informacionPregunta($contador,$numPregunta,"ENSAYO");
                                $xml=pregEnsayo($pregunta,$inicioXml->getRoot(),$xml,$numPregunta,$contador);
                                $ensayo++;
                            }
                        }else {
                            //pregunta ARRASTRAR
                            $grp = $pregunta->getElementsByTagName('response_grp');
                            if ($grp->length != 0) {
                                informacionPregunta($contador,$numPregunta,"ARRASTRAR");
                                $arrastrar++;
                                $xml=pregArrastrar($pregunta,$inicioXml->getRoot(),$xml,$numPregunta);
                            } else {
                                $dibujo = $pregunta->getElementsByTagName('response_xy');
                                if ($dibujo->length != 0) {
                                    //pregunta DIBUJO
                                    informacionPregunta($contador,$numPregunta,"DIBUJO (APPLET)");
                                    $xml=pregDescripcion($pregunta,$inicioXml->getRoot(),$xml,$numPregunta,"applet");
                                    $preg_dibujo++;
                                } else {
                                    //DESCRIPCION PREGUNTA
                                    informacionPregunta($contador,$numPregunta,"DESCRIPCION");
                                    $xml=pregDescripcion($pregunta,$inicioXml->getRoot(),$xml,$numPregunta,"Descripció");
                                    $descripcion++;
                                }
                            }
                        }
                    }
                }
            }
        }
        $filexml = new SimpleXMLElement($nombre_fichero,NULL,true);
        $resultsecciones = $filexml->xpath('/questestinterop/assessment/section/presentation_material/flow_mat/material/matimage[@imagtype="application/x-shockwave-flash"]');
        $flash+=count($resultsecciones);
        $results = $filexml->xpath('/questestinterop/assessment/section/item/presentation/flow/material/matimage[@imagtype="application/x-shockwave-flash"]');
        $flash+=count($results);

        //Guardar el contenido en un archivo xml
        /*$temp_file=tempnam(sys_get_temp_dir(), 'XML_').'.xml';
        $xml_string = $xml->saveXML();
        $xml_string = htmlspecialchars_decode ($xml_string);
        $fp = fopen($temp_file, "w");
        fputs($fp, $xml_string);
        fclose($fp);*/

        //echo "<pre>".$xml_string."</pre>";

        // Con esto fuerzo la descarga.
        /*header("Content-Disposition: attachment; filename=\"" . $temp_file . "\";" );
        header('Content-Type: text/xml');
        readfile($temp_file);*/
        $carpeta = 'xml_transformados';
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        //$temp_file = tempnam($carpeta,"TMP0").'.xml';
        $nombreArchivoXML = $carpeta.'/'.$folder.'.xml';
        $xml_string = $xml->saveXML();
        $xml_string = htmlspecialchars_decode ($xml_string);
        $fp = fopen($nombreArchivoXML, "w");
        fputs($fp, $xml_string);
        fclose($fp);
        }
    }
}
function informacionPregunta($contador,$numPregunta,$tipo,$observaciones=NULL){
    echo "<b>Archivo " . $contador . " Pregunta " . $numPregunta . " Tipo ".$tipo. " " .$observaciones."</b><br>";
}

echo "<hr>";
echo "<br>Numero de archivos ".$contador."<br>";
echo "Numero de preguntas ".$contador_pregunta."<br>";
echo "Numero de preguntas mixtas ".$mixta."<br>";
echo "Numero de preguntas cerradas ".$cerrada."<br>";
echo "Numero de preguntas de seleccion ".$seleccion."<br>";
echo "Numero de preguntas de ordenar ".$ordenar."<br>";
echo "Numero de preguntas de unir puntos ".$unir_puntos."<br>";
echo "Numero de preguntas de seleccionar zonas de imagen ".$zona_imagen."<br>";
echo "Numero de preguntas de seleccionar puntos sobre imagen ".$puntos_imagen."<br>";
echo "Numero de preguntas abiertas ".$abierta."<br>";
echo "Numero de preguntas de ensayo ".$ensayo."<br>";
echo "Numero de preguntas de arrastrar ".$arrastrar."<br>";
echo "Numero de preguntas de dibujo ".$preg_dibujo."<br>";
echo "Numero de preguntas de descripcion ".$descripcion."<br>";
echo "Numero de archivos flash ".$flash."<br>";
echo "Numero de applets ".$contador_applet."<br>";
?>
</body>
</html>