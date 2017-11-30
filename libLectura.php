<?php
require_once("PreguntaSeleccion.php");
require_once("PreguntaDescription.php");
require_once("PreguntaCloze.php");
require_once("PreguntaOrden.php");
require_once("PreguntaEnsayo.php");
require_once("Ddimageortext.php");
require_once("Answer.php");
require_once("Hint.php");
require_once("Drag.php");
require_once("Drop.php");


/**
 * Transforma las preguntas de seleccion en el
 * formato correcto de Moodle
 * @param $pregunta
 * @param $root
 * @param $xml
 * @param $numero  - Numero de la pregunta
 * @return mixed
 */
function pregSeleccion($pregunta, $root, $xml,$numero){
    $preguntaSeleccion=new PreguntaSeleccion($root);

    //Enunciado de la pregunta
    $preguntaSeleccion->setQuestiontext(comprobarTextoMultimedia(agregarCdata(buscarmattext($pregunta))));

    $preguntaSeleccion->setGeneralfeedback('');
    $preguntaSeleccion->setShuffleanswers(true);
    $preguntaSeleccion->setAnswernumbering('abc');

    //Puntuacion acierto
    $preguntaSeleccion->setDefaultgrade(buscarPuntuacion($pregunta,"True"));

    //Puntuacion fallo
    $preguntaSeleccion->setPenalty(buscarPuntuacion($pregunta,"False"));

    //id de pregunta
    echo "ident " . $pregunta->getAttribute('ident') . "<br>";
    //$idPregunta=$pregunta->getAttribute('ident');

    //Feedback acierto
    $idFeedbackCorrecto=buscarIdFeedback($pregunta,"True");
    //Feedback fallo
    $idFeedbackIncorrecto=buscarIdFeedback($pregunta,"False");

    //Buscar las respuestas que son correctas
    $arrayCorrectas=buscarRespCor($pregunta);
    //Titulo de la pregunta
    $preguntaSeleccion->setName(buscarTituloPreg($pregunta,$numero,""));

    //Seleccionar la zona de espuestas
    $respuestas = $pregunta->getElementsByTagName('response_label');

    //Calcular el porcentaje para cada respuesta válida;
    if(count($arrayCorrectas)<=0){
        $porcentaje=0;
        crearAlerta(__FUNCTION__,"No hay respuestas correctas","e");
    }else{
        $porcentaje = (100 / count($arrayCorrectas));
    }

    //Comprobar que cuantas respuestas correctas hay
    if(count($arrayCorrectas)==1){
        $preguntaSeleccion->setSingle(true);
    }else{
        $preguntaSeleccion->setSingle(false);
    }

    foreach ($respuestas as $key => $respuesta) {

        $answer = new Answer();
        $answer->setAttriFormat("html");
        //Seleccionar el texto de la respuesta
        $answer->setText(agregarCdata(buscarmattext($respuesta)));
        $answer->setTextfeedback('');

        //id de respuesta
        $idRespuesta=$respuesta->getAttribute('ident');
        //Marcar las respuestas correctas
        $answer->setAttriFraction(marcarPregCorrectas($idRespuesta,$arrayCorrectas,$porcentaje));

        $answers[] = $answer;
        unset($answer);
    }
    if($respuestas->length==1){
        crearAlerta(__FUNCTION__,"Solo una opcion para elegir","e");
        $answer = new Answer();
        $answer->setAttriFormat("html");
        $answer->setText(" ");
        $answer->setTextfeedback('');

        //Marcar las respuestas correctas
        $answer->setAttriFraction("0");

        $answers[] = $answer;
        unset($answer);
    }
    $preguntaSeleccion->setAnswers($answers);

    //Seleccionar todos los items de feedback
    $itemsFeedback = $pregunta->getElementsByTagName('itemfeedback');
    foreach ($itemsFeedback as $key => $itemFeedback) {
        //id del elemento dfeedback
        $idFeedback=$itemFeedback->getAttribute('ident');
        if($idFeedbackCorrecto == $idFeedback){
            //Buscar el texto del feedback correcto
            $preguntaSeleccion->setTextCorrectfeedback(agregarCdata(buscarmattext($itemFeedback)));
        }
        elseif ($idFeedbackIncorrecto == $idFeedback){
            //Buscar el texto del feedback incorrecto
            $preguntaSeleccion->setTextIncorrectfeedback(agregarCdata(buscarmattext($itemFeedback)));
        }
        else{
            //Pista
            /*$hint = new Hint();
            $hint->setText(agregarCdata(buscarmattext($itemFeedback)));
            $hint->setShownumcorrect(true);
            $hint->setClearwrong(true);
            $hints[] = $hint;
            unset($hint);*/
        }
    }
    //$preguntaSeleccion->setHints($hints);
    $xmlPreg = $preguntaSeleccion->createMultiChoice($xml);
    return $xmlPreg;
}

