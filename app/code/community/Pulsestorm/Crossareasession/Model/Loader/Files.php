<?php
class Pulsestorm_Crossareasession_Model_Loader_Files extends Pulsestorm_Crossareasession_Model_Loader_Abstract
{
    public function _load($session_id)
    {
        $path               = Mage::getBaseDir('session') . '/sess_' . $session_id;
        if(file_exists($path))
        {
            $raw_data           = $this->_loadFile($path);
            return $raw_data;
        }
        return false;
    }
    
    protected function _loadFile($path)
    {
        return file_get_contents($path);                                
    }
}