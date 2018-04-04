<?php
include_once '../config/Bd.php';
include_once './Seguimiento_auditor_estudiante.php';

 /**
  * Seguimiento_auditor_estudiante Data Access Object (DAO).
  * This class contains all database handling that is needed to 
  * permanently store and retrieve Seguimiento_auditor_estudiante object instances. 
  */

 /**
  * This sourcecode has been generated by FREE DaoGen generator version 2.4.1.
  * The usage of generated code is restricted to OpenSource software projects
  * only. DaoGen is available in http://titaniclinux.net/daogen/
  * It has been programmed by Tuomo Lukka, Tuomo.Lukka@iki.fi
  *
  * DaoGen license: The following DaoGen generated source code is licensed
  * under the terms of GNU GPL license. The full text for license is available
  * in GNU project's pages: http://www.gnu.org/copyleft/gpl.html
  *
  * If you wish to use the DaoGen generator to produce code for closed-source
  * commercial applications, you must pay the lisence fee. The price is
  * 5 USD or 5 Eur for each database table, you are generating code for.
  * (That includes unlimited amount of iterations with all supported languages
  * for each database table you are paying for.) Send mail to
  * "Tuomo.Lukka@iki.fi" for more information. Thank you!
  */



class Seguimiento_auditor_estudianteDao extends Bd{


    /**
     * createValueObject-method. This method is used when the Dao class needs
     * to create new value object instance. The reason why this method exists
     * is that sometimes the programmer may want to extend also the valueObject
     * and then this method can be overrided to return extended valueObject.
     * NOTE: If you extend the valueObject class, make sure to override the
     * clone() method in it!
     */
    function createValueObject() {
          return new Seguimiento_auditor_estudiante();
    }


    /**
     * getObject-method. This will create and load valueObject contents from database 
     * using given Primary-Key as identifier. This method is just a convenience method 
     * for the real load-method which accepts the valueObject as a parameter. Returned
     * valueObject will be created using the createValueObject() method.
     */
    function getObject($seguimiento_aduditor_estudiante_id) {
          $valueObject = $this->createValueObject();
          $valueObject->setSeguimiento_aduditor_estudiante_id($seguimiento_aduditor_estudiante_id);
          $this->load($valueObject);
          return $valueObject;
    }


    /**
     * load-method. This will load valueObject contents from database using
     * Primary-Key as identifier. Upper layer should use this so that valueObject
     * instance is created and only primary-key should be specified. Then call
     * this method to complete other persistent information. This method will
     * overwrite all other fields except primary-key and possible runtime variables.
     * If load can not find matching row, NotFoundException will be thrown.
     *
     * @param conn         This method requires working database connection.
     * @param valueObject  This parameter contains the class instance to be loaded.
     *                     Primary-key field must be set for this to work properly.
     */
    function load(&$valueObject) {

          if (!$valueObject->getSeguimiento_aduditor_estudiante_id()) {
               //print "Can not select without Primary-Key!";
               return false;
          }

          $sql = "SELECT * FROM seguimiento_auditor_estudiante WHERE (seguimiento_aduditor_estudiante_id = ".$valueObject->getSeguimiento_aduditor_estudiante_id().") "; 

          if ($this->singleQuery($sql, $valueObject))
               return true;
          else
               return false;
    }


    /**
     * LoadAll-method. This will read all contents from database table and
     * build an Vector containing valueObjects. Please note, that this method
     * will consume huge amounts of resources if table has lot's of rows. 
     * This should only be used when target tables have only small amounts
     * of data.
     *
     * @param conn         This method requires working database connection.
     */
    function loadAll(&$conn) {


          $sql = "SELECT * FROM seguimiento_auditor_estudiante ORDER BY seguimiento_aduditor_estudiante_id ASC ";

          $searchResults = $this->listQuery($sql);

          return $searchResults;
    }