/**
 * Transforma la descripcion en el
 * formato correcto de Moodle
 * @param $pregunta
 * @param $root
 * @param $xml
 * @param $numero  - Numero de la pregunta
 * @param $tipo  - Tipo de pregunta de descripcion
 * Opciones - Descripció
 *          - Secció
 *          - applet
 * @return mixed
 */
function pregDescripcion($pregunta, $root, $xml,$numero,$tipo){
    $preguntaDescription=new PreguntaDescription($root);
    //Titulo de la descipcion
    $preguntaDescription->setName(buscarTituloPreg($pregunta,$numero,$tipo));
    //Texto de la descripcion
    $texto=buscarmattext($pregunta);

    //Corrige error con la primera etiqueta flow sin texto
    if($texto==''){
        $segundoNivel = $pregunta->getElementsByTagName('flow');
        if($segundoNivel->item(1)){
            crearAlerta(__FUNCTION__,"Ejecutar doble flow","w");
            $texto=buscarmattext($segundoNivel->item(1));
        }
    }
    if($tipo=="applet"){
        $texto=$texto."<br>(applet)";
    }
    $preguntaDescription->setQuestiontext(comprobarTextoMultimedia(agregarCdata($texto)));
    $preguntaDescription->setGeneralfeedback('');

    $xmlPreg=$preguntaDescription->createDescription($xml);

    return $xmlPreg;
}

function pregEnsayo($pregunta, $root, $xml,$numero,$contador){

    $enunciadoPreg='';
    $enunciadoCabecera='';
    $nu="0";

    $flows = $pregunta->getElementsByTagName('flow');


    if($flows->length<=2) {
        $r=$flows->item(0)->getElementsByTagName('response_str');
        if ($r->length>1){
            echo ("Archivo " . $contador . " Pregunta " . $numero . " Tipo ensayo multiple en misma pregunta<br>");
        }else{
            echo "Archivo " . $contador . " Pregunta " . $numero . " Tipo ensayo simple<br>";
        }

        foreach ($flows as $key => $flow){
            if($key==0 and $flow->parentNode->nodeName!="flow"){
                $enunciadoPreg=buscarmattext($flow);
            }else{
                $enunciadoPreg=$enunciadoPreg.buscarmattextTodos($flow);

            }
        }

        $enunciadoCabecera = $enunciadoPreg;

        $preguntaEnsayo = new PreguntaEnsayo($root);

        $preguntaEnsayo->setName(buscarTituloPreg($pregunta, $numero, ""));
        $preguntaEnsayo->setQuestiontext(comprobarTextoMultimedia(agregarCdata($enunciadoCabecera)));

        $preguntaEnsayo->setDefaultgrade(buscarPuntuacion($pregunta, "True"));
        $preguntaEnsayo->setPenalty(buscarPuntuacion($pregunta, "False"));
        $preguntaEnsayo->setHidden(false);
        $preguntaEnsayo->setResponseformat('editor');
        $preguntaEnsayo->setResponserequired(1);
        $preguntaEnsayo->setResponsefieldlines(15);
        $preguntaEnsayo->setAttachments(0);
        $preguntaEnsayo->setAttachementsrequired(0);
        $preguntaEnsayo->setResponsetemplate("");

        $xml = $preguntaEnsayo->createEnsayo($xml);
    }else {
        echo "Archivo " . $contador . " Pregunta " . $numero . " Tipo ensayo multiple<br>";
        $enunciadoPreg="";
        $numeroPreguntas=$pregunta->getElementsByTagName("response_str")->length;
        $nr=0;
        foreach($flows as $keyf=>$flow){

            // materiales que hay dentro de cada flow
            $materials = $flow->getElementsByTagName('material');

            if ($keyf==0 and $flow->parentNode->nodeName != "flow") {
                $enunciadoCabecera = buscarmattext($flow);

            }else {

                $x = $flow->getElementsByTagName('response_str');

                if ($x->length == 0) {
                        $enunciadoPreg =$enunciadoPreg."<br>" . buscarmattext($flow);

                }else{
                    // Hay una pregunta de ensayo

                    $r=$flow->getElementsByTagName('response_str');
                    if ($r->length>1){
                        echo (" Tipo ensayo multiple en misma pregunta<br>");
                    }

                    if ($nr<$numeroPreguntas-1){
                        $enunciadoPreg = $enunciadoPreg.buscarmattextTodos($flow);
                        $enunciadoPreg = $enunciadoCabecera . "<br>" . $enunciadoPreg;
                        $preguntaEnsayo = new PreguntaEnsayo($root);
                        $nu++;
                        $preguntaEnsayo->setName(buscarTituloPreg($pregunta, $numero . "." . $nu, ""));
                        $preguntaEnsayo->setQuestiontext(comprobarTextoMultimedia(agregarCdata($enunciadoPreg)));

                        $preguntaEnsayo->setDefaultgrade(buscarPuntuacion($pregunta, "True"));
                        $preguntaEnsayo->setPenalty(buscarPuntuacion($pregunta, "False"));
                        $preguntaEnsayo->setHidden(false);
                        $preguntaEnsayo->setResponseformat('editor');
                        $preguntaEnsayo->setResponserequired(1);
                        $preguntaEnsayo->setResponsefieldlines(15);
                        $preguntaEnsayo->setAttachments(0);
                        $preguntaEnsayo->setAttachementsrequired(0);
                        $preguntaEnsayo->setResponsetemplate("");

                        $xml = $preguntaEnsayo->createEnsayo($xml);
                        $enunciadoPreg="";
                        $nr+=$x->length;
                    }else{
                        $enunciadoPreg = $enunciadoPreg.buscarmattextTodos($flow);
                    }
                }
            }
        }

        // última pregunta de ensayo con los textos que hayan debajo, si los hubiera.
        $enunciadoPreg = $enunciadoCabecera . "<br>" . $enunciadoPreg;
        $preguntaEnsayo = new PreguntaEnsayo($root);
        $nu++;
        $preguntaEnsayo->setName(buscarTituloPreg($pregunta, $numero . "." . $nu, ""));
        $preguntaEnsayo->setQuestiontext(comprobarTextoMultimedia(agregarCdata($enunciadoPreg)));

        $preguntaEnsayo->setDefaultgrade(buscarPuntuacion($pregunta, "True"));
        $preguntaEnsayo->setPenalty(buscarPuntuacion($pregunta, "False"));
        $preguntaEnsayo->setHidden(false);
        $preguntaEnsayo->setResponseformat('editor');
        $preguntaEnsayo->setResponserequired(1);
        $preguntaEnsayo->setResponsefieldlines(15);
        $preguntaEnsayo->setAttachments(0);
        $preguntaEnsayo->setAttachementsrequired(0);
        $preguntaEnsayo->setResponsetemplate("");

        $xml = $preguntaEnsayo->createEnsayo($xml);
    }

    return $xml;
}

