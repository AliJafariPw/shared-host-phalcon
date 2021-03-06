<?php


namespace Phalcon\Mvc\Model\MetaData;

use Phalcon\Mvc\Model\MetaData;
use Phalcon\Mvc\Model\Exception;


/***
 * Phalcon\Mvc\Model\MetaData\Apc
 *
 * Stores model meta-data in the APC cache. Data will erased if the web server is restarted
 *
 * By default meta-data is stored for 48 hours (172800 seconds)
 *
 * You can query the meta-data by printing apc_fetch('$PMM$') or apc_fetch('$PMM$my-app-id')
 *
 *<code>
 * $metaData = new \Phalcon\Mvc\Model\Metadata\Apc(
 *     [
 *         "prefix"   => "my-app-id",
 *         "lifetime" => 86400,
 *     ]
 * );
 *</code>
 *
 * @deprecated Deprecated since 3.3.0, will be removed in 4.0.0
 * @see Phalcon\Mvc\Model\Metadata\Apcu
 **/

class Apc extends MetaData {

    protected $_prefix;

    protected $_ttl;

    protected $_metaData;

    /***
	 * Phalcon\Mvc\Model\MetaData\Apc constructor
	 *
	 * @param array options
	 **/
    public function __construct($options  = null ) {

		if ( gettype($options) == "array" ) {
			if ( fetch prefix, options["prefix"] ) {
				$this->_prefix = prefix;
			}
			if ( fetch ttl, options["lif (etime"] ) {
				$this->_ttl = ttl;
			}
		}
    }

    /***
	 * Reads meta-data from APC
	 **/
    public function read($key ) {

		$data = apc_fetch("$PMM$" . $this->_prefix . key);
		if ( gettype($data) == "array" ) {
			return data;
		}
		return null;
    }

    /***
	 * Writes the meta-data to APC
	 **/
    public function write($key , $data ) {
		apc_store("$PMM$" . $this->_prefix . key, data, $this->_ttl);
    }

}