    /**
     * create-method. This will create new row in database according to supplied
     * valueObject contents. Make sure that values for all NOT NULL columns are
     * correctly specified. Also, if this table does not use automatic surrogate-keys
     * the primary-key must be specified. After INSERT command this method will 
     * read the generated primary-key back to valueObject if automatic surrogate-keys
     * were used. 
     *
     * @param conn         This method requires working database connection.
     * @param valueObject  This parameter contains the class instance to be created.
     *                     If automatic surrogate-keys are not used the Primary-key 
     *                     field must be set for this to work properly.
     */
    function create(&$conn, &$valueObject) {

          $sql = "INSERT INTO seguimiento_auditor_estudiante ( seguimiento_aduditor_estudiante_id, auditor_estudiante_id, fecha_seguimiento, ";
          $sql = $sql."web_conference_est, chat_est, ";
          $sql = $sql."mensajeria_interna_est, foro_est, evaluacion_seg_instancia, ";
          $sql = $sql."observacion, fecha_edicion, pqr_estudiante, ";
          $sql = $sql."horas_acompanamiento, web_conference_tutor, chat_tutor, ";
          $sql = $sql."mensajeria_interna_tutor, foro_tutor, evaluacion_seg_inst_tutor, ";
          $sql = $sql."recibe_pqr_tutor, observacion_accion_tutor, respuesta_tutor, ";
          $sql = $sql."observacion_rpta_tutor, observacion_general, estudiante_materia_id, ";
          $sql = $sql."seguimiento_id) VALUES (".$valueObject->getSeguimiento_aduditor_estudiante_id().", ";
          $sql = $sql."".$valueObject->getAuditor_estudiante_id().", ";
          $sql = $sql."'".$valueObject->getFecha_seguimiento()."', ";
          $sql = $sql."".$valueObject->getWeb_conference_est().", ";
          $sql = $sql."".$valueObject->getChat_est().", ";
          $sql = $sql."".$valueObject->getMensajeria_interna_est().", ";
          $sql = $sql."".$valueObject->getForo_est().", ";
          $sql = $sql."'".$valueObject->getEvaluacion_seg_instancia()."', ";
          $sql = $sql."'".$valueObject->getObservacion()."', ";
          $sql = $sql."'".$valueObject->getFecha_edicion()."', ";
          $sql = $sql."'".$valueObject->getPqr_estudiante()."', ";
          $sql = $sql."".$valueObject->getHoras_acompanamiento().", ";
          $sql = $sql."".$valueObject->getWeb_conference_tutor().", ";
          $sql = $sql."".$valueObject->getChat_tutor().", ";
          $sql = $sql."".$valueObject->getMensajeria_interna_tutor().", ";
          $sql = $sql."".$valueObject->getForo_tutor().", ";
          $sql = $sql."'".$valueObject->getEvaluacion_seg_inst_tutor()."', ";
          $sql = $sql."".$valueObject->getRecibe_pqr_tutor().", ";
          $sql = $sql."'".$valueObject->getObservacion_accion_tutor()."', ";
          $sql = $sql."'".$valueObject->getRespuesta_tutor()."', ";
          $sql = $sql."'".$valueObject->getObservacion_rpta_tutor()."', ";
          $sql = $sql."'".$valueObject->getObservacion_general()."', ";
          $sql = $sql."".$valueObject->getEstudiante_materia_id().", ";
          $sql = $sql."".$valueObject->getSeguimiento_id().") ";
          $result = $this->databaseUpdate($sql);


          return true;
    }


