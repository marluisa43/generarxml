<?php
require_once("PreguntaCorta.php");
require_once("Answer.php");
require_once("PreguntaSeleccion.php");

/*// Probar pregunta corta.
$preguntaCorta=new PreguntaCorta();
$answer= new Answer();

$preguntaCorta->setCategory("categoria sistema");
$xml=$preguntaCorta->getInicioXML();

$xml=$preguntaCorta->createHeadShortanswer($xml);

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

// Probar pregunta multichoice

$preguntaSeleccion=new PreguntaSeleccion();
$answer= new Answer();

$preguntaSeleccion->setCategory("categoria sistema");
$xml=$preguntaSeleccion->getInicioXML();

$xml=$preguntaSeleccion->createHeadMultiChoice($xml);

$preguntaSeleccion->setName("Respuesta corta");
$preguntaSeleccion->setQuestiontext("<![CDATA[<p>Enunciado de la respuesta multichoice</p>]]>");
$preguntaSeleccion->setGeneralfeedback("<![CDATA[<p>Retroalimentación General de respuesta multichoice</p>]]>");

// Rellenamos las contestaciones posibles.
$answer= new Answer();
$answer->setAttriFraction("100");
$answer->setAttriFormat("html");
$answer->setText("<![CDATA[<p>Primera Elección</p>]]>");
$answer->setTextfeedback(("<![CDATA[<p>retroalimentación de primera elección.</p>]]>"));
$answers[]=$answer;
unset($answer);

$answer= new Answer();
$answer->setAttriFraction("0");
$answer->setAttriFormat("html");
$answer->setText("<![CDATA[<p>Segunda Elección</p>]]>");
$answer->setTextfeedback(("<![CDATA[<p>Retroalimentacion de segunda elección.</p>]]>"));
$answers[]=$answer;
unset($answer);

$answer= new Answer();
$answer->setAttriFraction("0");
$answer->setAttriFormat("html");
$answer->setText("<![CDATA[<p>Elección 3</p>]]>");
$answer->setTextfeedback(("<![CDATA[<p>Retroalimentación de 3</p>]]>"));
$answers[]=$answer;
unset($answer);

$preguntaSeleccion->setAnswers($answers);

$answers=$preguntaSeleccion->getAnswers();

$xml=$preguntaSeleccion->createAnswer($xml);





//$temp_file = tempnam(sys_get_temp_dir(), '.xml');
$temp_file=tempnam(sys_get_temp_dir(),"xml");
$xml->save($temp_file);

// Con esto fuerzo la descarga.
header("Content-Disposition: attachment; filename=\"" . $temp_file . "\";" );
header('Content-Type: text/xml');
readfile($temp_file);
