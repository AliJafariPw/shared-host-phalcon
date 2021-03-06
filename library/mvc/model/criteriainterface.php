<?php


namespace Phalcon\Mvc\Model;

use Phalcon\DiInterface;


/***
 * Phalcon\Mvc\Model\CriteriaInterface
 *
 * Interface for Phalcon\Mvc\Model\Criteria
 **/

interface CriteriaInterface {

    /***
	 * Set a model on which the query will be executed
	 **/
    public function setModelName($modelName ); 

    /***
	 * Returns an internal model name on which the criteria will be applied
	 **/
    public function getModelName(); 

    /***
	 * Sets the bound parameters in the criteria
	 * This method replaces all previously set bound parameters
	 **/
    public function bind($bindParams ); 

    /***
	 * Sets the bind types in the criteria
	 * This method replaces all previously set bound parameters
	 **/
    public function bindTypes($bindTypes ); 

    /***
	 * Sets the conditions parameter in the criteria
	 **/
    public function where($conditions ); 

    /***
	 * Adds the conditions parameter to the criteria
	 **/
    public function conditions($conditions ); 

    /***
	 * Adds the order-by parameter to the criteria
	 **/
    public function orderBy($orderColumns ); 

    /***
	 * Sets the limit parameter to the criteria
	 *
	 * @param int limit
	 * @param int offset
	 * @return \Phalcon\Mvc\Model\CriteriaInterface
	 **/
    public function limit($limit , $offset  = null ); 

    /***
	 * Sets the "for_update" parameter to the criteria
	 **/
    public function forUpdate($forUpdate  = true ); 

    /***
	 * Sets the "shared_lock" parameter to the criteria
	 **/
    public function sharedLock($sharedLock  = true ); 

    /***
	 * Appends a condition to the current conditions using an AND operator
	 *
	 * @param string conditions
	 * @param array bindParams
	 * @param array bindTypes
	 * @return \Phalcon\Mvc\Model\CriteriaInterface
	 **/
    public function andWhere($conditions , $bindParams  = null , $bindTypes  = null ); 

    /***
	 * Appends a condition to the current conditions using an OR operator
	 *
	 * @param string conditions
	 * @param array bindParams
	 * @param array bindTypes
	 * @return \Phalcon\Mvc\Model\CriteriaInterface
	 **/
    public function orWhere($conditions , $bindParams  = null , $bindTypes  = null ); 

    /***
	 * Appends a BETWEEN condition to the current conditions
	 *
	 *<code>
	 * $criteria->betweenWhere("price", 100.25, 200.50);
	 *</code>
	 *
	 * @param string expr
	 * @param mixed minimum
	 * @param mixed maximum
	 * @return \Phalcon\Mvc\Model\CriteriaInterface
	 **/
    public function betweenWhere($expr , $minimum , $maximum ); 

    /***
	 * Appends a NOT BETWEEN condition to the current conditions
	 *
	 *<code>
	 * $criteria->notBetweenWhere("price", 100.25, 200.50);
	 *</code>
	 *
	 * @param string expr
	 * @param mixed minimum
	 * @param mixed maximum
	 * @return \Phalcon\Mvc\Model\CriteriaInterface
	 **/
    public function notBetweenWhere($expr , $minimum , $maximum ); 

    /***
	 * Appends an IN condition to the current conditions
	 *
	 *<code>
	 * $criteria->inWhere("id", [1, 2, 3]);
	 *</code>
	 **/
    public function inWhere($expr , $values ); 

    /***
	 * Appends a NOT IN condition to the current conditions
	 *
	 *<code>
	 * $criteria->notInWhere("id", [1, 2, 3]);
	 *</code>
	 **/
    public function notInWhere($expr , $values ); 

    /***
	 * Returns the conditions parameter in the criteria
	 *
	 * @return string|null
	 **/
    public function getWhere(); 

    /***
	 * Returns the conditions parameter in the criteria
	 *
	 * @return string|null
	 **/
    public function getConditions(); 

    /***
	 * Returns the limit parameter in the criteria, which will be
	 * an integer if limit was set without an offset,
	 * an array with 'number' and 'offset' keys if an offset was set with the limit,
	 * or null if limit has not been set.
	 *
	 * @return int|array|null
	 **/
    public function getLimit(); 

    /***
	 * Returns the order parameter in the criteria
	 *
	 * @return string|null
	 **/
    public function getOrderBy(); 

    /***
	 * Returns all the parameters defined in the criteria
	 *
	 * @return array
	 **/
    public function getParams(); 

    /***
	 * Executes a find using the parameters built with the criteria
	 **/
    public function execute(); 

}