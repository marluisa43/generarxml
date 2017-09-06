<?php
require_once("PreguntaCorta.php");

$preguntaCorta=new PreguntaCorta();

$preguntaCorta->setCategory("categoria sistema");
$xml=$preguntaCorta->getInicioXML();

$respuesta1[]=['bien','regular','mal'];
$respuesta2[]=['blanco','amarillo','azul'];
$pregunta1=['texto pregunta corta1','enunciado pregunta corta1',$respuesta1];
$pregunta2=['texto pregunta corta2','enunciado pregunta corta2',$respuesta2];
$preguntas[]=$pregunta1;
$preguntas[]=$pregunta2;


foreach ($preguntas as $pregunta){
    $preguntaCorta->setName($pregunta[0]);
    $preguntaCorta->setQuestiontext($pregunta[1]);
    $xml=$preguntaCorta->createHeadShortanswer($xml);
    foreach($pregunta[2] as $respuesta){
        $preguntaCorta->setAnswertext($respuesta);
        $xml=$preguntaCorta->createAnswer($xml);
    }
}






//$temp_file = tempnam(sys_get_temp_dir(), '.xml');
$temp_file=tempnam(sys_get_temp_dir(),"xml");
$xml->save($temp_file);

// Con esto fuerzo la descarga.
header("Content-Disposition: attachment; filename=\"" . $temp_file . "\";" );
header('Content-Type: text/xml');
readfile($temp_file);
