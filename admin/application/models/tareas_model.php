<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 25/06/2015
 * Time: 02:36 PM
 */
class Tareas_model extends  CI_Model{

    public function insertar($tarea){
        if($this->db->insert('tasks',$tarea))                  //'tareas' es el nombre de la tabla y $tarea el arreglo a insertar.
            return true;
        else
            return false;
    }

    public  function  leer(){
        $primerSabado = date("'Y-m-d H:i:s'", strtotime("last Sunday"));
        $segundoSabado = date("'Y-m-d H:i:s'", strtotime("next Saturday"));
       // $this->db->order_by('id DESC');                  //atributo y tipo de orden
        $sql = "SELECT * from tasks  where ((finished = 0 AND recurring = 0) OR  deadline BETWEEN ".$primerSabado." AND ".$segundoSabado.") AND deleted_at IS NULL order by finished,deadline, task_id ASC";
        $query = $this->db->query($sql);
        return $query->result();                    //viene de C.I.
    }

    public  function  leerTodo(){
        // $this->db->order_by('id DESC');                  //atributo y tipo de orden
        $sql = "SELECT * from tasks where deleted_at IS NULL";
        $query = $this->db->query($sql);
        return $query->result();                    //viene de C.I.
    }

    public  function  leerRecurrentes(){
        $primerSabado = date("Y-m-d H:i:s", strtotime("last Sunday"));
        $segundoSabado = "'".$primerSabado."'";


        $pDate = strtotime($primerSabado.' - 1 week');
        $primerSabado = date("'Y-m-d H:i:s'",$pDate);


        // $this->db->order_by('id DESC');                  //atributo y tipo de orden
        $sql = "SELECT DISTINCT title, description, user_id from tasks  where recurring = 1 AND  deadline < ".$segundoSabado." AND deleted_at IS NULL order by finished,deadline, task_id ASC";
        $query = $this->db->query($sql);
        return $query->result();                    //viene de C.I.
    }

    public function deleteDupes (){

        $sql = "SELECT * FROM tasks where deleted_at IS NULL";
        $query = $this->db->query($sql);
        $allTareas = $query->result();

        $sql = "Select * from tasks where deleted_at IS NULL group by title, description, user_id, deadline having count(*) > 1 ";
        $query = $this->db->query($sql);
        $dupes = $query->result();

        foreach ($dupes as $dupe) {
            $keepOne = 0;

            foreach($allTareas as $tarea){
                if($dupe->title == $tarea->title AND $dupe->description == $tarea->description AND $dupe->user_id == $tarea->user_id AND $dupe->deadline == $tarea->deadline){
                    if($keepOne){
                        $this->db->delete('tasks', array('task_id' => $tarea->task_id));
                    }
                    else{
                        $keepOne = 1;
                    }
                }
            }

        }

    }