    /**
     * save-method. This method will save the current state of valueObject to database.
     * Save can not be used to create new instances in database, so upper layer must
     * make sure that the primary-key is correctly specified. Primary-key will indicate
     * which instance is going to be updated in database. If save can not find matching 
     * row, NotFoundException will be thrown.
     *
     * @param conn         This method requires working database connection.
     * @param valueObject  This parameter contains the class instance to be saved.
     *                     Primary-key field must be set for this to work properly.
     */
    function save(&$valueObject) {

          $sql = "UPDATE seguimiento_auditor_estudiante SET auditor_estudiante_id = ".$valueObject->getAuditor_estudiante_id().", ";
          $sql = $sql."fecha_seguimiento = '".$valueObject->getFecha_seguimiento()."', ";
          $sql = $sql."web_conference_est = ".$valueObject->getWeb_conference_est().", ";
          $sql = $sql."chat_est = ".$valueObject->getChat_est().", ";
          $sql = $sql."mensajeria_interna_est = ".$valueObject->getMensajeria_interna_est().", ";
          $sql = $sql."foro_est = ".$valueObject->getForo_est().", ";
          $sql = $sql."evaluacion_seg_instancia = '".$valueObject->getEvaluacion_seg_instancia()."', ";
          $sql = $sql."observacion = '".$valueObject->getObservacion()."', ";
          $sql = $sql."fecha_edicion = '".$valueObject->getFecha_edicion()."', ";
          $sql = $sql."pqr_estudiante = '".$valueObject->getPqr_estudiante()."', ";
          $sql = $sql."horas_acompanamiento = ".$valueObject->getHoras_acompanamiento().", ";
          $sql = $sql."web_conference_tutor = ".$valueObject->getWeb_conference_tutor().", ";
          $sql = $sql."chat_tutor = ".$valueObject->getChat_tutor().", ";
          $sql = $sql."mensajeria_interna_tutor = ".$valueObject->getMensajeria_interna_tutor().", ";
          $sql = $sql."foro_tutor = ".$valueObject->getForo_tutor().", ";
          $sql = $sql."evaluacion_seg_inst_tutor = '".$valueObject->getEvaluacion_seg_inst_tutor()."', ";
          $sql = $sql."recibe_pqr_tutor = ".$valueObject->getRecibe_pqr_tutor().", ";
          $sql = $sql."observacion_accion_tutor = '".$valueObject->getObservacion_accion_tutor()."', ";
          $sql = $sql."respuesta_tutor = '".$valueObject->getRespuesta_tutor()."', ";
          $sql = $sql."observacion_rpta_tutor = '".$valueObject->getObservacion_rpta_tutor()."', ";
          $sql = $sql."observacion_general = '".$valueObject->getObservacion_general()."', ";
          $sql = $sql."estudiante_materia_id = ".$valueObject->getEstudiante_materia_id().", ";
          $sql = $sql."seguimiento_id = ".$valueObject->getSeguimiento_id()."";
          $sql = $sql." WHERE (seguimiento_aduditor_estudiante_id = ".$valueObject->getSeguimiento_aduditor_estudiante_id().") ";
          $result = $this->databaseUpdate($sql);

          if ($result != 1) {
               //print "PrimaryKey Error when updating DB!";
               return false;
          }

          return true;
    }


    /**
     * delete-method. This method will remove the information from database as identified by
     * by primary-key in supplied valueObject. Once valueObject has been deleted it can not 
     * be restored by calling save. Restoring can only be done using create method but if 
     * database is using automatic surrogate-keys, the resulting object will have different 
     * primary-key than what it was in the deleted object. If delete can not find matching row,
     * NotFoundException will be thrown.
     *
     * @param conn         This method requires working database connection.
     * @param valueObject  This parameter contains the class instance to be deleted.
     *                     Primary-key field must be set for this to work properly.
     */
    function delete(&$valueObject) {


          if (!$valueObject->getSeguimiento_aduditor_estudiante_id()) {
               //print "Can not delete without Primary-Key!";
               return false;
          }

          $sql = "DELETE FROM seguimiento_auditor_estudiante WHERE (seguimiento_aduditor_estudiante_id = ".$valueObject->getSeguimiento_aduditor_estudiante_id().") ";
          $result = $this->databaseUpdate($sql);

          if ($result != 1) {
               //print "PrimaryKey Error when updating DB!";
               return false;
          }
          return true;
    }


