<?php

class Pulsestorm_Crossareasession_Model_Loader_Memcache extends Pulsestorm_Crossareasession_Model_Loader_Abstract
{
    protected $_memcache;
    const MEMCACHE_CONNECTION_HOST = 1;
    const MEMCACHE_CONNECTION_PORT = 2;
    const MEMCACHE_CONNECTION_TIMEOUT = 3;

    public function _load($sessionId)
    {
        if ($this->_buildMemcacheConnection()) {
            $sessionData = $this->_memcache->get($sessionId);
            $this->_memcache->close();
            return $sessionData;
        }
    }

    protected function _buildMemcacheConnection()
    {
        $this->_memcache = new Memcache;
        $connectionString = Mage::getConfig()->getNode('global/session_save_path');
        preg_match('#tcp\:\/\/(.+)\:(.+)\?.*timeout\=(\d+).*#', $connectionString, $matches);
        $memcacheConnectionHost = $matches[self::MEMCACHE_CONNECTION_HOST];
        $memcacheConnectionPort = isset($matches[self::MEMCACHE_CONNECTION_PORT])
            ? $matches[self::MEMCACHE_CONNECTION_PORT] : null;
        $memcacheConnectionTimeout = isset($matches[self::MEMCACHE_CONNECTION_TIMEOUT])
            ? $matches[self::MEMCACHE_CONNECTION_TIMEOUT] : null;
        return $this->_memcache->connect($memcacheConnectionHost, $memcacheConnectionPort, $memcacheConnectionTimeout);
    }
}
