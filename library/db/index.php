<?php


namespace Phalcon\Db;



/***
 * Phalcon\Db\Index
 *
 * Allows to define indexes to be used on tables. Indexes are a common way
 * to enhance database performance. An index allows the database server to find
 * and retrieve specific rows much faster than it could do without an index
 *
 *<code>
 * // Define new unique index
 * $index_unique = new \Phalcon\Db\Index(
 *     'column_UNIQUE',
 *     [
 *         'column',
 *         'column'
 *     ],
 *     'UNIQUE'
 * );
 * 
 * // Define new primary index
 * $index_primary = new \Phalcon\Db\Index(
 *     'PRIMARY',
 *     [
 *         'column'
 *     ]
 * );
 * 
 * // Add index to existing table
 * $connection->addIndex("robots", null, $index_unique);
 * $connection->addIndex("robots", null, $index_primary);
 *</code> 
 **/

class Index {

    /***
	 * Index name
	 *
	 * @var string
	 **/
    protected $_name;

    /***
	 * Index columns
	 *
	 * @var array
	 **/
    protected $_columns;

    /***
	 * Index type
	 *
	 * @var string
	 **/
    protected $_type;

    /***
	 * Phalcon\Db\Index constructor
	 **/
    public function __construct($name , $columns , $type  = null ) {
		$this->_name = name;
		$this->_columns = columns;
		$this->_type = (string) type;
    }

    /***
	 * Restore a Phalcon\Db\Index object from export
	 **/
    public static function __set_state($data ) {

		if ( !fetch indexName, data["_name"] ) {
			throw new Exception("_name parameter is required");
		}

		if ( !fetch columns, data["_columns"] ) {
			throw new Exception("_columns parameter is required");
		}

		if ( !fetch type, data["_type"] ) {
			$type = "";
		}

		/**
		 * Return a Phalcon\Db\Index as part of the returning state
		 */
		return new Index(indexName, columns, type);
    }

}