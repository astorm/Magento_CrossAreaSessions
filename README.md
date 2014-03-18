Magento Cross Area Sessions
=========================

Research module providing a manager for accessing adminhtml sessions from the frontend area, and frontend sessions from the adminhtml area.

Can load from `file` or `database` session storage, with a simple "drop in" class for other session types.  See files in `Model/Loader` for examples. 

Usage
--------------------------------------------------

Grabbing `adminhtml` or `frontend` session data from either environment. 

    $adminhtml  = Mage::getModel('pulsestorm_crossareasession/manager')
    ->getSessionData('adminhtml'); 
    
    $frontend   = Mage::getModel('pulsestorm_crossareasession/manager')
    ->getSessionData('frontend'); 
    
    var_dump($adminhtml);
    var_dump($frontend);
    
Checking an admin ACL rule from the frontend.

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