function buscarmattextTodos($xml){

    $texto="";
    $materials = $xml->getElementsByTagName('material');
    if($materials->length==0){
        $texto="";
    }else{
        foreach($materials as $tex){
            $texto=$texto.$tex->nodeValue;
        }
    }
    return $texto;
}





/**
 * Transforma las preguntas abiertas, cerradas y mixtas en el
 * formato correcto de Moodle
 * @param $pregunta
 * @param $root
 * @param $xml
 * @param $numero  - Numero de la pregunta
 * @return mixed
 */
function pregCloze($pregunta, $root, $xml,$numero){
    $preguntaCloze = new PreguntaCloze($root);

    //Buscar los id de las respuestas incorrectas
    $arrayCorrectas=buscarRespCor($pregunta);

    // Titulo de la pregunta.
    $preguntaCloze->setName(buscarTituloPreg($pregunta,$numero,""));

    //Puntuacion acierto
    $preguntaCloze->setDefaultgrade(buscarPuntuacion($pregunta,"True"));
    //Puntuacion fallo
    $preguntaCloze->setPenalty(buscarPuntuacion($pregunta,"False"));

    $textoPreg='';
    //Enunciado de la pregunta
    $textoPreg=$textoPreg.buscarmattext($pregunta);
    //Seleccionar zona de respuestas
    $respuestas = $pregunta->getElementsByTagName('flow');
    $contadorElementos=0;
    foreach ($respuestas as $key=>$respuesta){
        if($key!=0){
            foreach ($respuesta->childNodes as $key2=>$item) {
                if (is_a($item, 'DOMElement')) {
                    if($item->localName=="material"){
                        //texto
                        $textoPreg=$textoPreg.buscarmattext($item);
                    }elseif($item->localName=="response_lid"){
                        //elemento select
                        $textoPreg=$textoPreg.leerPregMultiCloze($item,$arrayCorrectas,$contadorElementos);
                        $contadorElementos++;
                    }elseif($item->localName=="response_str"){
                        //elemento input
                        $idRespuesta=$item->getAttribute('ident');
                        $textoPreg=$textoPreg.leerPregShortCloze($pregunta,$idRespuesta);
                        $contadorElementos++;
                    }
                }
            }
        }
    }
    $preguntaCloze->setQuestiontext(comprobarTextoMultimedia('<![CDATA['.$textoPreg.']]>'));
    $preguntaCloze->setHidden(false);

    $xmlPreg=$preguntaCloze->createCloze($xml);
    return $xmlPreg;
}

/**
 * Transforma las preguntas de ordenar en el
 * formato correcto de Moodle
 * @param $pregunta
 * @param $root
 * @param $xml
 * @param $numero  - Numero de la pregunta
 * @param $bloque  - Numero del bloque de la pregunta dividida en partes
 * @return mixed
 */