    /**
     * deleteAll-method. This method will remove all information from the table that matches
     * this Dao and ValueObject couple. This should be the most efficient way to clear table.
     * Once deleteAll has been called, no valueObject that has been created before can be 
     * restored by calling save. Restoring can only be done using create method but if database 
     * is using automatic surrogate-keys, the resulting object will have different primary-key 
     * than what it was in the deleted object. (Note, the implementation of this method should
     * be different with different DB backends.)
     *
     * @param conn         This method requires working database connection.
     */
    function deleteAll() {

          $sql = "DELETE FROM seguimiento_auditor_estudiante";
          $result = $this->databaseUpdate($sql);

          return true;
    }


    /**
     * coutAll-method. This method will return the number of all rows from table that matches
     * this Dao. The implementation will simply execute "select count(primarykey) from table".
     * If table is empty, the return value is 0. This method should be used before calling
     * loadAll, to make sure table has not too many rows.
     *
     * @param conn         This method requires working database connection.
     */
    function countAll() {

          $sql = "SELECT count(*) FROM seguimiento_auditor_estudiante";
          $allRows = 0;

          $result = mysql_query($sql);

          if ($row = mysql_fetch_array($result))
                $allRows = $row[0];

          return $allRows;
    }


    /** 
     * searchMatching-Method. This method provides searching capability to 
     * get matching valueObjects from database. It works by searching all 
     * objects that match permanent instance variables of given object.
     * Upper layer should use this by setting some parameters in valueObject
     * and then  call searchMatching. The result will be 0-N objects in vector, 
     * all matching those criteria you specified. Those instance-variables that
     * have NULL values are excluded in search-criteria.
     *
     * @param conn         This method requires working database connection.
     * @param valueObject  This parameter contains the class instance where search will be based.
     *                     Primary-key field should not be set.
     */
    function searchMatching(&$valueObject) {

          $first = true;
          $sql = "SELECT * FROM seguimiento_auditor_estudiante WHERE 1=1 ";

          if ($valueObject->getSeguimiento_aduditor_estudiante_id() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND seguimiento_aduditor_estudiante_id = ".$valueObject->getSeguimiento_aduditor_estudiante_id()." ";
          }

          if ($valueObject->getAuditor_estudiante_id() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND auditor_estudiante_id = ".$valueObject->getAuditor_estudiante_id()." ";
          }

          if ($valueObject->getFecha_seguimiento() != "") {
              if ($first) { $first = false; }
              $sql = $sql."AND fecha_seguimiento = '".$valueObject->getFecha_seguimiento()."' ";
          }
          
          if ($valueObject->getWeb_conference_est() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND web_conference_est = ".$valueObject->getWeb_conference_est()." ";
          }

          if ($valueObject->getChat_est() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND chat_est = ".$valueObject->getChat_est()." ";
          }

          if ($valueObject->getMensajeria_interna_est() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND mensajeria_interna_est = ".$valueObject->getMensajeria_interna_est()." ";
          }

          if ($valueObject->getForo_est() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND foro_est = ".$valueObject->getForo_est()." ";
          }

          if ($valueObject->getEvaluacion_seg_instancia() != "") {
              if ($first) { $first = false; }
              $sql = $sql."AND evaluacion_seg_instancia LIKE '".$valueObject->getEvaluacion_seg_instancia()."%' ";
          }

          if ($valueObject->getObservacion() != "") {
              if ($first) { $first = false; }
              $sql = $sql."AND observacion LIKE '".$valueObject->getObservacion()."%' ";
          }

          if ($valueObject->getFecha_edicion() != "") {
              if ($first) { $first = false; }
              $sql = $sql."AND fecha_edicion = '".$valueObject->getFecha_edicion()."' ";
          }

          if ($valueObject->getPqr_estudiante() != "") {
              if ($first) { $first = false; }
              $sql = $sql."AND pqr_estudiante LIKE '".$valueObject->getPqr_estudiante()."%' ";
          }

          if ($valueObject->getHoras_acompanamiento() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND horas_acompanamiento = ".$valueObject->getHoras_acompanamiento()." ";
          }

          if ($valueObject->getWeb_conference_tutor() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND web_conference_tutor = ".$valueObject->getWeb_conference_tutor()." ";
          }

          if ($valueObject->getChat_tutor() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND chat_tutor = ".$valueObject->getChat_tutor()." ";
          }

          if ($valueObject->getMensajeria_interna_tutor() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND mensajeria_interna_tutor = ".$valueObject->getMensajeria_interna_tutor()." ";
          }

          if ($valueObject->getForo_tutor() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND foro_tutor = ".$valueObject->getForo_tutor()." ";
          }

          if ($valueObject->getEvaluacion_seg_inst_tutor() != "") {
              if ($first) { $first = false; }
              $sql = $sql."AND evaluacion_seg_inst_tutor LIKE '".$valueObject->getEvaluacion_seg_inst_tutor()."%' ";
          }

          if ($valueObject->getRecibe_pqr_tutor() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND recibe_pqr_tutor = ".$valueObject->getRecibe_pqr_tutor()." ";
          }

          if ($valueObject->getObservacion_accion_tutor() != "") {
              if ($first) { $first = false; }
              $sql = $sql."AND observacion_accion_tutor LIKE '".$valueObject->getObservacion_accion_tutor()."%' ";
          }

          if ($valueObject->getRespuesta_tutor() != "") {
              if ($first) { $first = false; }
              $sql = $sql."AND respuesta_tutor LIKE '".$valueObject->getRespuesta_tutor()."%' ";
          }

          if ($valueObject->getObservacion_rpta_tutor() != "") {
              if ($first) { $first = false; }
              $sql = $sql."AND observacion_rpta_tutor LIKE '".$valueObject->getObservacion_rpta_tutor()."%' ";
          }

          if ($valueObject->getObservacion_general() != "") {
              if ($first) { $first = false; }
              $sql = $sql."AND observacion_general LIKE '".$valueObject->getObservacion_general()."%' ";
          }

          if ($valueObject->getEstudiante_materia_id() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND estudiante_materia_id = ".$valueObject->getEstudiante_materia_id()." ";
          }

          if ($valueObject->getSeguimiento_id() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND seguimiento_id = ".$valueObject->getSeguimiento_id()." ";
          }


          $sql = $sql."ORDER BY seguimiento_aduditor_estudiante_id ASC ";

          // Prevent accidential full table results.
          // Use loadAll if all rows must be returned.
          if ($first)
               return array();

          $searchResults = $this->listQuery($sql);

          return $searchResults;
    }


