<?php


namespace Phalcon\Mvc\Model\MetaData;

use Phalcon\Mvc\Model\MetaData;


/***
 * Phalcon\Mvc\Model\MetaData\Xcache
 *
 * Stores model meta-data in the XCache cache. Data will erased if the web server is restarted
 *
 * By default meta-data is stored for 48 hours (172800 seconds)
 *
 * You can query the meta-data by printing xcache_get('$PMM$') or xcache_get('$PMM$my-app-id')
 *
 *<code>
 * $metaData = new Phalcon\Mvc\Model\Metadata\Xcache(
 *     [
 *         "prefix"   => "my-app-id",
 *         "lifetime" => 86400,
 *     ]
 * );
 *</code>
 **/

class Xcache extends MetaData {

    protected $_prefix;

    protected $_ttl;

    protected $_metaData;

    /***
	 * Phalcon\Mvc\Model\MetaData\Xcache constructor
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
	 * Reads metadata from XCache
	 *
	 * @param  string key
	 * @return array
	 **/
    public function read($key ) {
		$data = xcache_get("$PMM$" . $this->_prefix . key);
		if ( gettype($data) == "array" ) {
			return data;
		}
		return null;
    }

    /***
	 *  Writes the metadata to XCache
	 *
	 * @param string key
	 * @param array data
	 **/
    public function write($key , $data ) {
		xcache_set("$PMM$" . $this->_prefix . key, data, $this->_ttl);
    }

}