function pregOrdenar($pregunta, $root, $xml,$numero,$bloque){
    $preguntaOrden = new PreguntaOrden($root);

    //Titulo de pregunta
    $preguntaOrden->setName(buscarTituloPreg($pregunta,$numero,""));
    //Enunciado de la pregunta
    $preguntaOrden->setQuestiontext(comprobarTextoMultimedia(agregarCdata(buscarmattext($pregunta))));
    $preguntaOrden->setGeneralfeedback("");
    //Puntuacion acierto
    $preguntaOrden->setDefaultgrade(buscarPuntuacion($pregunta,"True"));
    //Puntuacion fallo
    $preguntaOrden->setPenalty(buscarPuntuacion($pregunta,"False"));
    $preguntaOrden->setHidden(false);

    //id de pregunta
    echo "ident " . $pregunta->getAttribute('ident') . "<br>";
    //$idPregunta=$pregunta->getAttribute('ident');

    //Identificar la orientacion de la pregunta
    $orientacion=$pregunta->getElementsByTagName('ims_render_object');
    if($orientacion->length!=0){
        if($orientacion->item(0)->getAttribute('orientation')=="column"){
            $preguntaOrden->setLayouttype('VERTICAL');
        }
        if($orientacion->item(0)->getAttribute('orientation')=="row"){
            $preguntaOrden->setLayouttype('HORIZONTAL');
        }
    }else{
        $preguntaOrden->setLayouttype('VERTICAL');
        crearAlerta(__FUNCTION__,"No hay orientación","w");
    }

    $preguntaOrden->setSelecttype('ALL');
    $preguntaOrden->setSelectcount('0');
    $preguntaOrden->setGradingtype('ALL_OR_NOTHING');
    $preguntaOrden->setShowgrading('SHOW');


    //Seleccionar un bloque de preguntas de ordenar
    $bloqueOrd = $pregunta->getElementsByTagName('response_lid');


    //id del bloque
    $idBloque=$bloqueOrd->item($bloque)->getAttribute('ident');


    //Seleccionar la zona de respuestas
    $respuestas = $bloqueOrd->item($bloque)->getElementsByTagName('response_label');

    foreach ($respuestas as $key => $respuesta) {
        $answer= new Answer();

        //id del elemento de la respuesta
        $idRespuesta=$respuesta->getAttribute('ident');

        //Buscar el orden correcto de las respuestas
        $arrayCorrectas=buscarRespOrdenar($pregunta,$idBloque);

        $posRespuesta=array_search($idRespuesta,$arrayCorrectas);
        $answer->setAttriFraction(($posRespuesta+1).".0000000");
        $answer->setAttriFormat("html");
        //Texto del elemento.
        $answer->setText(agregarCdata(buscarmattext($respuesta)));
        $answer->setTextfeedback('');
        //Insertar el objeto en el array con la posicion correcta
        $answers[$posRespuesta]=$answer;
        unset($answer);
    }
    //ordenar el array por posicion
    ksort($answers);
    $preguntaOrden->setAnswers($answers);

    //Buscar los id de los feedback
    $idFeedbackCorrecto=buscarIdFeedback($pregunta,"True");
    $idFeedbackIncorrecto=buscarIdFeedback($pregunta,"False");

    //Seleccionar la zona de feedback
    $itemsFeedback = $pregunta->getElementsByTagName('itemfeedback');
    foreach ($itemsFeedback as $key => $itemFeedback) {
        //id del feeback
        $idFeedback = $itemFeedback->getAttribute('ident');
        if ($idFeedbackCorrecto == $idFeedback) {
            //buscar el texto del feedback correcto
            $preguntaOrden->setTextCorrectfeedback(agregarCdata(buscarmattext($itemFeedback)));
        } elseif ($idFeedbackIncorrecto == $idFeedback) {
            //buscar el texto del feedback incorrecto
            $preguntaOrden->setTextIncorrectfeedback(agregarCdata(buscarmattext($itemFeedback)));
        }
    }
    $xmlPreg=$preguntaOrden->createOrdering($xml);
    return $xmlPreg;
}

