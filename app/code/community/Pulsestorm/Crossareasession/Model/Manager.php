<?php
class Pulsestorm_Crossareasession_Model_Manager
{   
    protected $_originalSession = false;
    public function checkAdminAclRule($path)
    {
        $this->_loadNewSessionIntoSuperglobal('adminhtml');
        $result     = Mage::getSingleton('admin/session')->isAllowed($path);                
        $_SESSION   = $this->_originalSession;
        return $result;        
    }
    
    /**
    * This method replaces $_SESSION in place -- you're
    * responsible for restoring the original. Unavoidable
    * since this is how session_decode wowrks
    */    
    protected function _loadNewSessionIntoSuperglobal($area)
    {
        //stash original session
        $this->_originalSession = $_SESSION;
        
        $session_id         = Mage::getModel('core/cookie')
        ->get($area);

        if(!$session_id)
        {
            $_SESSION = array();
            return;
        }
        
        $session_save_type = (string)Mage::getConfig()->getNode('global/session_save');        
        if( (string) Mage::getConfig()->getModuleConfig('Cm_RedisSession')->active == 'true' && 
            $session_save_type == 'db')
        {
            $session_save_type = 'redis';
        }
    
        $decoded_data = false;    
        
        //load 'er up
        $loader = Mage::getModel('pulsestorm_crossareasession/loader_' . $session_save_type);
        
        $loader->load($session_id);        
    }
    
    public function getSessionData($area)
    {           
        $this->_loadNewSessionIntoSuperglobal($area);        
        $area_session_data  = $_SESSION;        
        $_SESSION           = $this->_originalSession;
        return $area_session_data;
        
        //$test = Mage::getSingleton('admin/session')->isAllowed('system/cache');        
        //         var_dump($test);
        //         
        //         var_dump($_SESSION['admin']['user']);
        //         
        //         
        //         
        //         exit(__METHOD__);        
    }    
}