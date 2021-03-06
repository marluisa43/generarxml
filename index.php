<?php
require_once("BeginXml.php");
require_once("PreguntaCorta.php");
require_once("Answer.php");
require_once("PreguntaSeleccion.php");
require_once("PreguntaGapselect.php");
require_once("Selectoption.php");
require_once("PreguntaCloze.php");
require_once("PreguntaOrden.php");
require_once("Ddimageortext.php");
require_once("Category.php");
require_once ("PreguntaEnsayo.php");

// Inicializamos el fichero xml con la categoria a la que pertenece las preguntas que vamos a poner en el xml.

$inicioXml = new BeginXml();
$inicioXml->setCategory("prueba");

// Obtenemos la categoria
$categoria = new Category();
$folder = "mud_up_down_pr_en";
//$inicioXml -> setCategory('$system$'.$categoria->getCategory($folder));
$inicioXml -> setCategory('$system$'.'/prueba');

// Fin

$inicioXml->setRuta("/var/www/html/imagenes");

$xml=$inicioXml->getInicioXML();

/* ----------------------------------------------------------------- */
/*
 * Probar pregunta corta
 *
 *
 */
/*$preguntaCorta=new PreguntaCorta($inicioXml->getRoot());

// Rellenamos la pregunta con los datos
$preguntaCorta->setName("Respuesta corta");
//$preguntaCorta->setQuestiontext("<![CDATA[<p> con enlace <img src=\"http://www.xtec.es/~aribas4/llengua/dialectologia/imatges/pa%EFsos%20catalans%202.jpg\" border=\"0\" alt=\"TEXTalt\" width=\"215\" height=\"314\"/> ,con sonido&nbsp;</p><p><img src=\"@@PLUGINFILE@@/llaut.jpg\" alt=\"\" width=\"157\" height=\"303\" role=\"presentation\" class=\"img-responsive atto_image_button_middle\"></p><p>&nbsp;<audio controls=\"true\"><source src=\"@@PLUGINFILE@@/008698998_prev.mp3\">@@PLUGINFILE@@/008698998_prev.mp3</audio>&nbsp;<br></p><p>&nbsp;<video controls=\"true\"><source src=\"@@PLUGINFILE@@/13.Bars i restaurants.mp4\">@@PLUGINFILE@@/13.Bars i restaurants.mp4</video>&nbsp;<br></p>]]>");
//$preguntaCorta->setQuestiontext("<![CDATA[<font face=\"georgia,times new roman,times,serif\"><font size=\"2\">L’accés a l’editor es fa per </font><a href=\"http://www.edu365.com/pls/edu365/edu_sec_plsql_2.login?p_url=index.jsp?page=index\"><font size=\"2\">Internet</font></a><font size=\"2\"> i és necessari autenticar-se com a usuari de l’edu365.com.</font></font>]]>");

//$preguntaCorta->setQuestiontext("<![CDATA[­<br> <center> <object height=\"355\" width=\"425\"> <param name=\"movie\" value=\"http://www.youtube.com/v/zfH9DhbFjdE&rel=1\" /> <param name=\"wmode\" value=\"transparent\" /> <embed src=\"http://www.youtube.com/v/zfH9DhbFjdE&rel=1\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" height=\"355\" width=\"425\" />­ </object> </center>]]");
$preguntaCorta->setQuestiontext("<![CDATA[Ordena els climes de la llista d'acord amb l'ordre dels números del mapa...<BR/><img src=\"@@PLUGINFILE@@/llaut.jpg\" alt=\"\" width=\"157\" height=\"303\" role=\"presentation\" class=\"img-responsive atto_image_button_middle\"><img src=\"climes002a.jpg\" alt=\"\" width=\"650\" height=\"471\" role=\"presentation\" class=\"img-responsive atto_image_button_text-bottom\"> otra <img src=\"violade.jpg\" alt=\"\" width=\"157\" height=\"340\" role=\"presentation\" class=\"img-responsive atto_image_button_text-bottom\">]]>");

$preguntaCorta->setType("shortanswer");
$preguntaCorta->setGeneralfeedback("<![CDATA[<p>Retroalimentación de respuesta corta</p>]]>");
$preguntaCorta->setDefaultgrade(1.0000000);
$preguntaCorta->setPenalty(0.3333333);
$preguntaCorta->setHidden(false);
$preguntaCorta->setUsecase(0);

// Rellenamos las contestaciones posibles.
$answer= new Answer();
$answer->setAttriFraction("100");
$answer->setAttriFormat("moodle_auto_format");
$answer->setText("bien");
$answer->setTextfeedback(("<![CDATA[<p>Retroalimentación de respuesta corta bien</p>]]>"));
$answers[]=$answer;
unset($answer);

$answer= new Answer();
$answer->setAttriFraction("0");
$answer->setAttriFormat("moodle_auto_format");
$answer->setText("mal");
$answer->setTextfeedback(("<![CDATA[<p>Retroalimentación de respuesta corta mal</p>]]>"));
$answers[]=$answer;
unset($answer);

$preguntaCorta->setAnswers($answers);

// Creamos pistas

$hint= new Hint();
$hint->setText("<![CDATA[<p>Pista 1</p>]]>");
$hint->setShownumcorrect(true);
$hint->setClearwrong(true);
$hints[]=$hint;
unset($hint);

$hint= new Hint();
$hint->setText("<![CDATA[<p>Pista 2</p>]]>");
$hint->setShownumcorrect(false);
$hint->setClearwrong(true);
$hints[]=$hint;
unset($hint);

// Asignamos las pistas a la pregunta
$preguntaCorta->setHints($hints);


// Llamamos para construir el xml correspondiente a esta pregunta.
$xml=$preguntaCorta->createShortanswer($xml);*/


