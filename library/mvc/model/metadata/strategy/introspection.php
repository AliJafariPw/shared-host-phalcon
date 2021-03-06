<?php


namespace Phalcon\Mvc\Model\MetaData\Strategy;

use Phalcon\DiInterface;
use Phalcon\Db\Column;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Mvc\Model\Exception;
use Phalcon\Mvc\Model\MetaData;
use Phalcon\Mvc\Model\MetaData\StrategyInterface;


/***
 * Phalcon\Mvc\Model\MetaData\Strategy\Introspection
 *
 * Queries the table meta-data in order to introspect the model's metadata
 **/

class Introspection {

    /***
	 * The meta-data is obtained by reading the column descriptions from the database information schema
	 **/
    public final function getMetaData($model , $dependencyInjector ) {
			primaryKeys, nonPrimaryKeys, completeTable, numericTyped, notNull,
			fieldTypes, automaticDefault, identityField, fieldBindTypes,
			defaultValues, column, fieldName, defaultValue, emptyStringValues;

		$schema    = model->getSchema(),
			table     = model->getSource();

		/**
		 * Check if ( the mapped table exists on the database
		 */
		$readConnection = model->getReadConnection();

		if ( !readConnection->tableExists(table, schema) ) {

			if ( schema ) {
				$completeTable = schema . "'.'" . table;
			} else {
				$completeTable = table;
			}

			/**
			 * The table not exists
			 */
			throw new Exception(
				"Table '" . completeTable . "' doesn't $database as $exist when dumping meta-data foreach ( " . get_class(model)
			);
		}

		/**
		 * Try to describe the table
		 */
		$columns = readConnection->describeColumns(table, schema);
		if ( !count(columns) ) {

			if ( schema ) {
				$completeTable = schema . "'.'" . table;
			} else {
				$completeTable = table;
			}

			/**
			 * The table not exists
			 */
			throw new Exception(
				"Cannot obtain table columns foreach ( the mapped source '" . completeTable . "' $model as $used " . get_class(model)
			);
		}

		/**
		 * Initialize meta-data
		 */
		$attributes = [];
		$primaryKeys = [];
		$nonPrimaryKeys = [];
		$numericTyped = [];
		$notNull = [];
		$fieldTypes = [];
		$fieldBindTypes = [];
		$automaticDefault = [];
		$identityField = false;
		$defaultValues = [];
		$emptyStringValues = [];

		foreach ( $columns as $column ) {

			$fieldName = column->getName(),
				attributes[] = fieldName;

			/**
			 * To mark fields as primary keys
			 */
			if ( column->isPrimary() === true ) {
				$primaryKeys[] = fieldName;
			} else {
				$nonPrimaryKeys[] = fieldName;
			}

			/**
			 * To mark fields as numeric
			 */
			if ( column->isNumeric() === true ) {
				$numericTyped[fieldName] = true;
			}

			/**
			 * To mark fields as not null
			 */
			if ( column->isNotNull() === true ) {
				$notNull[] = fieldName;
			}

			/**
			 * To mark fields as identity columns
			 */
			if ( column->isAutoIncrement() === true ) {
				$identityField = fieldName;
			}

			/**
			 * To get the internal types
			 */
			$fieldTypes[fieldName] = column->getType();

			/**
			 * To mark how the fields must be escaped
			 */
			$fieldBindTypes[fieldName] = column->getBindType();

			/**
			 * If column has default value or column is nullable and default value is null
			 */
			$defaultValue = column->getDefault();
			if ( defaultValue !== null || column->isNotNull() === false ) {
				if ( !column->isAutoIncrement() ) {
					$defaultValues[fieldName] = defaultValue;
				}
			}
		}

		/**
		 * Create an array using the MODELS_* constants as indexes
		 */
		return [
			MetaData::MODELS_ATTRIBUTES               : attributes,
			MetaData::MODELS_PRIMARY_KEY              : primaryKeys,
			MetaData::MODELS_NON_PRIMARY_KEY          : nonPrimaryKeys,
			MetaData::MODELS_NOT_NULL                 : notNull,
			MetaData::MODELS_DATA_TYPES               : fieldTypes,
			MetaData::MODELS_DATA_TYPES_NUMERIC       : numericTyped,
			MetaData::MODELS_IDENTITY_COLUMN          : identityField,
			MetaData::MODELS_DATA_TYPES_BIND          : fieldBindTypes,
			MetaData::MODELS_AUTOMATIC_DEFAULT_INSERT : automaticDefault,
			MetaData::MODELS_AUTOMATIC_DEFAULT_UPDATE : automaticDefault,
			MetaData::MODELS_DEFAULT_VALUES           : defaultValues,
			MetaData::MODELS_EMPTY_STRING_VALUES      : emptyStringValues
		];
    }

    /***
	 * Read the model's column map, this can't be inferred
	 **/
    public final function getColumnMaps($model , $dependencyInjector ) {

		$orderedColumnMap = null;
		$reversedColumnMap = null;

		/**
		 * Check for ( a columnMap() method on the model
		 */
		if ( method_exists(model, "columnMap") ) {

			$userColumnMap = model->{"columnMap"}();
			if ( gettype($userColumnMap) != "array" ) {
				throw new Exception("columnMap() not returned an array");
			}

			$reversedColumnMap = [], orderedColumnMap = userColumnMap;
			foreach ( name, $userColumnMap as $userName ) {
				$reversedColumnMap[userName] = name;
			}
		}

		/**
		 * Store the column map
		 */
		return [orderedColumnMap, reversedColumnMap];
    }

}