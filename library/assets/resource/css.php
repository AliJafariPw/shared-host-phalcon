<?php


namespace Phalcon\Assets\Resource;

use Phalcon\Assets\Resource as ResourceBase;


/***
 * Phalcon\Assets\Resource\Css
 *
 * Represents CSS resources
 **/

class Css extends ResourceBase {

    /***
	 * Phalcon\Assets\Resource\Css
	 *
	 * @param string path
	 * @param boolean local
	 * @param boolean filter
	 * @param array attributes
	 **/
    public function __construct($path , $local  = true , $filter  = true , $attributes  = null ) {
		parent::__construct("css", path, local, filter, attributes);
    }

}