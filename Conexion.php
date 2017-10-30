<?php
/**
 * Created by PhpStorm.
 * User: msuarez
 * Date: 30/10/17
 * Time: 11:54
 */

class Conexion
{
    public function openConection(){
        $db_test = "
   (DESCRIPTION= 
       (ADDRESS_LIST= 
         (ADDRESS=
         	(PROTOCOL=TCP)
         	(HOST=scan-racpro.cpd1.intranet.gencat.cat)
         	(PORT=1522)
         )
       )
       (CONNECT_DATA=(SERVICE_NAME=e13bd)
       )
     )
     ";
        $conn = oci_connect('QV', '20KW04', $db_test);
        if (!$conn){
            return null;
        }
        return $conn;
    }

    public function executeSQL($sql){

        $conn=$this->OpenConection();
        if (!is_null($conn)){
            $query = oci_parse($conn,$sql);
            oci_execute($query);
            return $query;
        }else{
            die ("No se conecta a la Base de datos");
        }
    }
}