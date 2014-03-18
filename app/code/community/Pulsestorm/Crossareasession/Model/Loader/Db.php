<?php
class Pulsestorm_Crossareasession_Model_Loader_Db extends Pulsestorm_Crossareasession_Model_Loader_Abstract
{
    public function _load($session_id)
    {
        $reader = Mage::getSingleton('core/resource_session');
        $data = $reader->read($session_id);
        if($data)
        {
            session_decode($data);
        }
        else
        {
            $_SESSION = array();
        }
    }
}