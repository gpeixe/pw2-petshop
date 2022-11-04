<?php 

abstract class Controller {
    
    function __construct() {}

    protected function _validateRequestFields($fields, $data) {
        $error = false;
        foreach ($fields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) { 
                $error = $field; 
                break;
            }
        }
        return $error;
    }
}

?>