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

    }

    /***
	 * Read the model's column map, this can't be inferred
	 **/
    public final function getColumnMaps($model , $dependencyInjector ) {

    }

}