function pregArrastrar($pregunta, $root, $xml,$numero){
    $preguntaDdimageortext = new Ddimageortext($root);

    $preguntaDdimageortext->setName(buscarTituloPreg($pregunta,$numero,""));
    $preguntaDdimageortext->setQuestiontext(comprobarTextoMultimedia(agregarCdata(buscarmattext($pregunta))));
    $preguntaDdimageortext->setGeneralfeedback("");
    $preguntaDdimageortext->setDefaultgrade(buscarPuntuacion($pregunta,"True"));
    $preguntaDdimageortext->setPenalty(buscarPuntuacion($pregunta,"False"));
    $preguntaDdimageortext->setHidden(false);

    //id de pregunta
    echo "ident " . $pregunta->getAttribute('ident') . "<br>";
    //$idPregunta=$pregunta->getAttribute('ident');

    //Buscar los id de los feedback
    $idFeedbackCorrecto=buscarIdFeedback($pregunta,"True");
    $idFeedbackIncorrecto=buscarIdFeedback($pregunta,"False");

    $itemsFeedback = $pregunta->getElementsByTagName('itemfeedback');
    foreach ($itemsFeedback as $key => $itemFeedback) {
        //id del feeback
        $idFeedback = $itemFeedback->getAttribute('ident');
        if ($idFeedbackCorrecto == $idFeedback) {
            //buscar el texto del feedback correcto
            $preguntaDdimageortext->setTextCorrectfeedback(agregarCdata(buscarmattext($itemFeedback)));
        } elseif ($idFeedbackIncorrecto == $idFeedback) {
            //buscar el texto del feedback incorrecto
            $preguntaDdimageortext->setTextIncorrectfeedback(agregarCdata(buscarmattext($itemFeedback)));
        }
    }
    $imagenFondo=buscarmatimage($pregunta);
    $nuevoSizey=1;
    $nuevoSizex=1;
    if(isset($imagenFondo->url)) {
        if ($imagenFondo->height > 400) {
            $nuevoSizey = 400 / $imagenFondo->height;
            $nuevoAnchoImageFondo = $imagenFondo->width * $nuevoSizey;
            if ($nuevoAnchoImageFondo > 600) {
                $nuevoSizex = 600 / $nuevoAnchoImageFondo;
            }
        } else if ($imagenFondo->width > 600) {
            $nuevoSizex = 600 / $imagenFondo->width;
        }

        $nuevoSize=$nuevoSizex*$nuevoSizey;
        $preguntaDdimageortext->setBackgroundImage($imagenFondo->url);
        $preguntaDdimageortext->setHeightBackgroundImage($imagenFondo->height*$nuevoSize);
        $preguntaDdimageortext->setWidthBackgroundImage($imagenFondo->width*$nuevoSize);

    }else{
        crearAlerta(__FUNCTION__,"No existe imagen de fondo","e");
        $nuevoSize=0;
    }

    $ims_render=$pregunta->getElementsByTagName('ims_render_object');

    foreach ($pregunta->getElementsByTagName('varsubset') as $key => $itemRespCorrect) {
        $parteCorrectas = explode(",",$itemRespCorrect->nodeValue);
        $arrayCorrectas[] = trim($parteCorrectas[1]);
        $arrayElementos[] = trim($parteCorrectas[0]);
    }

    foreach ($ims_render->item(0)->getElementsByTagName('response_label') as $key => $itemResp) {
        //echo "--------------".buscarmattext($itemResp)."---------<br>";
        if($itemResp->hasAttribute("rarea")){
            if(isset($arrayCorrectas)){
                if(in_array(trim($itemResp->getAttribute("ident")),$arrayCorrectas)){
                    $posRespuesta=array_search(trim($itemResp->getAttribute("ident")),$arrayCorrectas);
                    $cordenadas=explode(",",$itemResp->nodeValue);
                    $drop= new Drop();
                    $drop->setText("");
                    $drop->setNo(($posRespuesta+1));
                    $drop->setChoice(($posRespuesta+1));
                    $drop->setXleft($cordenadas[0]*($nuevoSize));
                    $drop->setYtop($cordenadas[1]*($nuevoSize));
                    $drops[]=$drop;
                    unset($drop);
                }
            }else{
                crearAlerta(__FUNCTION__,"Error al crear drop","e");
                $drop= new Drop();
                $drops[]=$drop;
                unset($drop);
            }

        }elseif ($itemResp->firstChild->nextSibling->nodeName=="material"){
            if(isset($arrayElementos)){
                if(in_array(trim($itemResp->getAttribute("ident")),$arrayElementos)) {
                    $posRespuesta = array_search(trim($itemResp->getAttribute("ident")), $arrayElementos);
                    $drag = new Drag();
                    $drag->setNo(($posRespuesta + 1));
                    $drag->setDraggroup(1);
                    $itemRespImg=$itemResp->getElementsByTagName('matimage');
                    if($itemRespImg->length!=0){
                        $imagenElemnt=buscarmatimage($itemResp);
                        $drag->setFile($imagenElemnt->url);
                        $drag->setWidth($imagenElemnt->width);
                        $drag->setHeight($imagenElemnt->height);
                    }
                    $itemRespText=$itemResp->getElementsByTagName('mattext');
                    if($itemRespText->length != 0){
                        $drag->setText(agregarCdata(buscarmattext($itemResp)));
                    }
                    $drags[] = $drag;
                    unset($drag);
                }
            }else{
                crearAlerta(__FUNCTION__,"Error al crear drag","e");
                $drag = new Drag();
                $drags[] = $drag;
                unset($drag);
            }
        }
    }

    $preguntaDdimageortext->setDrags($drags);
    $preguntaDdimageortext->setDrops($drops);

    //creamos la pregunta
    $xmlPreg=$preguntaDdimageortext->createDdimageortext($xml);
    return $xmlPreg;
}


/**
 * @param $xml
 * @param $arrayRespuesta
 * @return string
 */