// Fin pregunta corta

/* ----------------------------------------------------------------- */
/*
 * Probar pregunta multichoice
 *
 *
 */


//creamos el contenedor de la pregunta de selección
/*$preguntaSeleccion=new PreguntaSeleccion($inicioXml->getRoot());


// Rellenamos con los datos de la pregunta.
$preguntaSeleccion->setName("Pregunta multichoice");
$preguntaSeleccion->setQuestiontext('<![CDATA[<p>con sonido&nbsp;</p><p><img src="@@PLUGINFILE@@/llaut.jpg" alt="" width="157" height="303" role="presentation" class="img-responsive atto_image_button_middle"></p><p>&nbsp;<audio controls="true"><source src="@@PLUGINFILE@@/008698998_prev.mp3">@@PLUGINFILE@@/008698998_prev.mp3</audio>&nbsp;<br></p><p>&nbsp;<video controls="true"><source src="@@PLUGINFILE@@/13.Bars i restaurants.mp4">@@PLUGINFILE@@/13.Bars i restaurants.mp4</video>&nbsp;<br></p>]]>');
//$preguntaSeleccion->setQuestiontext('<![CDATA[<div align="left"><span style="line-height: 115%;"><strong><em>Música i teatre</em></strong></span><span style="line-height: 115%;"> van units des que el teatre va donar les primeres passes. Amb el temps, a Europa primer i estats Units després convisqueren varies formes d’espectacle que inclogueren música. La barreja d’aquests elements del </span><span style="line-height: 115%;"><a href="http://es.wikipedia.org/wiki/Vodevil">Vaudeville</a></span><span style="line-height: 115%;">, </span><span style="line-height: 115%;">l’òpera</span><span style="line-height: 115%;">, </span><span style="line-height: 115%;">l</span><span style="line-height: 115%;">’</span><span style="line-height: 115%;">opereta</span><span style="line-height: 115%;">, </span><span style="line-height: 115%;"><a href="http://es.wikipedia.org/wiki/Melodrama">el melodrama</a></span><span style="line-height: 115%;">, <a href="http://es.wikipedia.org/wiki/Burlesque">la burlesque</a></span><span style="line-height: 115%;">, </span><span style="line-height: 115%;">la revue</span><span style="line-height: 115%;"> i </span><span style="line-height: 115%;"><a href="http://www.sedajazz.es/agenda/evento.php?mes=03&amp;anyo=2009&amp;id=4288">El minstrel</a></span><span style="line-height: 115%;"> va generar “la COMEDIA MUSICAL” i que avui en dia coneixem com a “MUSICAL”, desenvolupat al llarg del segle XIX i principis del XX.</span> </div> <p align="justify"> </p> <p align="center"><u><em>DUES HORES DE BROADWAY EN 10 MINUTS</em></u> </p> <p align="center"> <object height="344" width="425"> <param name="movie" value="http://www.youtube.com/v/bvfP3rL6gUE&amp;hl=es_ES&amp;fs=1&amp;color1=0x5d1719&amp;color2=0xcd311b" /> <param name="allowFullScreen" value="true" /> <param name="allowscriptaccess" value="always" /> <embed src="http://www.youtube.com/v/bvfP3rL6gUE&amp;hl=es_ES&amp;fs=1&amp;color1=0x5d1719&amp;color2=0xcd311b" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" height="344" width="425" /> </object> </p>]]>');

$preguntaSeleccion->setGeneralfeedback('<![CDATA[<p>Retroalimentación General de respuesta multichoice</p>]]>');
// si se pone false Single, es multirespuesta, si pones true es solo una respuesta
$preguntaSeleccion->setSingle(false);
// Shuffleanswers es true si barajas las respuesta, sino es false
$preguntaSeleccion->setShuffleanswers(true);
$preguntaSeleccion->setAnswernumbering('abc');
$preguntaSeleccion->setTextCorrectfeedback('Esta genial');
$preguntaSeleccion->setTextPartiallycorrectfeedback('Esta parcialmente correcto');
$preguntaSeleccion->setTextIncorrectfeedback('Tienes que estudiar más.');


// Creamos las contestaciones posibles.
$answer= new Answer();
$answer->setAttriFraction("50");
$answer->setAttriFormat("html");
$answer->setText('<![CDATA[<p><img src="@@PLUGINFILE@@/violade.jpg" alt="" width="157" height="340" role="presentation" class="img-responsive atto_image_button_text-bottom"><br></p>]]>');
$answer->setTextfeedback('<![CDATA[<p>retroalimentación de primera elección.</p>]]>');
$answers[]=$answer;
unset($answer);

$answer= new Answer();
$answer->setAttriFraction("50");
$answer->setAttriFormat("html");
$answer->setText('<![CDATA[<p>Segunda Elección</p><p>&nbsp;<video controls="true"><source src="@@PLUGINFILE@@/13.Bars i restaurants.mp4">@@PLUGINFILE@@/13.Bars i restaurants.mp4</video>&nbsp;<br></p>]]>');
$answer->setTextfeedback('<![CDATA[<p>Retroalimentacion de segunda elección.</p>]]>');
$answers[]=$answer;
unset($answer);

$answer= new Answer();
$answer->setAttriFraction("0");
$answer->setAttriFormat("html");
$answer->setText('<![CDATA[<p>&nbsp;<audio controls="true"><source src="@@PLUGINFILE@@/elaboracio1.mp3">@@PLUGINFILE@@/elaboracio1.mp3</audio>&nbsp;<br></p>]]>');
$answer->setTextfeedback('<![CDATA[<p>Retroalimentación de 3</p>]]>');
$answers[]=$answer;
unset($answer);
// Asignamos las respuesta a la pregunta
$preguntaSeleccion->setAnswers($answers);

// Creamos pistas

$hint= new Hint();
$hint->setText("<![CDATA[<p>Pista 1</p>]]>");
$hint->setShownumcorrect(true);
$hint->setClearwrong(true);
$hints[]=$hint;
unset($hint);

$hint= new Hint();
$hint->setText("<![CDATA[<p>Pista 2</p>]]>");
$hint->setShownumcorrect(false);
$hint->setClearwrong(true);
$hints[]=$hint;
unset($hint);

// Asignamos las pistas a la pregunta
$preguntaSeleccion->setHints($hints);


// Llamamos para construir el xml correspondiente a esta pregunta.
$xml=$preguntaSeleccion->createMultiChoice($xml);*/


