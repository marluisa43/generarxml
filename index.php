<?php
require_once("BeginXml.php");
require_once("PreguntaCorta.php");
require_once("Answer.php");
require_once("PreguntaSeleccion.php");
require_once("PreguntaGapselect.php");
require_once("Selectoption.php");

// Inicializamos el fichero xml con la categoria a la que pertenece las preguntas que vamos a poner en el xml.

$inicioXml = new BeginXml();
$inicioXml->setCategory("prueba");

$xml=$inicioXml->getInicioXML();

// Probar pregunta corta.
/*$preguntaCorta=new PreguntaCorta($inicioXml->getRoot());
$answer= new Answer();

$xml=$preguntaCorta->createShortanswer($xml);

$preguntaCorta->setName("Respuesta corta");
$preguntaCorta->setQuestiontext("<![CDATA[<p>Enunciado de la respuesta corta</p>]]>");
$preguntaCorta->setType("shortanswer");
$preguntaCorta->setGeneralfeedback("<![CDATA[<p>Retroalimentación de respuesta corta</p>]]>");

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

$answers=$preguntaCorta->getAnswers();

$xml=$preguntaCorta->createAnswer($xml);*/
// Fin pregunta corta

/* ----------------------------------------------------------------- */
/*
 * Probar pregunta multichoice
 *
 *
 */


//creamos el contenedor de la pregunta de selección
$preguntaSeleccion=new PreguntaSeleccion($inicioXml->getRoot());

// Rellenamos con los datos de la pregunta.
$preguntaSeleccion->setName("Pregunta multichoice");
$preguntaSeleccion->setQuestiontext(html_entity_decode(htmlentities('<![CDATA[<p>Enunciado de la respuesta multichoice</p>]]>')));
$preguntaSeleccion->setGeneralfeedback('<![CDATA[<p>Retroalimentación General de respuesta multichoice</p>]]>');

$preguntaSeleccion->setSingle(false);
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
$answer->setText('<![CDATA[<p>Segunda Elección</p>]]>');
$answer->setTextfeedback('<![CDATA[<p>Retroalimentacion de segunda elección.</p>]]>');
$answers[]=$answer;
unset($answer);

$answer= new Answer();
$answer->setAttriFraction("0");
$answer->setAttriFormat("html");
$answer->setText('<![CDATA[<p>Elección 3</p>]]>');
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
$xml=$preguntaSeleccion->createMultiChoice($xml);


/* ------------------------------------------ */
// Probar pregunta espacios en blanco.
/*$preguntaGapSelect=new PreguntaGapselect($inicioXml->getRoot());
$selectoption= new Selectoption();

// Rellenamos con los datos de la pregunta.
$preguntaGapSelect->setName("Pregunta de selección de palabras perdidas");
$preguntaGapSelect->setQuestiontext(html_entity_decode(htmlentities('<![CDATA[<p>Enunciado de rellenar espacios en blanco [[1]]</p><p>Enunciado de rellenar [[4]]</p>]]>')));
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
$xml=$preguntaGapSelect->createGapselect($xml);
*/

//$temp_file = tempnam(sys_get_temp_dir(), '.xml');
$temp_file=tempnam(sys_get_temp_dir(), 'XML_').'.xml';
//$xml_string=$xml->save($temp_file);
$xml_string = $xml->saveXML();
$xml_string = htmlspecialchars_decode ($xml_string);
$fp = fopen($temp_file, "w");
fputs($fp, $xml_string);
fclose($fp);


// Con esto fuerzo la descarga.
header("Content-Disposition: attachment; filename=\"" . $temp_file . "\";" );
header('Content-Type: text/xml');
readfile($temp_file);