function leerPregMultiCloze($xml, $arrayRespuesta,$bloque){
    //{1:MULTICHOICE:rojo~%100%blanco~negro}
    $comprobacion=0;
    $modo=0;
    $texto='{1:MULTICHOICE:';
    $respuestas = $xml->getElementsByTagName('response_label');
    if($respuestas->length!=0){
        if($respuestas->item(0)->getAttribute("ident")=="lab01"){
            crearAlerta(__FUNCTION__,"Activado modo id iguales","w");
            $modo=1;
        }
    }
    foreach ($respuestas as $key => $respuesta) {
        $id=$respuesta->getAttribute("ident");
        if($modo==1){
            if ($arrayRespuesta[$bloque]==$id) {
                //echo $id."-----VERDAD----<br>";
                $texto=$texto."%100%".strip_tags(buscarmattext($respuesta), '</BR>')."~";
                $comprobacion++;
            } else {
                //echo $id."-----FALSA----<br>";
                $texto=$texto.strip_tags(buscarmattext($respuesta), '</BR>')."~";
            }
        }else{
            if (in_array($id, $arrayRespuesta)) {
                //echo $id."-----VERDAD----<br>";
                $texto=$texto."%100%".strip_tags(buscarmattext($respuesta), '</BR>')."~";
                $comprobacion++;
            } else {
                //echo $id."-----FALSA----<br>";
                $texto=$texto.strip_tags(buscarmattext($respuesta), '</BR>')."~";
            }
        }
    }
    if($comprobacion==0){
        if($respuestas->length==0){
            $texto=$texto."NULL~";
            crearAlerta(__FUNCTION__,"No hay ningún elemento en la lista","e");
        }
        crearAlerta(__FUNCTION__,"No hay ninguna respuesta correcta","e");
        $texto=$texto."%100%NULL~";
    }
    if($comprobacion>1){
        crearAlerta(__FUNCTION__,"Hay varias respuestas correctas","e");
    }
    $texto=trim($texto, '~');
    $texto=$texto."}";
    return $texto;
}

function leerPregShortCloze($xml,$idRespuesta){
    $comprobacion=0;
    $texto='{1:SHORTANSWER:';
    $listaRespCorrectas = $xml->getElementsByTagName('conditionvar');
    if($listaRespCorrectas->length==0){
        crearAlerta(__FUNCTION__,"No hay respuesta correcta","e");
        $texto='';
    }else{
        foreach ($listaRespCorrectas->item(0)->getElementsByTagName('varequal') as $key => $respuesta) {
            if($idRespuesta==$respuesta->getAttribute('respident')){
                $texto=$texto."=".$respuesta->nodeValue."~";
                $comprobacion=1;
            }
        }
        if($comprobacion==0){
            crearAlerta(__FUNCTION__,"no hay respuesta","e");
            $texto=$texto."=".$idRespuesta."~";
        }
        $texto=trim($texto, '~');
        $texto=$texto."}";
    }
    return $texto;
}

function buscarTituloPreg($xml,$numero,$tipo){
    if($xml->hasAttribute('title')){
        if($xml->getAttribute('title')==''){
            if($tipo!=''){
                $titulo=$numero.". ".$tipo;
            }else{
                $titulo=$numero.". Pregunta";
            }
        }else{
            if($tipo!=''){
                if($tipo=="Secció"){
                    $titulo=$numero.". ".$tipo. " " .$xml->getAttribute('title');
                }else{
                    $titulo=$numero.". ".$xml->getAttribute('title');
                }

            }else{
                $titulo=$numero. ". " .$xml->getAttribute('title');
            }

        }
    }else{
        if($tipo!=''){
            $titulo=$numero.". ".$tipo;
        }else{
            $titulo=$numero.". Pregunta";
        }
    }
    echo $titulo.'<br>';
    return $titulo;
}

/**
 * Buscar el id de los feedbacks
 * @param $xml
 * @param $tipo TRUE/FALSE
 * @return mixed
 */
function buscarIdFeedback($xml, $tipo){
    $id=0;
    $listaRespCorrectas = $xml->getElementsByTagName('respcondition');
    if($listaRespCorrectas->length==0){
        $id=0;
        crearAlerta(__FUNCTION__,"No hay feedback 1","w");
    }else{
        foreach ($listaRespCorrectas as $key => $zonaResp) {
            //Seleccionar los feedbacks
            $zonaFeedback = $zonaResp->getElementsByTagName('setvar');
            if($zonaFeedback->length==0){
                $id=0;
                crearAlerta(__FUNCTION__,"No hay feedback 2","w");
            }else{
                foreach ($zonaFeedback as $key => $feedback) {
                    if ($feedback->nodeValue == $tipo) {
                        $respFeedback = $zonaResp->getElementsByTagName('displayfeedback');
                        if($respFeedback->length==0){
                            $id=0;
                            crearAlerta(__FUNCTION__,"No hay feedback 3","w");
                        }else{
                            //Seleccionar id de feedback correcto
                            $id = $respFeedback->item(0)->getAttribute('linkrefid');
                        }

                    }
                }
            }
        }
    }
    return $id;
}


/**
 * Buscar las respuestas incorrectas
 * @param $xml
 * @return array
 */