/* ------------------------------------------ */
// Probar pregunta espacios en blanco.



/*$preguntaGapSelect=new PreguntaGapselect($inicioXml->getRoot());
$selectoption= new Selectoption();

// Rellenamos con los datos de la pregunta.
$preguntaGapSelect->setName("Pregunta de selección de palabras perdidas");
$preguntaGapSelect->setQuestiontext('<![CDATA[<p>Este es el primer enunciado:</p><p><img src="@@PLUGINFILE@@/guitarra_barroca.jpg" alt="" width="157" height="340" role="presentation" class="img-responsive atto_image_button_middle">&nbsp;[[1]]<br></p><p><br></p><p>Segundo parte:</p><p><img src="@@PLUGINFILE@@/violade.jpg" alt="" width="157" height="340" role="presentation" class="img-responsive atto_image_button_middle">&nbsp;[[4]]<br></p>]]>');
$preguntaGapSelect->setGeneralfeedback('<![CDATA[<p>Retroalimentación de espacios en blanco.</p>]]>');
$preguntaGapSelect->setDefaultgrade(1.0000000);
$preguntaGapSelect->setPenalty(0.3333333);
$preguntaGapSelect->setHidden(false);
$preguntaGapSelect->setShuffleanswers(true);

$preguntaGapSelect->setTextCorrectfeedback('Esta genial');
$preguntaGapSelect->setTextPartiallycorrectfeedback('Esta parcialmente correcto');
$preguntaGapSelect->setTextIncorrectfeedback('Tienes que estudiar más.');

$preguntaGapSelect->setShownumcorrect(true);

// Rellenamos con los valores de los espacios en blanco.
$selectoption= new Selectoption();
$selectoption->setText("Blanco");
$selectoption->setGroup(1);
$selectoptions[]=$selectoption;
unset($selectoption);

$selectoption= new Selectoption();
$selectoption->setText("Amarillo");
$selectoption->setGroup(1);
$selectoptions[]=$selectoption;
unset($selectoption);

$selectoption= new Selectoption();
$selectoption->setText("Negro");
$selectoption->setGroup(1);
$selectoptions[]=$selectoption;
unset($selectoption);

$selectoption= new Selectoption();
$selectoption->setText("Rosa");
$selectoption->setGroup(2);
$selectoptions[]=$selectoption;
unset($selectoption);

$selectoption= new Selectoption();
$selectoption->setText("Azul");
$selectoption->setGroup(2);
$selectoptions[]=$selectoption;
unset($selectoption);

$selectoption= new Selectoption();
$selectoption->setText("Verde");
$selectoption->setGroup(2);
$selectoptions[]=$selectoption;
unset($selectoption);

// Asignamos las selecciones a la pregunta
$preguntaGapSelect->setSelectoptions($selectoptions);

// Creamos pistas

$hint= new Hint();
$hint->setText("<![CDATA[<p>Pista 1</p>]]>");
$hint->setShownumcorrect(true);
$hint->setClearwrong(true);
$hints[]=$hint;
unset($hint);

$hint= new Hint();
$hint->setText("<![CDATA[<p>Pista 2</p>]]>");
$hint->setShownumcorrect(false);
$hint->setClearwrong(true);
$hints[]=$hint;
unset($hint);

// Asignamos las pistas a la pregunta
$preguntaGapSelect->setHints($hints);

// Llamamos para construir el xml correspondiente a esta pregunta.
$xml=$preguntaGapSelect->createGapselect($xml);*/


