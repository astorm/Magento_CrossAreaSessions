<?php
/**
* Reloads a session into $_SESSIOn based on a session id
*/
abstract class Pulsestorm_Crossareasession_Model_Loader_Abstract
{
    abstract function _load($session_id);    
    final public function load($session_id)
    {
        return $this->_load($session_id);
    }
}