    /** 
     * getDaogenVersion will return information about
     * generator which created these sources.
     */
    function getDaogenVersion() {
        return "DaoGen version 2.4.1";
    }


    /**
     * databaseUpdate-method. This method is a helper method for internal use. It will execute
     * all database handling that will change the information in tables. SELECT queries will
     * not be executed here however. The return value indicates how many rows were affected.
     * This method will also make sure that if cache is used, it will reset when data changes.
     *
     * @param conn         This method requires working database connection.
     * @param stmt         This parameter contains the SQL statement to be excuted.
     */
    function databaseUpdate(&$sql) {

          $result = mysql_query($sql);

          return $result;
    }



    /**
     * databaseQuery-method. This method is a helper method for internal use. It will execute
     * all database queries that will return only one row. The resultset will be converted
     * to valueObject. If no rows were found, NotFoundException will be thrown.
     *
     * @param conn         This method requires working database connection.
     * @param stmt         This parameter contains the SQL statement to be excuted.
     * @param valueObject  Class-instance where resulting data will be stored.
     */
    function singleQuery(&$sql, &$valueObject) {

          $result = mysql_query($sql);

          if ($row = mysql_fetch_array($result)) {

                   $valueObject->setSeguimiento_aduditor_estudiante_id($row[0]); 
                   $valueObject->setAuditor_estudiante_id($row[1]); 
                   $valueObject->setFecha_seguimiento($row[2]); 
                   $valueObject->setWeb_conference_est($row[3]); 
                   $valueObject->setChat_est($row[4]); 
                   $valueObject->setMensajeria_interna_est($row[5]); 
                   $valueObject->setForo_est($row[6]); 
                   $valueObject->setEvaluacion_seg_instancia($row[7]); 
                   $valueObject->setObservacion($row[8]); 
                   $valueObject->setFecha_edicion($row[9]); 
                   $valueObject->setPqr_estudiante($row[10]); 
                   $valueObject->setHoras_acompanamiento($row[11]); 
                   $valueObject->setWeb_conference_tutor($row[12]); 
                   $valueObject->setChat_tutor($row[13]); 
                   $valueObject->setMensajeria_interna_tutor($row[14]); 
                   $valueObject->setForo_tutor($row[15]); 
                   $valueObject->setEvaluacion_seg_inst_tutor($row[16]); 
                   $valueObject->setRecibe_pqr_tutor($row[17]); 
                   $valueObject->setObservacion_accion_tutor($row[18]); 
                   $valueObject->setRespuesta_tutor($row[19]); 
                   $valueObject->setObservacion_rpta_tutor($row[20]); 
                   $valueObject->setObservacion_general($row[21]); 
                   $valueObject->setEstudiante_materia_id($row[22]); 
                   $valueObject->setSeguimiento_id($row[23]); 
          } else {
               //print " Object Not Found!";
               return false;
          }
          return true;
    }