//-----------------------------------
/*
 * Probamos preguntas de descripción
 *
 */
/*$preguntaDescription=new PreguntaDescription($inicioXml->getRoot());

// Rellenamos con los datos de la pregunta.
$preguntaDescription->setName("Pregunta de Descripción");
$preguntaDescription->setQuestiontext('<![CDATA[<p>Enunciado de descripción.</p>]]>');
$preguntaDescription->setGeneralfeedback('<![CDATA[<p>Segunda Elección</p><p>&nbsp;<video controls="true"><source src="@@PLUGINFILE@@/13.Bars i restaurants.mp4">@@PLUGINFILE@@/13.Bars i restaurants.mp4</video>&nbsp;<br></p>]]>');

$xml=$preguntaDescription->createDescription($xml);*/
// Fin pregunta descripcion


//---------------------------------
/*
 * Probamos la pregunta cloze
 *
 */
/*$preguntaCloze = new PreguntaCloze($inicioXml->getRoot());

// Rellenamos con los datos de la pregunta.
$preguntaCloze->setName("pregunta close");
$preguntaCloze->setQuestiontext('<![CDATA[<p>De que color es el caballo blanco de santiago {1:MULTICHOICE:rojo~%100%blanco~negro} y que color es el mejor {1:SHORTANSWER:=rojo}</p><p><br></p>]]>');
$preguntaCloze->setGeneralfeedback('<![CDATA[<p>retroalimentación genereral de close</p>]]>');
$preguntaCloze->setPenalty(0.3333333);
$preguntaCloze->setHidden(false);

// Creamos pistas

$hint= new Hint();
$hint->setText("<![CDATA[<p>Pista 1</p>]]>");
$hint->setShownumcorrect(true);
$hint->setClearwrong(true);
$hints[]=$hint;
unset($hint);

$hint= new Hint();
$hint->setText("<![CDATA[<p>Pista 2</p>]]>");
$hint->setShownumcorrect(false);
$hint->setClearwrong(true);
$hints[]=$hint;
unset($hint);

// Asignamos las pistas a la pregunta
$preguntaCloze->setHints($hints);
$xml=$preguntaCloze->createCloze($xml);*/

// ---------------------------------------------------------
/*
 * Creamos pregunta orden
 */
