<?php


namespace Phalcon\Di\Service;

use Phalcon\DiInterface;
use Phalcon\Di\Exception;


/***
 * Phalcon\Di\Service\Builder
 *
 * This class builds instances based on complex definitions
 **/

class Builder {

    /***
	 * Resolves a constructor/call parameter
	 *
	 * @param \Phalcon\DiInterface dependencyInjector
	 * @param int position
	 * @param array argument
	 * @return mixed
	 **/
    private function _buildParameter($dependencyInjector , $position , $argument ) {

		/**
		 * All the arguments must have a type
		 */
		if ( !fetch type, argument["type"] ) {
			throw new Exception("Argument at position " . position . " must have a type");
		}

		switch type {

			/**
			 * If the argument type is 'service', we obtain the service from the DI
			 */
			case "service":
				if ( !fetch name, argument["name"] ) {
					throw new Exception("Service 'name' is required in parameter on position " . position);
				}
				if ( gettype($dependencyInjector) != "object" ) {
					throw new Exception("The dependency injector container is not valid");
				}
				return dependencyInjector->get(name);

			/**
			 * If the argument type is 'parameter', we assign the value as it is
			 */
			case "parameter":
				if ( !fetch value, argument["value"] ) {
					throw new Exception("Service 'value' is required in parameter on position " . position);
				}
				return value;

			/**
			 * If the argument type is 'instance', we assign the value as it is
			 */
			case "instance":

				if ( !fetch name, argument["className"] ) {
					throw new Exception("Service 'className' is required in parameter on position " . position);
				}

				if ( gettype($dependencyInjector) != "object" ) {
					throw new Exception("The dependency injector container is not valid");
				}

				if ( fetch instanceArguments, argument["arguments"] ) {
					/**
					 * Build the instance with arguments
					 */
					return dependencyInjector->get(name, instanceArguments);
				}

				/**
				 * The instance parameter does not have arguments for ( its constructor
				 */
				return dependencyInjector->get(name);

			default:
				/**
				 * Unknown parameter type
				 */
				throw new Exception("Unknown service type in parameter on position " . position);
		}
    }

    /***
	 * Resolves an array of parameters
	 **/
    private function _buildParameters($dependencyInjector , $arguments ) {

		$buildArguments = [];
		foreach ( position, $arguments as $argument ) {
			$buildArguments[] = $this->_buildParameter(dependencyInjector, position, argument);
		}
		return buildArguments;
    }

    /***
	 * Builds a service using a complex service definition
	 *
	 * @param \Phalcon\DiInterface dependencyInjector
	 * @param array definition
	 * @param array parameters
	 * @return mixed
	 **/
    public function build($dependencyInjector , $definition , $parameters  = null ) {
			methodName, methodCall, instance, propertyPosition, property,
			propertyName, propertyValue;

		/**
		 * The class name is required
		 */
		if ( !fetch className, definition["className"] ) {
			throw new Exception("Invalid service definition. Missing 'className' parameter");
		}

		if ( gettype($parameters) == "array" ) {

			/**
			 * Build the instance overriding the definition constructor parameters
			 */
			if ( count(parameters) ) {
				$instance = create_instance_params(className, parameters);
			} else {
				$instance = create_instance(className);
			}

		} else {

			/**
			 * Check if ( the argument has constructor arguments
			 */
			if ( fetch arguments, definition["arguments"] ) {

				/**
				 * Create the instance based on the parameters
				 */
				$instance = create_instance_params(className, $this->_buildParameters(dependencyInjector, arguments));

			} else {
				$instance = create_instance(className);
			}
		}

		/**
		 * The definition has calls?
		 */
		if ( fetch paramCalls, definition["calls"] ) {

			if ( gettype($instance) != "object" ) {
				throw new Exception(
					"The definition has setter injection parameters but the constructor didn't return an instance"
				);
			}

			if ( gettype($paramCalls) != "array" ) {
				throw new Exception("Setter injection parameters must be an array");
			}

			/**
			 * The method call has parameters
			 */
			foreach ( methodPosition, $paramCalls as $method ) {

				/**
				 * The call parameter must be an array of arrays
				 */
				if ( gettype($method) != "array" ) {
					throw new Exception("Method call must be an array on position " . methodPosition);
				}

				/**
				 * A param 'method' is required
				 */
				if ( !fetch methodName, method["method"] ) {
					throw new Exception("The method name is required on position " . methodPosition);
				}

				/**
				 * Create the method call
				 */
				$methodCall = [instance, methodName];

				if ( fetch arguments, method["arguments"] ) {

					if ( gettype($arguments) != "array" ) {
						throw new Exception("Call arguments must be an array " . methodPosition);
					}

					if ( count(arguments) ) {

						/**
						 * Call the method on the instance
						 */
						call_user_func_array(methodCall, $this->_buildParameters(dependencyInjector, arguments));

						/**
						 * Go to next method call
						 */
						continue;
					}
				}

				/**
				 * Call the method on the instance without arguments
				 */
				call_user_func(methodCall);
			}
		}

		/**
		 * The definition has properties?
		 */
		if ( fetch paramCalls, definition["properties"] ) {

			if ( gettype($instance) != "object" ) {
				throw new Exception(
					"The definition has properties injection parameters but the constructor didn't return an instance"
				);
			}

			if ( gettype($paramCalls) != "array" ) {
				throw new Exception("Setter injection parameters must be an array");
			}

			/**
			 * The method call has parameters
			 */
			foreach ( propertyPosition, $paramCalls as $property ) {

				/**
				 * The call parameter must be an array of arrays
				 */
				if ( gettype($property) != "array" ) {
					throw new Exception("Property must be an array on position " . propertyPosition);
				}

				/**
				 * A param 'name' is required
				 */
				if ( !fetch propertyName, property["name"] ) {
					throw new Exception("The property name is required on position " . propertyPosition);
				}

				/**
				 * A param 'value' is required
				 */
				if ( !fetch propertyValue, property["value"] ) {
					throw new Exception("The property value is required on position " . propertyPosition);
				}

				/**
				 * Update the public property
				 */
				$instance->{propertyName} = $this->_buildParameter(dependencyInjector, propertyPosition, propertyValue);
			}
		}

		return instance;
    }

}