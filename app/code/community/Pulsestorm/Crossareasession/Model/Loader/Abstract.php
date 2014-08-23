<?php
/**
* Reloads a session into $_SESSIOn based on a session id
*/
abstract class Pulsestorm_Crossareasession_Model_Loader_Abstract
{

    /**
    * Loads raw session data from session storage
    *
    * The `_load` method should load the raw serialized session
    * data from storage and return it as a string.  If the session
    * data can't be found, this method should return a boolean false
    * or an empty string. 
    * 
    * The system is responsible for passing the data to session_decode.
    * The load method will also mutate the $_SESSION variable — this is 
    * unavoidable, as the only provided way to decode session data is via
    * session_decode, which also mutates $_SESSION
    */
    abstract function _load($session_id);    
    
    protected $_decodeData=true;
    
    final public function load($session_id)
    {
        $string = $this->_load($session_id);
        if (!is_string($string) && $string !== false)
        {
            Mage::throwException('_load should return a string or false');
        }
        
        if(!$this->_decodeData)
        {
            return;
        }
        
        if($string)
        {
            session_decode($string);
        }
        else
        {
            $_SESSION = array();
        }
    }
}