/*$preguntaOrden = new PreguntaOrden($inicioXml->getRoot());

$preguntaOrden->setName("Nombre de pregunta de poner en orden");
$preguntaOrden->setQuestiontext("<![CDATA[<p>Enunciado de la pregunta poner en orden</p>]]>");
$preguntaOrden->setGeneralfeedback("<![CDATA[<p>Retroalimentación general</p>]]>");
$preguntaOrden->setDefaultgrade(1.0000000);
$preguntaOrden->setPenalty(0.3333333);
$preguntaOrden->setHidden(false);
$preguntaOrden->setLayouttype('VERTICAL');
$preguntaOrden->setSelecttype('ALL');
$preguntaOrden->setSelectcount('0');
$preguntaOrden->setGradingtype('ALL_OR_NOTHING');
$preguntaOrden->setShowgrading('SHOW');

$preguntaOrden->setTextCorrectfeedback('Esta genial');
$preguntaOrden->setTextPartiallycorrectfeedback('Esta parcialmente correcto');
$preguntaOrden->setTextIncorrectfeedback('Tienes que estudiar más.');


// Creamos las contestaciones posibles.
$answer= new Answer();
$answer->setAttriFraction("1.0000000");
$answer->setAttriFormat("html");
$answer->setText('<![CDATA[texto 1,&nbsp;<img src="@@PLUGINFILE@@/llaut.jpg" alt="" width="157" height="303" role="presentation" class="img-responsive atto_image_button_text-bottom">]]>');
$answer->setTextfeedback('');
$answers[]=$answer;
unset($answer);

$answer= new Answer();
$answer->setAttriFraction("2.0000000");
$answer->setAttriFormat("html");
$answer->setText('texto 2');
$answer->setTextfeedback('');
$answers[]=$answer;
unset($answer);

$answer= new Answer();
$answer->setAttriFraction("3.0000000");
$answer->setAttriFormat("moodle_auto_format");
$answer->setText('Texto 3');
$answer->setTextfeedback('');
$answers[]=$answer;
unset($answer);

$answer= new Answer();
$answer->setAttriFraction("4.0000000");
$answer->setAttriFormat("moodle_auto_format");
$answer->setText('Texto 4');
$answer->setTextfeedback('');
$answers[]=$answer;
unset($answer);


// Asignamos las respuesta a la pregunta
$preguntaOrden->setAnswers($answers);

// Creamos pistas
$hint= new Hint();
$hint->setText("<![CDATA[<p>Pista 1</p>]]>");
$hint->setShownumcorrect(true);
$hint->setClearwrong(true);
$hints[]=$hint;
unset($hint);

$hint= new Hint();
$hint->setText("<![CDATA[<p>Pista 2</p>]]>");
$hint->setShownumcorrect(false);
$hint->setClearwrong(true);
$hints[]=$hint;
unset($hint);
// Asignamos las pistas a la pregunta
$preguntaOrden->setHints($hints);

//creamos la pregunta
$xml=$preguntaOrden->createOrdering($xml);*/

//----------------------------------------------
/*
 * Creamos la pregunta de Arrastrar y soltar sobre imagen
 */
