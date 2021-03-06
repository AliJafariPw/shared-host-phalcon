<?php


namespace Phalcon\Db;



/***
 * Phalcon\Db\AdapterInterface
 *
 * Interface for Phalcon\Db adapters
 **/

interface AdapterInterface {

    /***
	 * Returns the first row in a SQL query result
	 *
	 * @param string sqlQuery
	 * @param int fetchMode
	 * @param int placeholders
	 * @return array
	 **/
    public function fetchOne($sqlQuery , $fetchMode  = 2 , $placeholders  = null ); 

    /***
	 * Dumps the complete result of a query into an array
	 *
	 * @param string sqlQuery
	 * @param int fetchMode
	 * @param int placeholders
	 * @return array
	 **/
    public function fetchAll($sqlQuery , $fetchMode  = 2 , $placeholders  = null ); 

    /***
	 * Inserts data into a table using custom RDBMS SQL syntax
	 *
	 * @param 	string table
	 * @param 	array values
	 * @param 	array fields
	 * @param 	array dataTypes
	 * @return 	boolean
	 **/
    public function insert($table , $values , $fields  = null , $dataTypes  = null ); 

    /***
	 * Updates data on a table using custom RDBMS SQL syntax
	 *
	 * @param 	string table
	 * @param 	array fields
	 * @param 	array values
	 * @param 	string whereCondition
	 * @param 	array dataTypes
	 * @return 	boolean
	 **/
    public function update($table , $fields , $values , $whereCondition  = null , $dataTypes  = null ); 

    /***
	 * Deletes data from a table using custom RDBMS SQL syntax
	 *
	 * @param  string table
	 * @param  string whereCondition
	 * @param  array placeholders
	 * @param  array dataTypes
	 * @return boolean
	 **/
    public function delete($table , $whereCondition  = null , $placeholders  = null , $dataTypes  = null ); 

    /***
	 * Gets a list of columns
	 *
	 * @param	array columnList
	 * @return	string
	 **/
    public function getColumnList($columnList ); 

    /***
	 * Appends a LIMIT clause to sqlQuery argument
	 *
	 * @param  	string sqlQuery
	 * @param 	int number
	 * @return 	string
	 **/
    public function limit($sqlQuery , $number ); 

    /***
	 * Generates SQL checking for the existence of a schema.table
	 **/
    public function tableExists($tableName , $schemaName  = null ); 

    /***
	 * Generates SQL checking for the existence of a schema.view
	 **/
    public function viewExists($viewName , $schemaName  = null ); 

    /***
	 * Returns a SQL modified with a FOR UPDATE clause
	 **/
    public function forUpdate($sqlQuery ); 

    /***
	 * Returns a SQL modified with a LOCK IN SHARE MODE clause
	 **/
    public function sharedLock($sqlQuery ); 

    /***
	 * Creates a table
	 **/
    public function createTable($tableName , $schemaName , $definition ); 

    /***
	 * Drops a table from a schema/database
	 **/
    public function dropTable($tableName , $schemaName  = null , $ifExists  = true ); 

    /***
	 * Creates a view
	 **/
    public function createView($viewName , $definition , $schemaName  = null ); 

    /***
	 * Drops a view
	 **/
    public function dropView($viewName , $schemaName  = null , $ifExists  = true ); 

    /***
	 * Adds a column to a table
	 **/
    public function addColumn($tableName , $schemaName , $column ); 

    /***
	 * Modifies a table column based on a definition
	 **/
    public function modifyColumn($tableName , $schemaName , $column , $currentColumn  = null ); 

    /***
	 * Drops a column from a table
	 **/
    public function dropColumn($tableName , $schemaName , $columnName ); 

    /***
	 * Adds an index to a table
	 **/
    public function addIndex($tableName , $schemaName , $index ); 

    /***
	 * Drop an index from a table
	 **/
    public function dropIndex($tableName , $schemaName , $indexName ); 

    /***
	 * Adds a primary key to a table
	 **/
    public function addPrimaryKey($tableName , $schemaName , $index ); 

    /***
	 * Drops primary key from a table
	 **/
    public function dropPrimaryKey($tableName , $schemaName ); 

    /***
	 * Adds a foreign key to a table
	 **/
    public function addForeignKey($tableName , $schemaName , $reference ); 

    /***
	 * Drops a foreign key from a table
	 **/
    public function dropForeignKey($tableName , $schemaName , $referenceName ); 

    /***
	 * Returns the SQL column definition from a column
	 **/
    public function getColumnDefinition($column ); 

    /***
	 * List all tables on a database
	 **/
    public function listTables($schemaName  = null ); 

