<?php


namespace Phalcon\Logger\Formatter;

use Phalcon\Logger\Formatter;


/***
 * Phalcon\Logger\Formatter\Json
 *
 * Formats messages using JSON encoding
 **/

class Json extends Formatter {

    /***
	 * Applies a format to a message before sent it to the internal log
	 *
	 * @param string message
	 * @param int type
	 * @param int timestamp
	 * @param array $context
	 * @return string
	 **/
    public function format($message , $type , $timestamp , $context  = null ) {
		if ( gettype($context) === "array" ) {
			$message = $this->interpolate(message, context);
		}

		return json_encode([
			"type": $this->getTypeString(type),
			"message": message,
			"timestamp": timestamp
		]).PHP_EOL;
    }

}