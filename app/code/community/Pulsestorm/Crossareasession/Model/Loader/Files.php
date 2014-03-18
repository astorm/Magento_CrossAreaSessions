<?php
class Pulsestorm_Crossareasession_Model_Loader_Files extends Pulsestorm_Crossareasession_Model_Loader_Abstract
{
    public function _load($session_id)
    {
        $path               = Mage::getBaseDir('session') . '/sess_' . $session_id;
        if(file_exists($path))
        {
            $raw_data           = file_get_contents($path);                                
            session_decode($raw_data);                            
        }        
        else
        {
            $_SESSION = array();
        }
    }
}