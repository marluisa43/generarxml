<?php

require_once ("Conexion.php");
$sql = "SELECT ID_ACTIVITAT from BIBLIO_ACTIVITAT";

$conn = new Conexion();
$query =$conn->executeSQL($sql);

/*echo "<table border='1'>";
echo "<tr>";
echo "<th>Id</th><th>Titulo</th><th>Descripción</th><th>Archivo</th><th>Nivel</th><th>Area</th><th>Autor</th><th>Fecha</th>";
echo "</tr><tr>";*/

while ($row = oci_fetch_object($query, OCI_ASSOC+OCI_RETURN_NULLS)){
    echo "<hr>";

    $idCuaderno=$row->ID_ACTIVITAT;

    $sql = "select BIBLIO_ACTIVITAT.DATA_REVISIO, BIBLIO_VERSIO_IDIOMA.IDIOMA,BIBLIO_VERSIO.FOLDER 
            from BIBLIO_VERSIO_IDIOMA, BIBLIO_VERSIO, BIBLIO_ACTIVITAT
            where BIBLIO_VERSIO.ID_VERSIO=BIBLIO_VERSIO_IDIOMA.ID_VERSIO 
            and BIBLIO_VERSIO.ID_ACTIVITAT=BIBLIO_ACTIVITAT.ID_ACTIVITAT
            and BIBLIO_ACTIVITAT.ID_ACTIVITAT =".$idCuaderno;
    $query2=$conn->executeSQL($sql);
    $version = oci_fetch_object($query2, OCI_ASSOC+OCI_RETURN_NULLS);
    $idioma=$version->IDIOMA;
    $archivoXML=$version->FOLDER."_".$idioma;
    $fecha=$version->DATA_REVISIO;


    $sql = "SELECT TITOL,DESCRIPCIO from BIBLIO_ACTIVITAT_DESC WHERE ID_ACTIVITAT=".$idCuaderno." AND IDIOMA='".$idioma."'";
    $query3 =$conn->executeSQL($sql);

    $desc = oci_fetch_object($query3, OCI_ASSOC+OCI_RETURN_NULLS);

    $titulo=$desc->TITOL;
    $descrip=$desc->DESCRIPCIO;

     $sql = "SELECT CODI_DIC FROM NIVELL WHERE ID_NIVELL IN (SELECT ID_NIVELL FROM BIBLIO_ACTIVITAT_NIVELL WHERE ID_ACTIVITAT=".$idCuaderno.")";

    $query4 = $conn->executeSQL($sql);
    $txtNivel="";

   while ($niveles = oci_fetch_object($query4, OCI_ASSOC+OCI_RETURN_NULLS)){
         $txtNivel=$txtNivel.devolverNivel($niveles->CODI_DIC).", ";
    }
    $txtNivel=substr($txtNivel,0,-2);


    $txtArea="";
    $sql = "SELECT CODI_DIC FROM AREA WHERE ID_AREA IN (SELECT ID_AREA FROM BIBLIO_ACTIVITAT_AREA WHERE ID_ACTIVITAT=".$idCuaderno.")";
    $query5 = $conn->executeSQL($sql);
    while ($areas = oci_fetch_object($query5, OCI_ASSOC+OCI_RETURN_NULLS)){
        $txtArea=devolverArea($txtArea.$areas->CODI_DIC).", ";
    }
    $txtArea=substr($txtArea,0,-2);

    $sql = "select NOM_COMPLET from BIBLIO_AUTOR WHERE ID_AUTOR IN (SELECT ID_AUTOR from BIBLIO_AUTOR_ACT where ID_ACTIVITAT=".$idCuaderno.")";
    $query6 = $conn->executeSQL($sql);

    $txtAutor="";
    while ($autor = oci_fetch_object($query6, OCI_ASSOC+OCI_RETURN_NULLS)){
        $txtAutor=$txtAutor.$autor->NOM_COMPLET.", ";
    };
    $nombreAutor=substr($txtAutor,0,-2);





    echo $archivoXML."<br>";
    echo $titulo."<br><br><br>";
    echo "<pre>";
    echo $descrip."<br>";

    echo "<tab><br><i style='color:#6495ed'> Autor: </i>".$nombreAutor."</tab><br><br>";

    echo "<tab><i style='color:#6495ed'> Area</i>  ". $txtArea."</tab><br>";
    echo "<tab><i style='color:#6495ed'> Nivell</i>  ".$txtNivel."</tab><br>";
    $date = new DateTime($fecha);
    echo "<tab><i style='color:#6495ed'> Data</i>  ".$date->format('d/m/Y')."</tab><br></pre>";

}

function devolverArea($txtArea){
    switch ($txtArea){
        case "area_lleng":
            $textAreaLong="Lengües";
            break;
        case "area_mat":
            $textAreaLong="Matemàtiques";
            break;
        case "area_soci":
            $textAreaLong="Ciències socials";
            break;
        case "area_exp":
            $textAreaLong="Ciències experimentals";
            break;
        case "area_musica":
            $textAreaLong="Eduaciò musical";
            break;
        case "area_visual":
            $textAreaLong="Visual y plàstica";
            break;
        case "area_edfis":
            $textAreaLong="Educaciò fisica";
            break;
        case "area_tecn":
            $textAreaLong="Tecnologia";
            break;
        case "filo":
            $textAreaLong="Filosofia";
            break;
        case "area_div":
            $textAreaLong="Diversos";
            break;
    }
    return $textAreaLong;
}

function devolverNivel($txtNivel){
    switch($txtNivel){
        case "nivell_epre":
            $txtNivelLong="Educaciò preescolar";
            break;
        case "nivell_ei":
            $txtNivelLong="Educaciò infantil";
            break;
        case "nivell_ep":
            $txtNivelLong="Educación primària";
            break;
        case "nivell_eso":
            $txtNivelLong="ESO";
            break;
        case "nivell_ee":
            $txtNivelLong="Educaciò especial";
            break;
        case "nivell_cf":
            $txtNivelLong="Cicle formatiu";
            break;
        case "nivell_btx":
            $txtNivelLong="Batxillerat";
            break;
        case "nivell_ed":
            $txtNivelLong="Educaciò a distància";
            break;
        case "nivell_fa":
            $txtNivelLong="Formaciò d'adults";
            break;
        case "nivell_fp":
            $txtNivelLong="Formació permanent";
            break;
        case "nivell_alt":
            $txtNivelLong="Altres";
            break;

    }
    return $txtNivelLong;
}