function buscarRespInc($xml){
    $array= array();
    //Seleccionar la zona donde se encuentra las respuestas y el feedback
    $listaRespCorrectas = $xml->getElementsByTagName('respcondition');
    foreach ($listaRespCorrectas as $key => $zonaResp) {
        if($key==0) {
            //Seleccionamos las preguntas y las metemos en un array de respuestas incorrectas
            $respNoCorrectas = $zonaResp->getElementsByTagName('not');
            foreach ($respNoCorrectas as $key => $respNoCorrecta) {
                $array[] = trim($respNoCorrecta->nodeValue);
            }
        }
    }
    return $array;
}

function buscarRespCor($xml){
    $arrayCorrectas= array();
    //Seleccionar la zona donde se encuentra las respuestas y el feedback
    $listaRespCorrectas = $xml->getElementsByTagName('respcondition');
    foreach ($listaRespCorrectas as $key => $zonaResp) {
        if($key==0) {
            //Seleccionamos las preguntas y las metemos en un array de respuestas incorrectas
            //$respCorrectas = $zonaResp->getElementsByTagName('and');
            $respuestas = $zonaResp->getElementsByTagName('*');
            foreach ($respuestas as $key => $respuesta) {
                if($respuesta->nodeName=="varequal" or $respuesta->nodeName=="varsubset"){
                    if($respuesta->parentNode->nodeName=="and" or $respuesta->parentNode->nodeName=="or"){
                        $arrayCorrectas[] = trim($respuesta->nodeValue);
                    }else{
                        $arrayIncorrectas[] = trim($respuesta->nodeValue);
                    }
                }
            }
        }
    }
    return $arrayCorrectas;
}

function buscarRespOrdenar($xml,$idBloque){
    $listaRespCorrectas = $xml->getElementsByTagName('varequal');
    $comprobacion=0;
    $comprobacionNull=0;
    foreach ($listaRespCorrectas as $respCorrecta){
        if($respCorrecta->getAttribute("respident")==$idBloque) {
            $respCorrectas = explode(",", $respCorrecta->nodeValue);
            if(in_array("null",$respCorrectas)){
                $comprobacionNull=1;
            }
            $comprobacion = 1;
        }
    }
    if($comprobacion==0){
        crearAlerta(__FUNCTION__,"No hay respuestas correctas","e");
    }
    if($comprobacionNull==1){
        crearAlerta(__FUNCTION__,"Respuesta null","e");
    }
    return $respCorrectas;
}


function marcarPregCorrectas($id,$array,$porcentaje){
    //Buscar el id dentro del array de respuestas correctas
    //para identificar si la respuesta es correcta o incorrecta
    if (in_array($id, $array)) {
        return $porcentaje;
    } else {
        return 0;
    }
}

function buscarPuntuacion($xml,$tipo){
    $puntuacion=0;
    $tests=$xml->getElementsByTagName('respcondition');
    foreach ($tests as $test){
        foreach ($test->childNodes as $key=>$item) {
            if ($item->nodeName=="setvar"){
                if ($item->getAttribute("varname")=="SCORE"){
                    if($item->nextSibling->nextSibling->nodeName=="displayfeedback") {
                        $nodeName=$item->previousSibling->previousSibling->nodeName;
                        $nodeValue=$item->previousSibling->previousSibling->nodeValue;
                    }else{
                        $nodeName=$item->nextSibling->nextSibling->nodeName;
                        $nodeValue=$item->nextSibling->nextSibling->nodeValue;
                    }
                    if($nodeName=="setvar" and $nodeValue==$tipo){
                        $puntuacion=$item->nodeValue;
                    }
                }
            }
        }
    }
    return $puntuacion;
}

function buscarmattext($xml){
    //Seleccionar los enunciados de cada pregunta
    //var_dump($xml);
    $textos = $xml->getElementsByTagName('material');
    if($textos->length==0){
        $nodes = $xml->getElementsByTagName('*');
    }else{
        $nodes = $textos->item(0)->getElementsByTagName('*');
    }
    $texto='';
    for ($i = 0; $i < $nodes->length; $i++) {
        //QUITAR COMENTARIO
        $texto=$texto.tipoTexto($nodes->item($i));
    }
    return $texto;
}
function agregarCdata($texto){
    $textoInicio="<![CDATA[";
    $textoFinal=']]>';
    return $textoInicio.$texto.$textoFinal;
}

function buscarmatimage($xml){
    $imagen=new stdClass();
    $itemImage = $xml->getElementsByTagName('matimage');
    if($itemImage->length!=0){
        if($itemImage->item(0)->getAttribute('uri')!=''){
            $imagen->url = $itemImage->item(0)->getAttribute('uri');
            $imagen->width = $itemImage->item(0)->getAttribute('width');
            $imagen->height = $itemImage->item(0)->getAttribute('height');
        }
    }
    return $imagen;
}