    /**
     * databaseQuery-method. This method is a helper method for internal use. It will execute
     * all database queries that will return multiple rows. The resultset will be converted
     * to the List of valueObjects. If no rows were found, an empty List will be returned.
     *
     * @param conn         This method requires working database connection.
     * @param stmt         This parameter contains the SQL statement to be excuted.
     */
    function listQuery(&$sql) {

          $searchResults = array();
          $result = mysql_query($sql);

          while ($row = mysql_fetch_array($result)) {
               $temp = $this->createValueObject();

               $temp->setSeguimiento_aduditor_estudiante_id($row[0]); 
               $temp->setAuditor_estudiante_id($row[1]); 
               $temp->setFecha_seguimiento($row[2]); 
               $temp->setWeb_conference_est($row[3]); 
               $temp->setChat_est($row[4]); 
               $temp->setMensajeria_interna_est($row[5]); 
               $temp->setForo_est($row[6]); 
               $temp->setEvaluacion_seg_instancia($row[7]); 
               $temp->setObservacion($row[8]); 
               $temp->setFecha_edicion($row[9]); 
               $temp->setPqr_estudiante($row[10]); 
               $temp->setHoras_acompanamiento($row[11]); 
               $temp->setWeb_conference_tutor($row[12]); 
               $temp->setChat_tutor($row[13]); 
               $temp->setMensajeria_interna_tutor($row[14]); 
               $temp->setForo_tutor($row[15]); 
               $temp->setEvaluacion_seg_inst_tutor($row[16]); 
               $temp->setRecibe_pqr_tutor($row[17]); 
               $temp->setObservacion_accion_tutor($row[18]); 
               $temp->setRespuesta_tutor($row[19]); 
               $temp->setObservacion_rpta_tutor($row[20]); 
               $temp->setObservacion_general($row[21]); 
               $temp->setEstudiante_materia_id($row[22]); 
               $temp->setSeguimiento_id($row[23]); 
               array_push($searchResults, $temp);
          }

          return $searchResults;
    }
}

?>