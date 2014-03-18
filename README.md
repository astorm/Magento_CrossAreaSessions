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

Additional Storage Engine Support
--------------------------------------------------
Right now only the `files` and `db` storage types are supported.  If you want to use this with Memcache, reddis, etc. you'll to implement your own loader model. 

Implementing a loader model is as easy as dropping a new class in the 

    app/code/community/Pulsestorm/Crossareasession/Model/

folder, named such that is matches the value in the `<session_save/>` node.  For example, `<session_save>files</session_save>` is `Files.php`, `<session_save>db</session_save>` is `Db.php`, etc. 

A loader object should extend the `Pulsestorm_Crossareasession_Model_Loader_Abstract` class, and implement the single abstract `_load` method.  The `_load` method should load the raw, serialized session data and return it as a string.  
