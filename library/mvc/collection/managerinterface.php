<?php


namespace Phalcon\Mvc\Collection;

use Phalcon\Db\AdapterInterface;
use Phalcon\Mvc\CollectionInterface;
use Phalcon\Mvc\Collection\BehaviorInterface;
use Phalcon\Events\ManagerInterface as EventsManagerInterface;


/***
 * Phalcon\Mvc\Collection\Manager
 *
 * This components controls the initialization of models, keeping record of relations
 * between the different models of the application.
 *
 * A CollectionManager is injected to a model via a Dependency Injector Container such as Phalcon\Di.
 *
 * <code>
 * $di = new \Phalcon\Di();
 *
 * $di->set(
 *     "collectionManager",
 *     function() {
 *         return new \Phalcon\Mvc\Collection\Manager();
 *     }
 * );
 *
 * $robot = new Robots(di);
 * </code>
 **/

interface ManagerInterface {

    /***
	 * Sets a custom events manager for a specific model
	 **/
    public function setCustomEventsManager($model , $eventsManager ); 

    /***
	 * Returns a custom events manager related to a model
	 **/
    public function getCustomEventsManager($model ); 

    /***
	 * Initializes a model in the models manager
	 **/
    public function initialize($model ); 

    /***
	 * Check whether a model is already initialized
	 **/
    public function isInitialized($modelName ); 

    /***
	 * Get the latest initialized model
	 **/
    public function getLastInitialized(); 

    /***
	 * Sets a connection service for a specific model
	 **/
    public function setConnectionService($model , $connectionService ); 

    /***
	 * Sets if a model must use implicit objects ids
	 **/
    public function useImplicitObjectIds($model , $useImplicitObjectIds ); 

    /***
	 * Checks if a model is using implicit object ids
	 **/
    public function isUsingImplicitObjectIds($model ); 

    /***
	 * Returns the connection related to a model
	 **/
    public function getConnection($model ); 

    /***
	 * Receives events generated in the models and dispatches them to an events-manager if available
	 * Notify the behaviors that are listening in the model
	 **/
    public function notifyEvent($eventName , $model ); 

    /***
	 * Binds a behavior to a collection
	 **/
    public function addBehavior($model , $behavior ); 

}