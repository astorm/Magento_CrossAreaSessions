<?php
class Pulsestorm_Crossareasession_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {                       
        $this->_exampleCheckAcl();
        // $this->_exampleGetData();        
        // $this->_cheapTest();
    }
    
    protected function _exampleGetData()
    {
        $adminhtml  = Mage::getModel('pulsestorm_crossareasession/manager')->getSessionData('adminhtml'); 
        $frontend   = Mage::getModel('pulsestorm_crossareasession/manager')->getSessionData('frontend'); 
        
        var_dump($adminhtml);
        var_dump($frontend);
    }

    protected function _exampleCheckAcl()
    {
        $manager = Mage::getModel('pulsestorm_crossareasession/manager');
        
        $acl = 'system/cache';
        if($manager->checkAdminAclRule($acl))
        {
            var_dump("Logged in Admin user can access $acl");
        }
        else
        {
            var_dump("Logged in Admin user can NOT access $acl");
        }
    }
    
    protected function _cheapTest()
    {
        if(array_key_exists('admin', $_SESSION))
        {
            var_dump('Admin key exists before initiating things, this is probably an error');
        }    
        // Mage::getSingleton('admin/session')->isAllowed('system/cache');    
        $manager            = Mage::getModel('pulsestorm_crossareasession/manager');        
        
        if(array_key_exists('admin', $_SESSION))
        {
            var_dump('Admin key exists after checking ACL rule, this is probably an error');
        }

        
        
        $admin_session_data = $manager->getSessionData('adminhtml');
        
        if(!array_key_exists('admin', $admin_session_data))
        {
            var_dump('Admin key Not in returned session, probably an error or no session on yet on admin');
        }

        if(array_key_exists('admin', $_SESSION))
        {
            var_dump('Admin key exists after initiating things, this is probably an error');
        }        
        
        var_dump(__METHOD__);
    }
}