    public function generarReporte(){
        $primerSabado = date("'Y-m-d H:i:s'", strtotime("last Sunday"));
        $segundoSabado = date("'Y-m-d H:i:s'", strtotime("next Saturday"));

        $sql = "SELECT DISTINCT username FROM users join tasks on users.user_id = tasks.user_id where (tasks.finished = 0 OR tasks.deadline BETWEEN ".$primerSabado." AND ".$segundoSabado.") AND tasks.deleted_at IS NULL AND users.deleted_at IS NULL

 ";
        $query0 = $this->db->query($sql);           //Genera Tabla con los usernames que tienen minimo una tarea por hacer
        $query0 = $query0->result();


        $sql = "SELECT username, count(*) as quantity FROM users join tasks on users.user_id = tasks.user_id where tasks.deadline BETWEEN ".$primerSabado." AND ".$segundoSabado." AND tasks.deleted_at IS NULL AND users.deleted_at IS NULL
 GROUP BY username";
        $query1 = $this->db->query($sql);           //Genera Tabla con username y cuenta de tareas asignadas
        $query1 = $query1->result();

        $sql = "SELECT username, count(*) as quantity FROM users join tasks on users.user_id = tasks.user_id where tasks.deadline < ".$primerSabado." AND tasks.finished = 0 AND tasks.recurring = 0 AND tasks.deleted_at IS NULL AND users.deleted_at IS NULL
 GROUP BY username ";
        $query2 = $this->db->query($sql);           //Genera Tabla con username y cuenta de tareas arrastradas de semanas pasadas
        $query2 = $query2->result();

        $sql = "SELECT username, count(*) as quantity FROM users join tasks on users.user_id = tasks.user_id where tasks.finished = 1 AND tasks.deadline BETWEEN ".$primerSabado." AND ".$segundoSabado." AND tasks.deleted_at IS NULL AND users.deleted_at IS NULL
 GROUP BY username";
        $query3 = $this->db->query($sql);           //Genera Tabla con username y cuenta de tareas completas de esta semana
        $query3 = $query3->result();

        $sql = "SELECT username, count(*) as quantity FROM users join tasks on users.user_id = tasks.user_id where tasks.finished = 0 AND tasks.deadline BETWEEN ".$primerSabado." AND ".$segundoSabado." AND tasks.deleted_at IS NULL AND users.deleted_at IS NULL GROUP BY username";
        $query4 = $this->db->query($sql);           //Genera Tabla con username y cuenta de tareas incompletas de esta semana
        $query4 = $query4->result();

        $count = 0;
        $query = [];
        foreach ($query0 as $usuario) {
            $query[$count]['username'] = $usuario->username;

            $asignadas = 0;
            foreach ($query1 as $asigRow){
                if ($asigRow->username == $usuario->username){
                    $asignadas = $asigRow->quantity;
                }
            }
            $query[$count]['asignadas'] = $asignadas;

            $arrastradas = 0;
            foreach ($query2 as $asigRow){
                if ($asigRow->username == $usuario->username){
                    $arrastradas = $asigRow->quantity;
                }
            }
            $query[$count]['inconclusas'] = $arrastradas;

            $completas = 0;
            foreach ($query3 as $asigRow){
                if ($asigRow->username == $usuario->username){
                    $completas = $asigRow->quantity;
                }
            }
            $query[$count]['completas'] = $completas;

            $nInconc = 0;
            foreach ($query4 as $asigRow){
                if ($asigRow->username == $usuario->username){
                    $nInconc = $asigRow->quantity;
                }
            }
            $query[$count]['newInconclusas'] = $nInconc;

            $count = $count + 1;
        }


        return $query;
    }

    public function generarReporteTodo(){

        $sql = "SELECT DISTINCT username FROM users join tasks on users.user_id = tasks.user_id where users.deleted_at IS NULL AND tasks.deleted_at IS NULL

";
        $query0 = $this->db->query($sql);           //Genera Tabla con los usernames que tienen minimo una tarea por hacer
        $query0 = $query0->result();


        $sql = "SELECT username, count(*) as quantity FROM users join tasks on users.user_id = tasks.user_id where users.deleted_at IS NULL AND tasks.deleted_at IS NULL GROUP BY username";
        $query1 = $this->db->query($sql);           //Genera Tabla con username y cuenta de tareas asignadas
        $query1 = $query1->result();

        $query2 = [];

        $sql = "SELECT username, count(*) as quantity FROM users join tasks on users.user_id = tasks.user_id where tasks.finished = 1 AND users.deleted_at IS NULL AND tasks.deleted_at IS NULL GROUP BY username";
        $query3 = $this->db->query($sql);           //Genera Tabla con username y cuenta de tareas completas de esta semana
        $query3 = $query3->result();

        $sql = "SELECT username, count(*) as quantity FROM users join tasks on users.user_id = tasks.user_id where tasks.finished = 0 AND users.deleted_at IS NULL AND tasks.deleted_at IS NULL GROUP BY username";
        $query4 = $this->db->query($sql);           //Genera Tabla con username y cuenta de tareas incompletas de esta semana
        $query4 = $query4->result();

        $count = 0;
        $query = [];
        foreach ($query0 as $usuario) {
            $query[$count]['username'] = $usuario->username;

            $asignadas = 0;
            foreach ($query1 as $asigRow){
                if ($asigRow->username == $usuario->username){
                    $asignadas = $asigRow->quantity;
                }
            }
            $query[$count]['asignadas'] = $asignadas;

            $arrastradas = 0;
            foreach ($query2 as $asigRow){
                if ($asigRow->username == $usuario->username){
                    $arrastradas = $asigRow->quantity;
                }
            }
            $query[$count]['inconclusas'] = $arrastradas;

            $completas = 0;
            foreach ($query3 as $asigRow){
                if ($asigRow->username == $usuario->username){
                    $completas = $asigRow->quantity;
                }
            }
            $query[$count]['completas'] = $completas;

            $nInconc = 0;
            foreach ($query4 as $asigRow){
                if ($asigRow->username == $usuario->username){
                    $nInconc = $asigRow->quantity;
                }
            }
            $query[$count]['newInconclusas'] = $nInconc;

            $count = $count + 1;
        }


        return $query;
    }

