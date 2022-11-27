<?php

include_once('../../../../../helpers/vars.php');

if ($isProduction) { 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/dirs.php');
} else {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/auditoria/helpers/dirs.php');
}
include_once(DB . 'connection_db.php');

class InternalCALL extends Connection {
    
    /**
     * Carga una martriz de tipo Object a
     * un unico string, listo para ser enviado
     * a un procedimiento almacenado
     */
    protected function join_params($params) {
        $params_joined = '';
        $auxiliary_join = '';
        $count = 1;
        $max_count = count($params);
        foreach($params as $value) {
            if ($count != $max_count) {
                $auxiliary_join = ",";
            }
            if (gettype($value) == 'string') {
                $params_joined .= "'" . $value . "'" . $auxiliary_join;
                $auxiliary_join = "";
                ++$count;
                continue;
            }
            $params_joined .= $value . $auxiliary_join;
            $auxiliary_join = "";
            ++$count;
        }
        return $params_joined;
    }

    /**
     * Hace la refleccion de la clase class
     * y carga los valores que vienen en values en una lista
     * nueva del tipo class
     */
    protected function charger_params_multi($values, $class) {
        $class_list = array();
        $reflector = new ReflectionClass($class);
        $vars_list = array_keys(get_class_vars(get_class($class))); 
        while ($row = $values->fetch_row()) {
            $iterator = 0;
            $class_instance = $reflector->newInstanceArgs(); 
            foreach ($row as $column) {
                $varName = $reflector->getProperty($vars_list[$iterator]);
                $varName->setAccessible(true);
                $varName->setValue($class_instance, $column); 
                ++$iterator;
            }
            array_push($class_list, $class_instance);
        } 
        return $class_list;
    }

    /**
     * Hace la instrospeccion para la clase class
     * y los carga en ella un objeto de la instancia
     * del tipo class
     */
    protected function charger_params_one($values, $class) { 
        $reflector = new ReflectionClass($class);
        $vars_list = array_keys(get_class_vars(get_class($class))); 
        $iterator = 0;
        while ($row = $values->fetch_row()) { 
            foreach ($row as $column) { 
                $varName = $reflector->getProperty($vars_list[$iterator]); 
                $varName->setAccessible(true);
                $varName->setValue($class, $column); 
                ++$iterator;
            } 
        }   
    }

    /**
     * Hace el llamado a un procedimiento almacenado
     * devuelve una lista instanciada del tipo: $class
     */
    public function  call_procedure_multi($procedure_name, $params, $class) {
        $data = array();
        try {
            $io = $this->join_params($params);
            $Connection = new Connection();
            $conn = $Connection->getConnection();
            if ($output = $conn->query("CALL ".$procedure_name."(".$io.");")):
                $result = $this->charger_params_multi($output, $class);
                if (count($result) > 0):
                    $data = $result;
                endif;
            endif;
            $Connection->closeConnection(); 
        } catch (Exception $e) {
            echo $e; 
        }     
        return $data;   
    }

    /**
     * Hace el llamado a un procedimiento almacenado
     * devuelve una clase instaciada del tipo: $class
     */
    public function call_procedure_one($procedure_name, $params, $class) {
        try {
            $io = $this->join_params($params);
            $Connection = new Connection();
            $conn = $Connection->getConnection();
            if ($output = $conn->query("CALL ".$procedure_name."(".$io.");")):
                $this->charger_params_one($output, $class);
            endif;
            $Connection->closeConnection();
            return true;
        } catch (Exception $e) {
            echo $e;
            return false;
        }        
    }

    public function insert_model($procedure_name, $params, $class) {
        $reflector = new ReflectionClass($class);
        $properties = $reflector->getProperties();
        foreach ($properties as $property) {
            $varName = $property->getValue($class);
            array_push($params,$varName);
        }
        $generic_response = new GenericResponse();
        $this->call_procedure_one($procedure_name, $params, $generic_response);

        return $generic_response;
    }
}



