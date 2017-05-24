<?php
class Pulsestorm_Crossareasession_Model_Loader_Redis extends Pulsestorm_Crossareasession_Model_Loader_Abstract
{

    const XML_PATH_HOST            = 'global/redis_session/host';
    const XML_PATH_PORT            = 'global/redis_session/port';
    const XML_PATH_PASS            = 'global/redis_session/password';
    const XML_PATH_TIMEOUT         = 'global/redis_session/timeout';
    const XML_PATH_PERSISTENT      = 'global/redis_session/persistent';

    public function _load($session_id){
        $host    = (string)   (Mage::getConfig()->getNode(self::XML_PATH_HOST) ?: '127.0.0.1');
        $port    = (int)      (Mage::getConfig()->getNode(self::XML_PATH_PORT) ?: '6379');
        $pass    = (string)   (Mage::getConfig()->getNode(self::XML_PATH_PASS) ?: '');
        $timeout = (float) (Mage::getConfig()->getNode(self::XML_PATH_TIMEOUT) ?: '2.5');
        $db      = (int)      (Mage::getConfig()->getNode(self::XML_PATH_DB) ?: '0');

        $_redis = new Credis_Client($host, $port, $timeout);
        if (!empty($pass)) {
            $_redis->auth($pass);
        }
        $_redis->connect(); // connect to redis
        $_redis->select($db);
        // replace sess_session_id with session id you want to read.
        $sessionData = $_redis->hGet('sess_'.$session_id, 'data');
        
        // only data field is relevant to us, uncompress the data
        return $sessionData ? $this->_decodeData($sessionData) : false;

    }

    public function _decodeData($data)
    {
        switch (substr($data,0,4)) {
            // asking the data which library it uses allows for transparent changes of libraries
            case ':sn:': return snappy_uncompress(substr($data,4));
            case ':lz:': return lzf_decompress(substr($data,4));
            case ':gz:': return gzuncompress(substr($data,4));
        }
        return $data;
    }

}