    /***
	 * List all views on a database
	 **/
    public function listViews($schemaName  = null ); 

    /***
	 * Return descriptor used to connect to the active database
	 *
	 * @return array
	 **/
    public function getDescriptor(); 

    /***
	 * Gets the active connection unique identifier
	 *
	 * @return string
	 **/
    public function getConnectionId(); 

    /***
	 * Active SQL statement in the object
	 **/
    public function getSQLStatement(); 

    /***
	 * Active SQL statement in the object without replace bound parameters
	 **/
    public function getRealSQLStatement(); 

    /***
	 * Active SQL statement in the object
	 *
	 * @return array
	 **/
    public function getSQLVariables(); 

    /***
	 * Active SQL statement in the object
	 *
	 * @return array
	 **/
    public function getSQLBindTypes(); 

    /***
	 * Returns type of database system the adapter is used for
	 *
	 * @return string
	 **/
    public function getType(); 

    /***
	 * Returns the name of the dialect used
	 *
	 * @return string
	 **/
    public function getDialectType(); 

    /***
	 * Returns internal dialect instance
	 **/
    public function getDialect(); 

    /***
	 * This method is automatically called in \Phalcon\Db\Adapter\Pdo constructor.
	 * Call it when you need to restore a database connection
	 **/
    public function connect($descriptor  = null ); 

    /***
	 * Sends SQL statements to the database server returning the success state.
	 * Use this method only when the SQL statement sent to the server return rows
	 **/
    public function query($sqlStatement , $placeholders  = null , $dataTypes  = null ); 

    /***
	 * Sends SQL statements to the database server returning the success state.
	 * Use this method only when the SQL statement sent to the server doesn't return any rows
	 **/
    public function execute($sqlStatement , $placeholders  = null , $dataTypes  = null ); 

    /***
	 * Returns the number of affected rows by the last INSERT/UPDATE/DELETE reported by the database system
	 **/
    public function affectedRows(); 

    /***
	 * Closes active connection returning success. Phalcon automatically closes
	 * and destroys active connections within Phalcon\Db\Pool
	 **/
    public function close(); 

    /***
	 * Escapes a column/table/schema name
	 *
	 * @param string identifier
	 * @return string
	 **/
    public function escapeIdentifier($identifier ); 

    /***
	 * Escapes a value to avoid SQL injections
	 **/
    public function escapeString($str ); 

    /***
	 * Returns insert id for the auto_increment column inserted in the last SQL statement
	 *
	 * @param string sequenceName
	 * @return int
	 **/
    public function lastInsertId($sequenceName  = null ); 

    /***
	 * Starts a transaction in the connection
	 **/
    public function begin($nesting  = true ); 

    /***
	 * Rollbacks the active transaction in the connection
	 **/
    public function rollback($nesting  = true ); 

    /***
	 * Commits the active transaction in the connection
	 **/
    public function commit($nesting  = true ); 

    /***
	 * Checks whether connection is under database transaction
	 **/
    public function isUnderTransaction(); 

    /***
	 * Return internal PDO handler
	 **/
    public function getInternalHandler(); 

    /***
	 * Lists table indexes
	 **/
    public function describeIndexes($table , $schema  = null ); 

    /***
	 * Lists table references
	 **/
    public function describeReferences($table , $schema  = null ); 

    /***
	 * Gets creation options from a table
	 **/
    public function tableOptions($tableName , $schemaName  = null ); 

    /***
	 * Check whether the database system requires an explicit value for identity columns
	 **/
    public function useExplicitIdValue(); 

    /***
	 * Return the default identity value to insert in an identity column
	 **/
    public function getDefaultIdValue(); 

    /***
	 * Check whether the database system requires a sequence to produce auto-numeric values
	 **/
    public function supportSequences(); 

    /***
	 * Creates a new savepoint
	 **/
    public function createSavepoint($name ); 

    /***
	 * Releases given savepoint
	 **/
    public function releaseSavepoint($name ); 

    /***
	 * Rollbacks given savepoint
	 **/
    public function rollbackSavepoint($name ); 

    /***
	 * Set if nested transactions should use savepoints
	 **/
    public function setNestedTransactionsWithSavepoints($nestedTransactionsWithSavepoints ); 

    /***
	 * Returns if nested transactions should use savepoints
	 **/
    public function isNestedTransactionsWithSavepoints(); 

    /***
	 * Returns the savepoint name to use for nested transactions
	 **/
    public function getNestedTransactionSavepointName(); 

    /***
	 * Returns an array of Phalcon\Db\Column objects describing a table
	 **/
    public function describeColumns($table , $schema  = null ); 

}