function tipoTexto($nodo){
    $texto='';
    if($nodo->localName=="mattext") {
        if ($nodo->hasAttribute("texttype")) {
            //echo "HTML<br>";
            $texto=$nodo->nodeValue;
        } else {
            //echo "TEXTO<br>";
            $texto=$nodo->nodeValue;
        }
    }
    if($nodo->localName=="matimage") {
        $imagetype=$nodo->getAttribute("imagtype");
        $porciones = explode("/", $imagetype);
        if($porciones[0]=="image"){
            $texto=transformarImagen($nodo);
        }elseif($porciones[0]=="application"){
            $texto=transformarFlash($nodo);
            echo "++++Archivo flash<br>";
        }else{
            //echo "NO SE***************************************************";
        }
    }
    if($nodo->localName=="mataudio") {
        $texto=transformarAudio($nodo);
    }
    if($nodo->localName=="matjclic") {
        //echo "Jclic<br>";
        $texto=transformarJclic($nodo);
        echo "++++++ archivo Jclic<br>";
    }
    if($nodo->localName=="matapplication") {
        //echo "Documento<br>";
        echo "++++Documento";
    }
    if($nodo->localName=="matvideo") {
        $texto=transformarVideo($nodo);
    }
    return $texto;
}

function transformarImagen($nodo){
    $texto='<img src="';
    $texto=$texto.'@@PLUGINFILE@@/'.$nodo->getAttribute("uri").'"';
    $texto=$texto.' alt=""';
    $texto=$texto.' width="'.$nodo->getAttribute("width").'"';
    $texto=$texto.' height="'.$nodo->getAttribute("height").'"';
    $texto=$texto.' role="presentation" class="img-responsive atto_image_button_text-bottom">';
    if($nodo->getAttribute("uri")==""){
        $texto='';
    }
    return $texto;
}

function transformarFlash($nodo){
    $texto='<object width="'.$nodo->getAttribute("width").'" height="'.$nodo->getAttribute("height").'" >';
    $texto=$texto.'<param name="movie" value="';
    $texto=$texto.'@@PLUGINFILE@@/'.$nodo->getAttribute("uri").'">';
    $texto=$texto.'<param name="play" value="true" >';
    $texto=$texto.'<embed src="@@PLUGINFILE@@/'.$nodo->getAttribute("uri").'"></embed></object>';
    if($nodo->getAttribute("uri")==""){
        $texto='';
    }
    return $texto;
}

function transformarJclic($nodo){
    $nombre=basename($nodo->getAttribute("uri"),".jclic.zip");
    $texto='<object type="text/html" data="https://clic.xtec.cat/projects/'.$nombre.'/jclic.js/index.html" width="'.$nodo->getAttribute("width").'" height="'.$nodo->getAttribute("height").'"></object><br>';

    if(substr_compare($nodo->getAttribute("uri"),"http",0,4)){
        $texto=$texto.'<a href="@@PLUGINFILE@@/'.$nodo->getAttribute("uri").'"';
    }else{
        $texto=$texto.'<a href="'.$nodo->getAttribute("uri").'"';
    }
    $texto=$texto.'>'.basename($nodo->getAttribute("uri")).'</a>';
    if($nodo->getAttribute("uri")==""){
        $texto='';
    }
    return $texto;
}

function transformarVideo($nodo){
    $texto='<video controls="true"><source src="';
    $texto=$texto.'@@PLUGINFILE@@/'.$nodo->getAttribute("uri").'">';
    $texto=$texto.'@@PLUGINFILE@@/'.$nodo->getAttribute("uri");
    $texto=$texto.'</video>';
    return $texto;
}

function transformarAudio($nodo){
    $texto='<audio controls="true"><source src="';
    $texto=$texto.'@@PLUGINFILE@@/'.$nodo->getAttribute("uri").'">';
    $texto=$texto.'@@PLUGINFILE@@/'.$nodo->getAttribute("uri");
    $texto=$texto.'</audio>';
    return $texto;
}

function comprobarTextoMultimedia($ristra){
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
            if (!is_file(BeginXml::getRuta() . '/' . substr($image, 15))){
                $im=substr($image,15);
                $imf=explode("/",$im);
                $ima=$imf[sizeof($imf)-1];
                if (is_file(BeginXml::getRuta().'/'.$ima)){
                    $ristra=str_replace($image,'@@PLUGINFILE@@/'.$ima,$ristra);
                }
            }

        }else{
            if (!is_file(BeginXml::getRuta() . '/' . $image)){
                $im=$image;
                $imf=explode("/",$im);
                $ima=$imf[sizeof($imf)-1];

                if (is_file(BeginXml::getRuta().'/'.$ima)){
                    $ristra=str_replace($image,'@@PLUGINFILE@@/'.$ima,$ristra);
                }
            }
        }

    }
    return $ristra;
}

function crearAlerta($funcion,$mensaje,$tipo){
    if($tipo=="e"){
        echo "<span style='color:red'>ERROR****** ".__CLASS__." ".$funcion." -- ".$mensaje."</span><br>";
    }if($tipo=="w"){
        echo "<span style='color:orange'>WARNING****** ".__CLASS__." ".$funcion." -- ".$mensaje."</span><br>";
    }
}
