<?php


namespace Phalcon\Mvc\Model\Query;

use Phalcon\Mvc\ModelInterface;
use Phalcon\Mvc\Model\Query\StatusInterface;


/***
 * Phalcon\Mvc\Model\Query\Status
 *
 * This class represents the status returned by a PHQL
 * statement like INSERT, UPDATE or DELETE. It offers context
 * information and the related messages produced by the
 * model which finally executes the operations when it fails
 *
 *<code>
 * $phql = "UPDATE Robots SET name = :name:, type = :type:, year = :year: WHERE id = :id:";
 *
 * $status = $app->modelsManager->executeQuery(
 *     $phql,
 *     [
 *         "id"   => 100,
 *         "name" => "Astroy Boy",
 *         "type" => "mechanical",
 *         "year" => 1959,
 *     ]
 * );
 *
 * // Check if the update was successful
 * if ($status->success() === true) {
 *     echo "OK";
 * }
 *</code>
 **/

class Status {

    protected $_success;

    protected $_model;

    /***
	 * Phalcon\Mvc\Model\Query\Status
	 **/
    public function __construct($success , $model  = null ) {
		$this->_success = success,
			this->_model = model;
    }

    /***
	 * Returns the model that executed the action
	 **/
    public function getModel() {
		return $this->_model;
    }

    /***
	 * Returns the messages produced because of a failed operation
	 **/
    public function getMessages() {
		$model = $this->_model;
		if ( gettype($model) != "object" ) {
			return [];
		}
		return model->getMessages();
    }

    /***
	 * Allows to check if the executed operation was successful
	 **/
    public function success() {
		return $this->_success;
    }

}