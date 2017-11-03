<?php
/**
 * Created by PhpStorm.
 * User: msuarez
 * Date: 30/10/17
 * Time: 12:03
 */

require_once ("Conexion.php");

class Category
{
    public function getCategory($folder){
       // Obtengo el idioma
        $languaje = substr($folder,strrpos($folder,'_')+1);

        // Obtengo la carpeta
        $fold = substr($folder,0,strrpos($folder,'_'));

        // Obtengo el identificador de la actividad
        $sql = "SELECT ID_ACTIVITAT FROM BIBLIO_VERSIO Where FOLDER like '".$fold."'";

        $conn = new Conexion();
        $query =$conn->executeSQL($sql);

        while ($row = oci_fetch_object($query, OCI_ASSOC+OCI_RETURN_NULLS)){
            foreach ($row as $item){
                $id_activitat=$item;
            }
        }


        // Obtengo el nivel de la actividad
        $sql = "SELECT CODI_DIC FROM NIVELL WHERE ID_NIVELL = (SELECT ID_NIVELL FROM BIBLIO_ACTIVITAT_NIVELL WHERE ID_ACTIVITAT=".$id_activitat." and ROWNUM<2)";

        $query = $conn->executeSQL($sql);
        while ($row = oci_fetch_object($query, OCI_ASSOC+OCI_RETURN_NULLS)){
            foreach ($row as $item){
                $nivel=$item;
            }
        }

        //Obtengo el Area de la actividad
        $sql = "SELECT CODI_DIC FROM AREA WHERE ID_AREA=(SELECT ID_AREA FROM BIBLIO_ACTIVITAT_AREA WHERE ID_ACTIVITAT=".$id_activitat." and ROWNUM<2)";
        $query = $conn->executeSQL($sql);
        while ($row = oci_fetch_object($query, OCI_ASSOC+OCI_RETURN_NULLS)){
            foreach ($row as $item){
                $area=$item;
            }
        }

        $category="/".$area."/".$nivel."/".$languaje."/".$fold;

        return ($category);

    }
}