<?php

require_once ("Conexion.php");
$sql = "SELECT ID_ACTIVITAT from BIBLIO_ACTIVITAT";

$conn = new Conexion();
$query =$conn->executeSQL($sql);

echo "<table>";
echo "<tr>";
echo "<th>Id</th><th>Titulo</th><th>Descripción</th><th>Archivo</th><th>Nivel</th><th>Area</th><th>Autor</th><th>Fecha</th>";
echo "</tr><tr>";

while ($row = oci_fetch_object($query, OCI_ASSOC+OCI_RETURN_NULLS)){
    $idCuaderno=$row;
    echo "<td>".$idCuaderno."</td>";

    $sql = "select BIBLIO_VERSIO.DATA_CREACIO BIBLIO_VERSIO_IDIOMA.IDIOMA,BIBLIO_VERSIO.FOLDER 
            from BIBLIO_VERSIO_IDIOMA, BIBLIO_VERSIO
            where BIBLIO_VERSIO.ID_VERSIO=BIBLIO_VERSIO_IDIOMA.ID_VERSIO 
            and BIBLIO_VERSIO.ID_ACTIVITAT=".$idCuaderno;
    $query2 =$conn->executeSQL($sql);
    $version = oci_fetch_object($query2, OCI_ASSOC+OCI_RETURN_NULLS);
    $idioma=$version["IDIOMA"];
    $archivoXML=$version["FOLDER"]."_".$idioma;
    $fecha=$version["DATA_CREACIO"];

    $sql = "SELECT TITOL,DESCRIPCIO from BIBLIO_ACTIVITAT_DESC WHERE ID_ACTIVITAT=".$idCuaderno." AND IDIOMA=".$idioma;
    $query3 =$conn->executeSQL($sql);
    $desc = oci_fetch_object($query3, OCI_ASSOC+OCI_RETURN_NULLS);
    echo "<td>".$desc["TITOL"]."</td><td>".$desc["DESCRIPCIO"]."</td><td>".$archivoXML."</td>";

    $sql = "SELECT CODI_DIC FROM NIVELL WHERE ID_NIVELL = (SELECT ID_NIVELL FROM BIBLIO_ACTIVITAT_NIVELL WHERE ID_ACTIVITAT=".$idCuaderno.")";

    $query4 = $conn->executeSQL($sql);
    $txtNivel="";
    while ($niveles = oci_fetch_object($query4, OCI_ASSOC+OCI_RETURN_NULLS)){
        $txtNivel=$txtNivel.$niveles["CODI_DIC"]." - ";
    }
    echo "<td>".$txtNivel."</td>";

    $txtArea="";
    $sql = "SELECT CODI_DIC FROM AREA WHERE ID_AREA=(SELECT ID_AREA FROM BIBLIO_ACTIVITAT_AREA WHERE ID_ACTIVITAT=".$idCuaderno.")";
    $query5 = $conn->executeSQL($sql);
    while ($areas = oci_fetch_object($query5, OCI_ASSOC+OCI_RETURN_NULLS)){
        $txtArea=$txtArea.$areas["CODI_DIC"]." - ";
    }
    echo "<td>".$txtArea."</td>";

    $sql = "select NOM_COMPLET from BIBLIO_AUTOR WHERE ID_AUTOR=(SELECT ID_AUTOR from BIBLIO_AUTOR_ACT where ID_ACTIVITAT=".$idCuaderno.")";
    $query6 = $conn->executeSQL($sql);
    $autor = oci_fetch_object($query6, OCI_ASSOC+OCI_RETURN_NULLS);
    echo "<td>".$autor["NOM_COMPLET"]."</td>";

    echo "<td>".$fecha."</td>";
    echo "</tr>";
}
echo "</table>";