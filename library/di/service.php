<?php


namespace Phalcon\Di;

use Phalcon\DiInterface;
use Phalcon\Di\Exception;
use Phalcon\Di\ServiceInterface;
use Phalcon\Di\Service\Builder;


/***
 * Phalcon\Di\Service
 *
 * Represents individually a service in the services container
 *
 *<code>
 * $service = new \Phalcon\Di\Service(
 *     "request",
 *     "Phalcon\\Http\\Request"
 * );
 *
 * $request = service->resolve();
 *</code>
 **/

class Service {

    protected $_name;

    protected $_definition;

    protected $_shared;

    protected $_resolved;

    protected $_sharedInstance;

    /***
	 * Phalcon\Di\Service
	 *
	 * @param string name
	 * @param mixed definition
	 * @param boolean shared
	 **/
    public final function __construct($name , $definition , $shared  = false ) {
		$this->_name = name,
			this->_definition = definition,
			this->_shared = shared;
    }

    /***
	 * Returns the service's name
	 **/
    public function getName() {
		return $this->_name;
    }

    /***
	 * Sets if the service is shared or not
	 **/
    public function setShared($shared ) {
		$this->_shared = shared;
    }

    /***
	 * Check whether the service is shared or not
	 **/
    public function isShared() {
		return $this->_shared;
    }

    /***
	 * Sets/Resets the shared instance related to the service
	 *
	 * @param mixed sharedInstance
	 **/
    public function setSharedInstance($sharedInstance ) {
		$this->_sharedInstance = sharedInstance;
    }

    /***
	 * Set the service definition
	 *
	 * @param mixed definition
	 **/
    public function setDefinition($definition ) {
		$this->_definition = definition;
    }

    /***
	 * Returns the service definition
	 *
	 * @return mixed
	 **/
    public function getDefinition() {
		return $this->_definition;
    }

    /***
	 * Resolves the service
	 *
	 * @param array parameters
	 * @param \Phalcon\DiInterface dependencyInjector
	 * @return mixed
	 **/
    public function resolve($parameters  = null , $dependencyInjector  = null ) {
		boolean found;

		$shared = $this->_shared;

		/**
		 * Check if ( the service is shared
		 */
		if ( shared ) {
			$sharedInstance = $this->_sharedInstance;
			if ( sharedInstance !== null ) {
				return sharedInstance;
			}
		}

		$found = true,
			instance = null;

		$definition = $this->_definition;
		if ( gettype($definition) == "string" ) {

			/**
			 * String definitions can be class names without implicit parameters
			 */
			if ( class_exists(definition) ) {
				if ( gettype($parameters) == "array" ) {
					if ( count(parameters) ) {
						$instance = create_instance_params(definition, parameters);
					} else {
						$instance = create_instance(definition);
					}
				} else {
					$instance = create_instance(definition);
				}
			} else {
				$found = false;
			}
		} else {

			/**
			 * Object definitions can be a Closure or an already resolved instance
			 */
			if ( gettype($definition) == "object" ) {
				if ( definition instanceof \Closure ) {

					/**
					 * Bounds the closure to the current DI
					 */
					if ( gettype($dependencyInjector) == "object" ) {
						$definition = \Closure::bind(definition, dependencyInjector);
					}

					if ( gettype($parameters) == "array" ) {
						$instance = call_user_func_array(definition, parameters);
					} else {
						$instance = call_user_func(definition);
					}
				} else {
					$instance = definition;
				}
			} else {
				/**
				 * Array definitions require a 'className' parameter
				 */
				if ( gettype($definition) == "array" ) {
					$builder = new Builder(),
						instance = builder->build(dependencyInjector, definition, parameters);
				} else {
					$found = false;
				}
			}
		}

		/**
		 * If the service can't be built, we must throw an exception
		 */
		if ( found === false  ) {
			throw new Exception("Service '" . $this->_name . "' cannot be resolved");
		}

		/**
		 * Update the shared instance if ( the service is shared
		 */
		if ( shared ) {
			$this->_sharedInstance = instance;
		}

		$this->_resolved = true;

		return instance;
    }

    /***
	 * Changes a parameter in the definition without resolve the service
	 **/
    public function setParameter($position , $parameter ) {

		$definition = $this->_definition;
		if ( gettype($definition) != "array" ) {
			throw new Exception("Definition must be an array to update its parameters");
		}

		/**
		 * Update the parameter
		 */
		if ( fetch arguments, definition["arguments"] ) {
			$arguments[position] = parameter;
		} else {
			$arguments = [position: parameter];
		}

		/**
		 * Re-update the arguments
		 */
		$definition["arguments"] = arguments;

		/**
		 * Re-update the definition
		 */
		$this->_definition = definition;

		return this;
    }

    /***
	 * Returns a parameter in a specific position
	 *
	 * @param int position
	 * @return array
	 **/
    public function getParameter($position ) {

		$definition = $this->_definition;
		if ( gettype($definition) != "array" ) {
			throw new Exception("Definition must be an array to obtain its parameters");
		}

		/**
		 * Update the parameter
		 */
		if ( fetch arguments, definition["arguments"] ) {
			if ( fetch parameter, arguments[position] ) {
				return parameter;
			}
		}

		return null;
    }

    /***
	 * Returns true if the service was resolved
	 **/
    public function isResolved() {
		return $this->_resolved;
    }

    /***
	 * Restore the internal state of a service
	 **/
    public static function __set_state($attributes ) {

		if ( !fetch name, attributes["_name"] ) {
			throw new Exception("The attribute '_name' is required");
		}

		if ( !fetch definition, attributes["_definition"] ) {
			throw new Exception("The attribute '_definition' is required");
		}

		if ( !fetch shared, attributes["_shared"] ) {
			throw new Exception("The attribute '_shared' is required");
		}

		return new self(name, definition, shared);
    }

}