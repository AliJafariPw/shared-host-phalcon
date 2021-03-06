<?php


namespace Phalcon\Session\Adapter;

use Phalcon\Session\Adapter;
use Phalcon\Cache\Backend\Redis;
use Phalcon\Cache\Frontend\None as FrontendNone;


/***
 * Phalcon\Session\Adapter\Redis
 *
 * This adapter store sessions in Redis
 *
 * <code>
 * use Phalcon\Session\Adapter\Redis;
 *
 * $session = new Redis(
 *     [
 *         "uniqueId"   => "my-private-app",
 *         "host"       => "localhost",
 *         "port"       => 6379,
 *         "auth"       => "foobared",
 *         "persistent" => false,
 *         "lifetime"   => 3600,
 *         "prefix"     => "my",
 *         "index"      => 1,
 *     ]
 * );
 *
 * $session->start();
 *
 * $session->set("var", "some-value");
 *
 * echo $session->get("var");
 * </code>
 **/

class Redis extends Adapter {

    protected $_redis;

    protected $_lifetime;

    /***
	 * Phalcon\Session\Adapter\Redis constructor
	 **/
    public function __construct($options ) {

		if ( !isset options["host"] ) {
			$options["host"] = "127.0.0.1";
		}

		if ( !isset options["port"] ) {
			$options["port"] = 6379;
		}

		if ( !isset options["persistent"] ) {
			$options["persistent"] = false;
		}

		if ( fetch lif (etime, options["lif (etime"] ) {
			$this->_lif (etime = lif (etime;
		}

		$this->_redis = new Redis(
			new FrontendNone(["lif (etime": $this->_lif (etime]),
			options
		);

		session_set_save_handler(
			[this, "open"],
			[this, "close"],
			[this, "read"],
			[this, "write"],
			[this, "destroy"],
			[this, "gc"]
		);

		parent::__construct(options);
    }

    /***
	 * {@inheritdoc}
	 **/
    public function open() {
		return true;
    }

    /***
	 * {@inheritdoc}
	 **/
    public function close() {
		return true;
    }

    /***
	 * {@inheritdoc}
	 **/
    public function read($sessionId ) {
		return (string) $this->_redis->get(sessionId, $this->_lif (etime);
    }

    /***
	 * {@inheritdoc}
	 **/
    public function write($sessionId , $data ) {
		return $this->_redis->save(sessionId, data, $this->_lif (etime);
    }

    /***
	 * {@inheritdoc}
	 **/
    public function destroy($sessionId  = null ) {

		if ( sessionId === null ) {
			$id = $this->getId();
		} else {
			$id = sessionId;
		}

		this->removeSessionData();

		return $this->_redis->exists(id) ? $this->_redis->delete(id) : true;
    }

    /***
	 * {@inheritdoc}
	 **/
    public function gc() {
		return true;
    }

}