    public function leerBySemana($dateID){
        $primerSabado = date("Y-m-d H:i:s", strtotime("last Sunday"));
        $segundoSabado = date("Y-m-d H:i:s", strtotime("next Saturday"));

        if ($dateID != 'null'){
            for ($i = 0; $i < $dateID; $i+=1){

                $segundoSabado = $primerSabado;
                $pDate = strtotime($primerSabado.' - 1 week');
                $primerSabado = date("Y-m-d H:i:s",$pDate);

            }

        }
        $primerSabado = "'".$primerSabado."'";
        $segundoSabado = "'".$segundoSabado."'";

        $sql = "SELECT * from tasks where (deadline between ".$primerSabado." AND ".$segundoSabado." OR (finished = 0 AND recurring = 0 AND deadline < ".$primerSabado.")) AND deleted_at IS NULL";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function leerByMes($dateID){
        $prevMonth = date("Y-m-d H:i:s", strtotime("last day of last month"));
        $nextMonth = date("Y-m-d H:i:s", strtotime("first day of next month"));

        if ($dateID != 'null'){
            for ($i = 0; $i < $dateID; $i+=1){

                $nextMonth = $prevMonth;
                $pDate = strtotime($prevMonth.' - 1 month');
                $prevMonth = date("Y-m-d H:i:s",$pDate);

            }
        }
        $prevMonth = "'".$prevMonth."'";
        $nextMonth = "'".$nextMonth."'";


        $sql = "SELECT * FROM tasks where (deadline BETWEEN ".$prevMonth." AND ".$nextMonth." OR (finished = 0 AND recurring = 0 AND deadline < ".$prevMonth.")) AND deleted_at IS NULL
" ;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function reporteBySemana($dateID){
        $primerSabado = date("Y-m-d H:i:s", strtotime("last Sunday"));
        $segundoSabado = date("Y-m-d H:i:s", strtotime("next Saturday"));

        if ($dateID != 'null'){
            for ($i = 0; $i < $dateID; $i+=1){

                $segundoSabado = $primerSabado;
                $pDate = strtotime($primerSabado.' - 1 week');
                $primerSabado = date("Y-m-d H:i:s",$pDate);

            }
            $primerSabado = "'".$primerSabado."'";
            $segundoSabado = "'".$segundoSabado."'";
        }


        $sql = "SELECT DISTINCT username FROM users join tasks on users.user_id = tasks.user_id where tasks.deadline BETWEEN ".$primerSabado." AND ".$segundoSabado." AND tasks.deleted_at IS NULL AND users.deleted_at IS NULL ";
        $query0 = $this->db->query($sql);           //Genera Tabla con los usernames que tienen minimo una tarea por hacer
        $query0 = $query0->result();


        $sql = "SELECT username, count(*) as quantity FROM users join tasks on users.user_id = tasks.user_id where tasks.deadline BETWEEN ".$primerSabado." AND ".$segundoSabado." AND tasks.deleted_at IS NULL AND users.deleted_at IS NULL GROUP BY username";
        $query1 = $this->db->query($sql);           //Genera Tabla con username y cuenta de tasks asignadas
        $query1 = $query1->result();

        $sql = "SELECT username, count(*) as quantity FROM users join tasks on users.user_id = tasks.user_id where tasks.deadline < ".$primerSabado." AND tasks.finished = 0 AND tasks.recurring = 0 AND tasks.deleted_at IS NULL AND users.deleted_at IS NULL GROUP BY username ";
        $query2 = $this->db->query($sql);           //Genera Tabla con username y cuenta de tasks arrastradas de semanas pasadas
        $query2 = $query2->result();

        $sql = "SELECT username, count(*) as quantity FROM users join tasks on users.user_id = tasks.user_id where tasks.finished = 1 AND tasks.deadline BETWEEN ".$primerSabado." AND ".$segundoSabado." AND tasks.deleted_at IS NULL AND users.deleted_at IS NULL GROUP BY username";
        $query3 = $this->db->query($sql);           //Genera Tabla con username y cuenta de tasks completas de esta semana
        $query3 = $query3->result();

        $sql = "SELECT username, count(*) as quantity FROM users join tasks on users.user_id = tasks.user_id where tasks.finished = 0 AND tasks.deadline BETWEEN ".$primerSabado." AND ".$segundoSabado." AND tasks.deleted_at IS NULL AND users.deleted_at IS NULL GROUP BY username";
        $query4 = $this->db->query($sql);           //Genera Tabla con username y cuenta de tasks incompletas de esta semana
        $query4 = $query4->result();

        $count = 0;
        $query = [];
        foreach ($query0 as $usuario) {
            $query[$count]['username'] = $usuario->username;

            $asignadas = 0;
            foreach ($query1 as $asigRow){
                if ($asigRow->username == $usuario->username){
                    $asignadas = $asigRow->quantity;
                }
            }
            $query[$count]['asignadas'] = $asignadas;

            $arrastradas = 0;
            foreach ($query2 as $asigRow){
                if ($asigRow->username == $usuario->username){
                    $arrastradas = $asigRow->quantity;
                }
            }
            $query[$count]['inconclusas'] = $arrastradas;

            $completas = 0;
            foreach ($query3 as $asigRow){
                if ($asigRow->username == $usuario->username){
                    $completas = $asigRow->quantity;
                }
            }
            $query[$count]['completas'] = $completas;

            $nInconc = 0;
            foreach ($query4 as $asigRow){
                if ($asigRow->username == $usuario->username){
                    $nInconc = $asigRow->quantity;
                }
            }
            $query[$count]['newInconclusas'] = $nInconc;

            $count = $count + 1;
        }


        return $query;
    }

    public function reporteByMes($dateID){
        $prevMonth = date("Y-m-d H:i:s", strtotime("last day of last month"));
        $nextMonth = date("Y-m-d H:i:s", strtotime("first day of next month"));

        if ($dateID != 'null'){
            for ($i = 0; $i < $dateID; $i+=1){

                $nextMonth = $prevMonth;
                $pDate = strtotime($prevMonth.' - 1 month');
                $prevMonth = date("Y-m-d H:i:s",$pDate);

            }
        }
        $prevMonth = "'".$prevMonth."'";
        $nextMonth = "'".$nextMonth."'";


        $sql = "SELECT DISTINCT username FROM users join tasks on users.user_id = tasks.user_id where tasks.deadline BETWEEN ".$prevMonth." AND ".$nextMonth." AND tasks.deleted_at IS NULL AND users.deleted_at IS NULL ";
        $query0 = $this->db->query($sql);           //Genera Tabla con los usernames que tienen minimo una tarea por hacer
        $query0 = $query0->result();


        $sql = "SELECT username, count(*) as quantity FROM users join tasks on users.user_id = tasks.user_id where tasks.deadline BETWEEN ".$prevMonth." AND ".$nextMonth." AND tasks.deleted_at IS NULL AND users.deleted_at IS NULL GROUP BY username";
        $query1 = $this->db->query($sql);           //Genera Tabla con username y cuenta de tasks asignadas
        $query1 = $query1->result();

        $sql = "SELECT username, count(*) as quantity FROM users join tasks on users.user_id = tasks.user_id where tasks.deadline < ".$prevMonth." AND tasks.finished = 0 AND tasks.recurring = 0 AND tasks.deleted_at IS NULL AND users.deleted_at IS NULL GROUP BY username ";
        $query2 = $this->db->query($sql);           //Genera Tabla con username y cuenta de tasks arrastradas de semanas pasadas
        $query2 = $query2->result();

        $sql = "SELECT username, count(*) as quantity FROM users join tasks on users.user_id = tasks.user_id where tasks.finished = 1 AND tasks.deadline BETWEEN ".$prevMonth." AND ".$nextMonth." AND tasks.deleted_at IS NULL AND users.deleted_at IS NULL GROUP BY username";
        $query3 = $this->db->query($sql);           //Genera Tabla con username y cuenta de tasks completas de esta semana
        $query3 = $query3->result();

        $sql = "SELECT username, count(*) as quantity FROM users join tasks on users.user_id = tasks.user_id where tasks.finished = 0 AND tasks.deadline BETWEEN ".$prevMonth." AND ".$nextMonth." AND tasks.deleted_at IS NULL AND users.deleted_at IS NULL GROUP BY username";
        $query4 = $this->db->query($sql);           //Genera Tabla con username y cuenta de tasks incompletas de esta semana
        $query4 = $query4->result();

        $count = 0;
        $query = [];
        foreach ($query0 as $usuario) {
            $query[$count]['username'] = $usuario->username;

            $asignadas = 0;
            foreach ($query1 as $asigRow){
                if ($asigRow->username == $usuario->username){
                    $asignadas = $asigRow->quantity;
                }
            }
            $query[$count]['asignadas'] = $asignadas;

            $arrastradas = 0;
            foreach ($query2 as $asigRow){
                if ($asigRow->username == $usuario->username){
                    $arrastradas = $asigRow->quantity;
                }
            }
            $query[$count]['inconclusas'] = $arrastradas;

            $completas = 0;
            foreach ($query3 as $asigRow){
                if ($asigRow->username == $usuario->username){
                    $completas = $asigRow->quantity;
                }
            }
            $query[$count]['completas'] = $completas;

            $nInconc = 0;
            foreach ($query4 as $asigRow){
                if ($asigRow->username == $usuario->username){
                    $nInconc = $asigRow->quantity;
                }
            }
            $query[$count]['newInconclusas'] = $nInconc;

            $count = $count + 1;
        }


        return $query;
    }

    public function leerDoing(){
        $sql = "SELECT * from tasks  where finished = 0 AND deleted_at IS NULL
 order by deadline, task_id ASC";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function leerDoingBySemana($dateID){
        $primerSabado = date("Y-m-d H:i:s", strtotime("last Sunday"));
        $segundoSabado = date("Y-m-d H:i:s", strtotime("next Saturday"));

        if ($dateID != 'null'){
            for ($i = 0; $i < $dateID; $i+=1){

                $segundoSabado = $primerSabado;
                $pDate = strtotime($primerSabado.' - 1 week');
                $primerSabado = date("Y-m-d H:i:s",$pDate);

            }

        }
        $primerSabado = "'".$primerSabado."'";
        $segundoSabado = "'".$segundoSabado."'";
        $sql = "SELECT * from tasks  where finished = 0 AND deadline BETWEEN ".$primerSabado." AND ".$segundoSabado." AND deleted_at IS NULL order by finished,deadline, task_id ASC";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function leerDoingByMes($dateID){
        $prevMonth = date("Y-m-d H:i:s", strtotime("last day of last month"));
        $nextMonth = date("Y-m-d H:i:s", strtotime("first day of next month"));

        if ($dateID != 'null'){
            for ($i = 0; $i < $dateID; $i+=1){

                $nextMonth = $prevMonth;
                $pDate = strtotime($prevMonth.' - 1 month');
                $prevMonth = date("Y-m-d H:i:s",$pDate);

            }
        }
        $prevMonth = "'".$prevMonth."'";
        $nextMonth = "'".$nextMonth."'";
        $sql = "SELECT * from tasks  where finished = 0  AND deadline BETWEEN ".$prevMonth." AND ".$nextMonth." AND deleted_at IS NULL order by finished,deadline, task_id ASC";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function leerDone(){
        $sql = "SELECT * from tasks  where finished = 1 AND deleted_at IS NULL order by  task_id ASC";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function leerDoneBySemana($dateID){
        $primerSabado = date("Y-m-d H:i:s", strtotime("last Sunday"));
        $segundoSabado = date("Y-m-d H:i:s", strtotime("next Saturday"));

        if ($dateID != 'null'){
            for ($i = 0; $i < $dateID; $i+=1){

                $segundoSabado = $primerSabado;
                $pDate = strtotime($primerSabado.' - 1 week');
                $primerSabado = date("Y-m-d H:i:s",$pDate);

            }

        }
        $primerSabado = "'".$primerSabado."'";
        $segundoSabado = "'".$segundoSabado."'";
        $sql = "SELECT * from tasks  where finished = 1 AND deleted_at IS NULL AND deadline BETWEEN ".$primerSabado." AND ".$segundoSabado." order by  task_id ASC";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function leerDoneByMes($dateID){
        $prevMonth = date("Y-m-d H:i:s", strtotime("last day of last month"));
        $nextMonth = date("Y-m-d H:i:s", strtotime("first day of next month"));

        if ($dateID != 'null'){
            for ($i = 0; $i < $dateID; $i+=1){

                $nextMonth = $prevMonth;
                $pDate = strtotime($prevMonth.' - 1 month');
                $prevMonth = date("Y-m-d H:i:s",$pDate);

            }
        }
        $prevMonth = "'".$prevMonth."'";
        $nextMonth = "'".$nextMonth."'";



        // $this->db->order_by('ID DESC');                  //atributo y tipo de orden
        $sql = "SELECT * from tasks  where finished = 1 AND deleted_at IS NULL AND deadline BETWEEN ".$prevMonth." AND ".$nextMonth." order by  task_id ASC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function consultaTarea($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('task_id',$id);                                         //columna, variable
        $query = $this->db->get('tasks');                          //tabla
        return $query->row();
    }

    public function fetchById($id){

        $primerSabado = date("'Y-m-d H:i:s'", strtotime("last Sunday"));
        $segundoSabado = date("'Y-m-d H:i:s'", strtotime("next Saturday"));
        // $this->db->order_by('ID DESC');                  //atributo y tipo de orden
        if($id == 'all'){
            redirect('tareas');
        }
        else{
            $sql = "SELECT * from tasks  where  deleted_at IS NULL
 AND user_id = ".$id." AND((finished = 0 AND recurring = 0) OR  deadline BETWEEN ".$primerSabado." AND ".$segundoSabado.") order by finished,deadline, task_id ASC";

        }
        $query = $this->db->query($sql);
        return $query->result();                    //viene de C.I.



}

    public function actualizarTarea($id, $tarea){                                             //variable, arreglo
        $this->db->where('task_id',$id);
        if($this->db->update('tasks',$tarea))                                      //actualiza la tupla que coincida con el id         (tabla, array)
            return true;
        else
            return false;
    }

    public function  eliminarTarea($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));

        $this->db->where('task_id', $id);                            //where es un filtrado

        if ($this->db->update('tasks'))
            return true;
        else
            return false;
    }

    public function usersForTask ($Titulo, $Descripcion){
        $sql = "Select DISTINCT username from users join tasks on users.user_id = tasks.user_id where tasks.recurring = 1 AND tasks.title = '".$Titulo."' AND tasks.description = '".$Descripcion."' AND tasks.deleted_at IS NULL AND users.deleted_at IS NULL";
        $query = $this->db->query($sql);
        $query = $query->result();
        return $query;

    }

    public function  eliminarRec($id)
    {

        $sql1 = "SELECT description from tasks where deleted_at IS NULL AND task_id =".$id;
        $query1 = $this->db->query($sql1);
        $query1 = $query1->result();
        $desc = $query1[0]->description;

        $sql1 = "SELECT title from tasks where  deleted_at IS NULL
 AND  task_id =".$id;
        $query1 = $this->db->query($sql1);
        $query1 = $query1->result();
        $titulo = $query1[0]->title;

        $sql1 = "Select task_id from tasks where title = '".$titulo."' AND description = '".$desc."' AND recurring = 1 AND deleted_at IS NULL
";
        $query1 = $this->db->query($sql1);
        $query1 = $query1->result();

        $error = 0;
        foreach ($query1 as $myID){

            $this->db->set('deleted_at', date("Y-m-d H:i:s"));
            $this->db->where('task_id', $myID->task_id);                            //where es un filtrado

            if (!$this->db->update('tasks'))
                $error = 1;

           /* $sql1 = "DELETE from tasks where ID = ".$myID->ID;
            if(!$query1 = $this->db->query($sql1)){
                $error = 1;
            }*/
        }
        if ($error == 1){
            return false;
        }
        else{
            return true;
        }








    }

    public  function  DBRec(){
        // $this->db->order_by('ID DESC');                  //atributo y tipo de orden
        $sql = "Select title, description, user_id, task_id from (Select DISTINCT title, description, user_id, task_id, count(*) from tasks where recurring = 1 AND deleted_at IS NULL group by title, description, user_id ) as tablaA group by title, description having count(*) > 1 ";
        $query0 = $this->db->query($sql);           //Genera Tabla de tasks de mas de uno
        $query0 = $query0->result();

        $sql = "Select title, description, user_id, task_id from (Select DISTINCT title, description, user_id, task_id, count(*) from tasks where recurring = 1 AND deleted_at IS NULL group by title, description, user_id ) as tablaA group by title, description having count(*) < 2 ";
        $query1 = $this->db->query($sql);           //Genera Tabla de tasks de solo uno
        $query1 = $query1->result();



        $count = 0;
        $query = [];
        foreach ($query0 as $tareaVarias) {
            $query[$count]['title'] = $tareaVarias->title;
            $query[$count]['description'] = $tareaVarias->description;
            $query[$count]['Usuario'] = 'Varios';
            $query[$count]['task_id'] = $tareaVarias->task_id;

            $count = $count + 1;
        }
        foreach ($query1 as $tareaSimple) {
            $query[$count]['title'] = $tareaSimple->title;
            $query[$count]['description'] = $tareaSimple->description;
            $query[$count]['Usuario'] = $tareaSimple->user_id;
            $query[$count]['task_id'] = $tareaSimple->task_id;



            $count = $count + 1;
        }
        return $query;

    }






}

