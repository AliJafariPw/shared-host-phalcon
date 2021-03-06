<?php


namespace Phalcon\Mvc\Micro;



/***
 * Phalcon\Mvc\Micro\Collection
 *
 * Groups Micro-Mvc handlers as controllers
 *
 *<code>
 * $app = new \Phalcon\Mvc\Micro();
 *
 * $collection = new Collection();
 *
 * $collection->setHandler(
 *     new PostsController()
 * );
 *
 * $collection->get("/posts/edit/{id}", "edit");
 *
 * $app->mount($collection);
 *</code>
 **/

class Collection {

    protected $_prefix;

    protected $_lazy;

    protected $_handler;

    protected $_handlers;

    /***
	 * Internal function to add a handler to the group
	 *
	 * @param string|array method
	 * @param string routePattern
	 * @param mixed handler
	 * @param string name
	 **/
    protected function _addMap($method , $routePattern , $handler , $name ) {
		$this->_handlers[] = [method, routePattern, handler, name];
    }

    /***
	 * Sets a prefix for all routes added to the collection
	 **/
    public function setPrefix($prefix ) {
		$this->_prefix = prefix;
		return this;
    }

    /***
	 * Returns the collection prefix if any
	 **/
    public function getPrefix() {
		return $this->_prefix;
    }

    /***
	 * Returns the registered handlers
	 *
	 * @return array
	 **/
    public function getHandlers() {
		return $this->_handlers;
    }

    /***
	 * Sets the main handler
	 *
	 * @param mixed handler
	 * @param boolean lazy
	 * @return \Phalcon\Mvc\Micro\Collection
	 **/
    public function setHandler($handler , $lazy  = false ) {
		$this->_handler = handler, $this->_lazy = lazy;
		return this;
    }

    /***
	 * Sets if the main handler must be lazy loaded
	 **/
    public function setLazy($lazy ) {
		$this->_lazy = lazy;
		return this;
    }

    /***
	 * Returns if the main handler must be lazy loaded
	 **/
    public function isLazy() {
		return $this->_lazy;
    }

    /***
	 * Returns the main handler
	 *
	 * @return mixed
	 **/
    public function getHandler() {
		return $this->_handler;
    }

    /***
	 * Maps a route to a handler
	 *
	 * @param  string routePattern
	 * @param  callable handler
	 * @param  string name
	 * @return \Phalcon\Mvc\Micro\Collection
	 **/
    public function map($routePattern , $handler , $name  = null ) {
		this->_addMap(null, routePattern, handler, name);
		return this;
    }

    /***
	 * Maps a route to a handler via methods
	 *
	 * @param  string routePattern
	 * @param  callable handler
	 * @param  string|array method
	 * @param  string name
	 * @return \Phalcon\Mvc\Micro\Collection
	 **/
    public function mapVia($routePattern , $handler , $method , $name  = null ) {
		this->_addMap(method, routePattern, handler, name);

		return this;
    }

    /***
	 * Maps a route to a handler that only matches if the HTTP method is GET
	 *
	 * @param  string routePattern
	 * @param  callable handler
	 * @param  string name
	 * @return \Phalcon\Mvc\Micro\Collection
	 **/
    public function get($routePattern , $handler , $name  = null ) {
		this->_addMap("GET", routePattern, handler, name);
		return this;
    }

    /***
	 * Maps a route to a handler that only matches if the HTTP method is POST
	 *
	 * @param  string routePattern
	 * @param  callable handler
	 * @param  string name
	 * @return \Phalcon\Mvc\Micro\Collection
	 **/
    public function post($routePattern , $handler , $name  = null ) {
		this->_addMap("POST", routePattern, handler, name);
		return this;
    }

    /***
	 * Maps a route to a handler that only matches if the HTTP method is PUT
	 *
	 * @param  string routePattern
	 * @param  callable handler
	 * @param  string name
	 * @return \Phalcon\Mvc\Micro\Collection
	 **/
    public function put($routePattern , $handler , $name  = null ) {
		this->_addMap("PUT", routePattern, handler, name);
		return this;
    }

    /***
	 * Maps a route to a handler that only matches if the HTTP method is PATCH
	 *
	 * @param  string routePattern
	 * @param  callable handler
	 * @param  string name
	 * @return \Phalcon\Mvc\Micro\Collection
	 **/
    public function patch($routePattern , $handler , $name  = null ) {
		this->_addMap("PATCH", routePattern, handler, name);
		return this;
    }

    /***
	 * Maps a route to a handler that only matches if the HTTP method is HEAD
	 *
	 * @param  string routePattern
	 * @param  callable handler
	 * @param  string name
	 * @return \Phalcon\Mvc\Micro\Collection
	 **/
    public function head($routePattern , $handler , $name  = null ) {
		this->_addMap("HEAD", routePattern, handler, name);
		return this;
    }

    /***
	 * Maps a route to a handler that only matches if the HTTP method is DELETE
	 *
	 * @param  string   routePattern
	 * @param  callable handler
	 * @param  string name
	 * @return \Phalcon\Mvc\Micro\Collection
	 **/
    public function delete($routePattern , $handler , $name  = null ) {
		this->_addMap("DELETE", routePattern, handler, name);
		return this;
    }

    /***
	 * Maps a route to a handler that only matches if the HTTP method is OPTIONS
	 *
	 * @param string routePattern
	 * @param callable handler
	 * @return \Phalcon\Mvc\Micro\Collection
	 **/
    public function options($routePattern , $handler , $name  = null ) {
		this->_addMap("OPTIONS", routePattern, handler, name);
		return this;
    }

}