/*$preguntaDdimageortext = new Ddimageortext($inicioXml->getRoot());

$preguntaDdimageortext->setName("Nombre de pregunta de arrastrar y soltar sobre una imagen");
$preguntaDdimageortext->setQuestiontext("<![CDATA[<p>Enunciado de pregunta arrastrar y soltar sobre una imagen</p>]]>");
$preguntaDdimageortext->setGeneralfeedback("<![CDATA[<p>Retroalimentación general</p>]]>");
$preguntaDdimageortext->setDefaultgrade(1.0000000);
$preguntaDdimageortext->setPenalty(0.3333333);
$preguntaDdimageortext->setHidden(false);

$preguntaDdimageortext->setTextCorrectfeedback('Esta genial');
$preguntaDdimageortext->setTextPartiallycorrectfeedback('Esta parcialmente correcto');
$preguntaDdimageortext->setTextIncorrectfeedback('Tienes que estudiar más.');

$preguntaDdimageortext->setBackgroundImage("escaleras moodle.png");
$preguntaDdimageortext->setHeightBackgroundImage(300);
$preguntaDdimageortext->setWidthBackgroundImage(300);

// Creamos los objetos a mover
$drag= new Drag();
$drag->setNo(1);
$drag->setDraggroup(1);
$drag->setFile("actively facilitating forums.png");
$drag->setWidth(100);
$drag->setHeight(200);
$drags[]=$drag;
unset($drag);

$drag= new Drag();
$drag->setNo(2);
$drag->setText("Texto2");
$drag->setDraggroup(2);
$drags[]=$drag;
unset($drag);

// Asignamos las pistas a la pregunta
$preguntaDdimageortext->setDrags($drags);

// Ponemos donde deben ir los elementos que movemos
$drop= new Drop();
$drop->setText("Texto añadido");
$drop->setNo(1);
$drop->setChoice(1);
$drop->setXleft(190);
$drop->setYtop(143);
$drops[]=$drop;
unset($drop);

$drop= new Drop();
$drop->setText("");
$drop->setNo(2);
$drop->setChoice(2);
$drop->setXleft(179);
$drop->setYtop(195);
$drops[]=$drop;
unset($drop);

// Asignamos los drop a la pregunta
$preguntaDdimageortext->setDrops($drops);


// Creamos pistas
$hint= new Hint();
$hint->setText("<![CDATA[<p>Pista 1</p>]]>");
$hint->setShownumcorrect(true);
$hint->setClearwrong(true);
$hints[]=$hint;
unset($hint);

$hint= new Hint();
$hint->setText("<![CDATA[<p>Pista 2</p>]]>");
$hint->setShownumcorrect(false);
$hint->setClearwrong(true);
$hints[]=$hint;
unset($hint);
// Asignamos las pistas a la pregunta
$preguntaDdimageortext->setHints($hints);*/

//creamos la pregunta
//$xml=$preguntaDdimageortext->createDdimageortext($xml);

/* ----------------------------------------------------------------- */
/*
 * Probar pregunta de ensayo
 *
 *
 */
$preguntaEnsayo=new PreguntaEnsayo($inicioXml->getRoot());

// Rellenamos la pregunta con los datos
$preguntaEnsayo->setName("Pregunta de Ensayo");

$preguntaEnsayo->setQuestiontext("<![CDATA[Ordena els climes de la llista d'acord amb l'ordre dels números del mapa...<BR/><img src=\"@@PLUGINFILE@@/llaut.jpg\" alt=\"\" width=\"157\" height=\"303\" role=\"presentation\" class=\"img-responsive atto_image_button_middle\"><img src=\"climes002a.jpg\" alt=\"\" width=\"650\" height=\"471\" role=\"presentation\" class=\"img-responsive atto_image_button_text-bottom\"> otra <img src=\"violade.jpg\" alt=\"\" width=\"157\" height=\"340\" role=\"presentation\" class=\"img-responsive atto_image_button_text-bottom\">]]>");

$preguntaEnsayo->setGeneralfeedback("<![CDATA[<p>Retroalimentación de respuesta de ensayo</p>]]>");
$preguntaEnsayo->setDefaultgrade(1.0000000);
$preguntaEnsayo->setPenalty(1.0000000);
$preguntaEnsayo->setHidden(0);
$preguntaEnsayo->setResponseformat('editor');
$preguntaEnsayo->setResponserequired(1);
$preguntaEnsayo->setResponsefieldlines(15);
$preguntaEnsayo->setAttachments(0);
$preguntaEnsayo->setAttachementsrequired(0);
$preguntaEnsayo->setGradeinfo("<![CDATA[<p>Informacion para evaluadores</p>]]>");
$preguntaEnsayo->setResponsetemplate("");

$xml=$preguntaEnsayo->createEnsayo($xml);


//----------------------------------------------

// Genera el fichero xml

//$temp_file = tempnam(sys_get_temp_dir(), '.xml');
/*$temp_file=tempnam(sys_get_temp_dir(), 'XML_').'.xml';
//$xml_string=$xml->save($temp_file);
$xml_string = $xml->saveXML();
$xml_string = htmlspecialchars_decode ($xml_string);
$fp = fopen($temp_file, "w");
fputs($fp, $xml_string);
fclose($fp);*/


// Con esto fuerzo la descarga.
/*header("Content-Disposition: attachment; filename=\"" . $temp_file . "\";" );
header('Content-Type: text/xml');
readfile($temp_file);*/

// Victor quiere que se guarde sin preguntar nada
$carpeta = 'xmlDescargados';
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}

$temp_file = tempnam($carpeta,"TMP0").'.xml';
$xml_string = $xml->saveXML();
$xml_string = htmlspecialchars_decode ($xml_string);
$fp = fopen($temp_file, "w");
fputs($fp, $xml_string);
fclose($fp);
echo("Terminado");

