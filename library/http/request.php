<?php


namespace Phalcon\Http;

use Phalcon\DiInterface;
use Phalcon\FilterInterface;
use Phalcon\Http\Request\File;
use Phalcon\Http\Request\Exception;
use Phalcon\Di\InjectionAwareInterface;


/***
 * Phalcon\Http\Request
 *
 * Encapsulates request information for easy and secure access from application controllers.
 *
 * The request object is a simple value object that is passed between the dispatcher and controller classes.
 * It packages the HTTP request environment.
 *
 *<code>
 * use Phalcon\Http\Request;
 *
 * $request = new Request();
 *
 * if ($request->isPost() && $request->isAjax()) {
 *     echo "Request was made using POST and AJAX";
 * }
 *
 * $request->getServer("HTTP_HOST"); // Retrieve SERVER variables
 * $request->getMethod();            // GET, POST, PUT, DELETE, HEAD, OPTIONS, PATCH, PURGE, TRACE, CONNECT
 * $request->getLanguages();         // An array of languages the client accepts
 *</code>
 **/

class Request {

    protected $_dependencyInjector;

    protected $_rawBody;

    protected $_filter;

    protected $_putCache;

    protected $_httpMethodParameterOverride;

    protected $_strictHostCheck;

    /***
	 * Sets the dependency injector
	 **/
    public function setDI($dependencyInjector ) {
		$this->_dependencyInjector = dependencyInjector;
    }

    /***
	 * Returns the internal dependency injector
	 **/
    public function getDI() {
		return $this->_dependencyInjector;
    }

    /***
	 * Gets a variable from the $_REQUEST superglobal applying filters if needed.
	 * If no parameters are given the $_REQUEST superglobal is returned
	 *
	 *<code>
	 * // Returns value from $_REQUEST["user_email"] without sanitizing
	 * $userEmail = $request->get("user_email");
	 *
	 * // Returns value from $_REQUEST["user_email"] with sanitizing
	 * $userEmail = $request->get("user_email", "email");
	 *</code>
	 **/
    public function get($name  = null , $filters  = null , $defaultValue  = null , $notAllowEmpty  = false , $noRecursive  = false ) {
		return $this->getHelper(_REQUEST, name, filters, defaultValue, notAllowEmpty, noRecursive);
    }

    /***
	 * Gets a variable from the $_POST superglobal applying filters if needed
	 * If no parameters are given the $_POST superglobal is returned
	 *
	 *<code>
	 * // Returns value from $_POST["user_email"] without sanitizing
	 * $userEmail = $request->getPost("user_email");
	 *
	 * // Returns value from $_POST["user_email"] with sanitizing
	 * $userEmail = $request->getPost("user_email", "email");
	 *</code>
	 **/
    public function getPost($name  = null , $filters  = null , $defaultValue  = null , $notAllowEmpty  = false , $noRecursive  = false ) {
		return $this->getHelper(_POST, name, filters, defaultValue, notAllowEmpty, noRecursive);
    }

    /***
	 * Gets a variable from put request
	 *
	 *<code>
	 * // Returns value from $_PUT["user_email"] without sanitizing
	 * $userEmail = $request->getPut("user_email");
	 *
	 * // Returns value from $_PUT["user_email"] with sanitizing
	 * $userEmail = $request->getPut("user_email", "email");
	 *</code>
	 **/
    public function getPut($name  = null , $filters  = null , $defaultValue  = null , $notAllowEmpty  = false , $noRecursive  = false ) {

		$put = $this->_putCache;

		if ( gettype($put) != "array" ) {
			$put = [];
			parse_str(this->getRawBody(), put);

			$this->_putCache = put;
		}

		return $this->getHelper(put, name, filters, defaultValue, notAllowEmpty, noRecursive);
    }

    /***
	 * Gets variable from $_GET superglobal applying filters if needed
	 * If no parameters are given the $_GET superglobal is returned
	 *
	 *<code>
	 * // Returns value from $_GET["id"] without sanitizing
	 * $id = $request->getQuery("id");
	 *
	 * // Returns value from $_GET["id"] with sanitizing
	 * $id = $request->getQuery("id", "int");
	 *
	 * // Returns value from $_GET["id"] with a default value
	 * $id = $request->getQuery("id", null, 150);
	 *</code>
	 **/
    public function getQuery($name  = null , $filters  = null , $defaultValue  = null , $notAllowEmpty  = false , $noRecursive  = false ) {
		return $this->getHelper(_GET, name, filters, defaultValue, notAllowEmpty, noRecursive);
    }

    /***
	 * Helper to get data from superglobals, applying filters if needed.
	 * If no parameters are given the superglobal is returned.
	 **/
    protected final function getHelper($source , $name  = null , $filters  = null , $defaultValue  = null , $notAllowEmpty  = false , $noRecursive  = false ) {

		if ( name === null ) {
			return source;
		}

		if ( !fetch value, source[name] ) {
			return defaultValue;
		}

		if ( filters !== null ) {
			$filter = $this->_filter;
			if ( gettype($filter) != "object" ) {
				$dependencyInjector = <DiInterface> $this->_dependencyInjector;
				if ( gettype($dependencyInjector) != "object" ) {
					throw new Exception("A dependency injection object is required to access the 'filter' service");
				}
				$filter = <FilterInterface> dependencyInjector->getShared("filter");
				$this->_filter = filter;
			}

			$value = filter->sanitize(value, filters, noRecursive);
		}

		if ( empty value && notAllowEmpty === true ) {
			return defaultValue;
		}

		return value;
    }

    /***
	 * Gets variable from $_SERVER superglobal
	 **/
    public function getServer($name ) {

		if ( fetch serverValue, _SERVER[name] ) {
			return serverValue;
		}
		return null;
    }

    /***
	 * Checks whether $_REQUEST superglobal has certain index
	 **/
    public function has($name ) {
		return isset _REQUEST[name];
    }

    /***
	 * Checks whether $_POST superglobal has certain index
	 **/
    public function hasPost($name ) {
		return isset _POST[name];
    }

    /***
	 * Checks whether the PUT data has certain index
	 **/
    public function hasPut($name ) {

		$put = $this->getPut();

		return isset put[name];
    }

    /***
	 * Checks whether $_GET superglobal has certain index
	 **/
    public function hasQuery($name ) {
		return isset _GET[name];
    }

    /***
	 * Checks whether $_SERVER superglobal has certain index
	 **/
    public final function hasServer($name ) {
		return isset _SERVER[name];
    }

    /***
     * Checks whether headers has certain index
     **/
    public final function hasHeader($header ) {
        var name;

        $name = strtoupper(strtr(header, "-", "_"));

        if ( isset($_SERVER[name]) ) {
            return true;
        }

        if ( isset _SERVER["HTTP_" . name] ) {
            return true;
        }

        return false;
    }

    /***
	 * Gets HTTP header from request data
	 **/
    public final function getHeader($header ) {

		$name = strtoupper(strtr(header, "-", "_"));

		if ( fetch value, _SERVER[name] ) {
			return value;
		}

		if ( fetch value, _SERVER["HTTP_" . name] ) {
			return value;
		}

		return "";
    }

    /***
	 * Gets HTTP schema (http/https)
	 **/
    public function getScheme() {

		$https = $this->getServer("HTTPS");
		if ( https ) {
			if ( https == "off" ) {
				$scheme = "http";
			} else {
				$scheme = "https";
			}
		} else {
			$scheme = "http";
		}
		return scheme;
    }

    /***
	 * Checks whether request has been made using ajax
	 **/
    public function isAjax() {
		return isset _SERVER["HTTP_X_REQUESTED_WITH"] && _SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest";
    }

    /***
	 * Checks whether request has been made using SOAP
	 **/
    public function isSoap() {

		if ( isset _SERVER["HTTP_SOAPACTION"] ) {
			return true;
		} else {
			$contentType = $this->getContentType();
			if ( !empty contentType ) {
				return memstr(contentType, "application/soap+xml");
			}
		}
		return false;
    }

    /***
	 * Alias of isSoap(). It will be deprecated in future versions
	 **/
    public function isSoapRequested() {
		return $this->isSoap();
    }

    /***
	 * Checks whether request has been made using any secure layer
	 **/
    public function isSecure() {
		return $this->getScheme() === "https";
    }

    /***
	 * Alias of isSecure(). It will be deprecated in future versions
	 **/
    public function isSecureRequest() {
		return $this->isSecure();
    }

    /***
	 * Gets HTTP raw request body
	 **/
    public function getRawBody() {

		$rawBody = $this->_rawBody;
		if ( empty rawBody ) {

			$contents = file_get_contents("php://input");

			/**
			 * We need store the read raw body because it can't be read again
			 */
			$this->_rawBody = contents;
			return contents;
		}
		return rawBody;
    }

    /***
	 * Gets decoded JSON HTTP raw request body
	 **/
    public function getJsonRawBody($associative  = false ) {

		$rawBody = $this->getRawBody();
		if ( gettype($rawBody) != "string" ) {
			return false;
		}

		return json_decode(rawBody, associative);
    }

    /***
	 * Gets active server address IP
	 **/
    public function getServerAddress() {

		if ( fetch serverAddr, _SERVER["SERVER_ADDR"] ) {
			return serverAddr;
		}
		return gethostbyname("localhost");
    }

    /***
	 * Gets active server name
	 **/
    public function getServerName() {

		if ( fetch serverName, _SERVER["SERVER_NAME"] ) {
			return serverName;
		}

		return "localhost";
    }

    /***
	 * Gets host name used by the request.
	 *
	 * `Request::getHttpHost` trying to find host name in following order:
	 *
	 * - `$_SERVER["HTTP_HOST"]`
	 * - `$_SERVER["SERVER_NAME"]`
	 * - `$_SERVER["SERVER_ADDR"]`
	 *
	 * Optionally `Request::getHttpHost` validates and clean host name.
	 * The `Request::$_strictHostCheck` can be used to validate host name.
	 *
	 * Note: validation and cleaning have a negative performance impact because
	 * they use regular expressions.
	 *
	 * <code>
	 * use Phalcon\Http\Request;
	 *
	 * $request = new Request;
	 *
	 * $_SERVER["HTTP_HOST"] = "example.com";
	 * $request->getHttpHost(); // example.com
	 *
	 * $_SERVER["HTTP_HOST"] = "example.com:8080";
	 * $request->getHttpHost(); // example.com:8080
	 *
	 * $request->setStrictHostCheck(true);
	 * $_SERVER["HTTP_HOST"] = "ex=am~ple.com";
	 * $request->getHttpHost(); // UnexpectedValueException
	 *
	 * $_SERVER["HTTP_HOST"] = "ExAmPlE.com";
	 * $request->getHttpHost(); // example.com
	 * </code>
	 **/
    public function getHttpHost() {

		$strict = $this->_strictHostCheck;

		/**
		 * Get the server name from $_SERVER["HTTP_HOST"]
		 */
		$host = $this->getServer("HTTP_HOST");
		if ( !host ) {

			/**
			 * Get the server name from $_SERVER["SERVER_NAME"]
			 */
			$host = $this->getServer("SERVER_NAME");
			if ( !host ) {
				/**
				 * Get the server address from $_SERVER["SERVER_ADDR"]
				 */
				$host = $this->getServer("SERVER_ADDR");
			}
		}

		if ( host && strict ) {
			/**
			 * Cleanup. Force lowercase as per RFC 952/2181
			 */
			$host = strtolower(trim(host));
			if ( memstr(host, ":") ) {
				$host = preg_replace("/:[[:digit:]]+$/", "", host);
			}

			/**
			 * Host may contain only the ASCII letters 'a' through 'z' (in a case-insensitive manner),
			 * the digits '0' through '9', and the hyphen ('-') as per RFC 952/2181
			 */
			if ( "" !== preg_replace("/[a-z0-9-]+\.?/", "", host) ) {
				throw new \UnexpectedValueException("Invalid host " . host);
			}
		}

		return (string) host;
    }

    /***
	 * Sets if the `Request::getHttpHost` method must be use strict validation of host name or not
	 **/
    public function setStrictHostCheck($flag  = true ) {
		$this->_strictHostCheck = flag;

		return this;
    }

    /***
	 * Checks if the `Request::getHttpHost` method will be use strict validation of host name or not
	 **/
    public function isStrictHostCheck() {
		return $this->_strictHostCheck;
    }

    /***
	 * Gets information about the port on which the request is made.
	 **/
    public function getPort() {

		/**
		 * Get the server name from $_SERVER["HTTP_HOST"]
		 */
		$host = $this->getServer("HTTP_HOST");
		if ( host ) {
			if ( memstr(host, ":") ) {
				$pos = strrpos(host, ":");

				if ( false !== pos ) {
					return (int) substr(host, pos + 1);
				}
			}

			return "https" === $this->getScheme() ? 443 : 80;
		}

		return (int) $this->getServer("SERVER_PORT");
    }

    /***
	 * Gets HTTP URI which request has been made
	 **/
    public final function getURI() {

		if ( fetch requestURI, _SERVER["REQUEST_URI"] ) {
			return requestURI;
		}

		return "";
    }

    /***
	 * Gets most possible client IPv4 Address. This method searches in
	 * $_SERVER["REMOTE_ADDR"] and optionally in $_SERVER["HTTP_X_FORWARDED_FOR"]
	 **/
    public function getClientAddress($trustForwardedHeader  = false ) {

		/**
		 * Proxies uses this IP
		 */
		if ( trustForwardedHeader ) {
			if ( address === null ) {
			}
		}

		if ( address === null ) {
		}

		if ( gettype($address) == "string" ) {
			if ( memstr(address, ",") ) {
				/**
				 * The client address has multiples parts, only return the first part
				 */
				return explode(",", address)[0];
			}
			return address;
		}

		return false;
    }

    /***
	 * Gets HTTP method which request has been made
	 *
	 * If the X-HTTP-Method-Override header is set, and if the method is a POST,
	 * then it is used to determine the "real" intended HTTP method.
	 *
	 * The _method request parameter can also be used to determine the HTTP method,
	 * but only if setHttpMethodParameterOverride(true) has been called.
	 *
	 * The method is always an uppercased string.
	 **/
    public final function getMethod() {
		string returnMethod = "";

		if ( likely fetch requestMethod, _SERVER["REQUEST_METHOD"] ) {
			$returnMethod = strtoupper(requestMethod);
		} else {
			return "GET";
		}

		if ( "POST" === returnMethod ) {
			$overridedMethod = $this->getHeader("X-HTTP-METHOD-OVERRIDE");
			if ( !empty overridedMethod ) {
				$returnMethod = strtoupper(overridedMethod);
			} elseif ( $this->_httpMethodParameterOverride ) {
				if ( fetch spoofedMethod, _REQUEST["_method"] ) {
					$returnMethod = strtoupper(spoofedMethod);
				}
			}
		}

		if ( !this->isValidHttpMethod(returnMethod) ) {
			return "GET";
		}

		return returnMethod;
    }

    /***
	 * Gets HTTP user agent used to made the request
	 **/
    public function getUserAgent() {

		if ( fetch userAgent, _SERVER["HTTP_USER_AGENT"] ) {
			return userAgent;
		}
		return "";
    }

    /***
	 * Checks if a method is a valid HTTP method
	 **/
    public function isValidHttpMethod($method ) {
		switch strtoupper(method) {
			case "GET":
			case "POST":
			case "PUT":
			case "DELETE":
			case "HEAD":
			case "OPTIONS":
			case "PATCH":
			case "PURGE": // Squid and Varnish support
			case "TRACE":
			case "CONNECT":
				return true;
		}

		return false;
    }

    /***
	 * Check if HTTP method match any of the passed methods
	 * When strict is true it checks if validated methods are real HTTP methods
	 **/
    public function isMethod($methods , $strict  = false ) {

		$httpMethod = $this->getMethod();

		if ( gettype($methods) == "string" ) {
			if ( strict && !this->isValidHttpMethod(methods) ) {
				throw new Exception("Invalid HTTP method: " . methods);
			}
			return methods == httpMethod;
		}

		if ( gettype($methods) == "array" ) {
			foreach ( $methods as $method ) {
				if ( $this->isMethod(method, strict) ) {
					return true;
				}
			}

			return false;
		}

		if ( strict ) {
			throw new Exception("Invalid HTTP method: non-string");
		}

		return false;
    }

    /***
	 * Checks whether HTTP method is POST. if _SERVER["REQUEST_METHOD"]==="POST"
	 **/
    public function isPost() {
		return $this->getMethod() === "POST";
    }

    /***
	 * Checks whether HTTP method is GET. if _SERVER["REQUEST_METHOD"]==="GET"
	 **/
    public function isGet() {
		return $this->getMethod() === "GET";
    }

    /***
	 * Checks whether HTTP method is PUT. if _SERVER["REQUEST_METHOD"]==="PUT"
	 **/
    public function isPut() {
		return $this->getMethod() === "PUT";
    }

    /***
	 * Checks whether HTTP method is PATCH. if _SERVER["REQUEST_METHOD"]==="PATCH"
	 **/
    public function isPatch() {
		return $this->getMethod() === "PATCH";
    }

    /***
	 * Checks whether HTTP method is HEAD. if _SERVER["REQUEST_METHOD"]==="HEAD"
	 **/
    public function isHead() {
		return $this->getMethod() === "HEAD";
    }

    /***
	 * Checks whether HTTP method is DELETE. if _SERVER["REQUEST_METHOD"]==="DELETE"
	 **/
    public function isDelete() {
		return $this->getMethod() === "DELETE";
    }

    /***
	 * Checks whether HTTP method is OPTIONS. if _SERVER["REQUEST_METHOD"]==="OPTIONS"
	 **/
    public function isOptions() {
		return $this->getMethod() === "OPTIONS";
    }

    /***
	 * Checks whether HTTP method is PURGE (Squid and Varnish support). if _SERVER["REQUEST_METHOD"]==="PURGE"
	 **/
    public function isPurge() {
		return $this->getMethod() === "PURGE";
    }

    /***
	 * Checks whether HTTP method is TRACE. if _SERVER["REQUEST_METHOD"]==="TRACE"
	 **/
    public function isTrace() {
		return $this->getMethod() === "TRACE";
    }

    /***
	 * Checks whether HTTP method is CONNECT. if _SERVER["REQUEST_METHOD"]==="CONNECT"
	 **/
    public function isConnect() {
		return $this->getMethod() === "CONNECT";
    }

    /***
	 * Checks whether request include attached files
	 **/
    public function hasFiles($onlySuccessful  = false ) {
		int numberFiles = 0;

		$files = _FILES;

		if ( gettype($files) != "array" ) {
			return 0;
		}

		foreach ( $files as $file ) {
			if ( fetch error, file["error"] ) {

				if ( gettype($error) != "array" ) {
					if ( !error || !onlySuccessful ) {
						$numberFiles++;
					}
				}

				if ( gettype($error) == "array" ) {
					$numberFiles += $this->hasFileHelper(error, onlySuccessful);
				}
			}
		}

		return numberFiles;
    }

    /***
	 * Recursively counts file in an array of files
	 **/
    protected final function hasFileHelper($data , $onlySuccessful ) {
		int numberFiles = 0;

		if ( gettype($data) != "array" ) {
			return 1;
		}

		foreach ( $data as $value ) {
			if ( gettype($value) != "array" ) {
				if ( !value || !onlySuccessful ) {
					$numberFiles++;
				}
			}

			if ( gettype($value) == "array" ) {
				$numberFiles += $this->hasFileHelper(value, onlySuccessful);
			}
		}

		return numberFiles;
    }

    /***
	 * Gets attached files as Phalcon\Http\Request\File instances
	 **/
    public function getUploadedFiles($onlySuccessful  = false ) {
		array files = [];

		$superFiles = _FILES;

		if ( count(superFiles) > 0 ) {

			foreach ( prefix, $superFiles as $input ) {
				if ( typeof input["name"] == "array" ) {
					$smoothInput = $this->smoothFiles(
						input["name"],
						input["type"],
						input["tmp_name"],
						input["size"],
						input["error"],
						prefix
					);

					foreach ( $smoothInput as $file ) {
						if ( onlySuccessful == false || file["error"] == UPLOAD_ERR_OK ) {
							$dataFile = [
								"name": file["name"],
								"type": file["type"],
								"tmp_name": file["tmp_name"],
								"size": file["size"],
								"error": file["error"]
							];

							$files[] = new File(dataFile, file["key"]);
						}
					}
				} else {
					if ( onlySuccessful == false || input["error"] == UPLOAD_ERR_OK ) {
						$files[] = new File(input, prefix);
					}
				}
			}
		}

		return files;
    }

    /***
	 * Smooth out $_FILES to have plain array with all files uploaded
	 **/
    protected final function smoothFiles($names , $types , $tmp_names , $sizes , $errors , $prefix ) {

		$files = [];

		foreach ( idx, $names as $name ) {
			$p = prefix . "." . idx;

			if ( gettype($name) == "string" ) {

				$files[] = [
					"name": name,
					"type": types[idx],
					"tmp_name": tmp_names[idx],
					"size": sizes[idx],
					"error": errors[idx],
					"key": p
				];
			}

			if ( gettype($name) == "array" ) {
				$parentFiles = $this->smoothFiles(
					names[idx],
					types[idx],
					tmp_names[idx],
					sizes[idx],
					errors[idx],
					p
				);

				foreach ( $parentFiles as $file ) {
					$files[] = file;
				}
			}
		}

		return files;
    }

    /***
	 * Returns the available headers in the request
	 *
	 * <code>
	 * $_SERVER = [
	 *     "PHP_AUTH_USER" => "phalcon",
	 *     "PHP_AUTH_PW"   => "secret",
	 * ];
	 *
	 * $headers = $request->getHeaders();
	 *
	 * echo $headers["Authorization"]; // Basic cGhhbGNvbjpzZWNyZXQ=
	 * </code>
	 **/
    public function getHeaders() {
		array headers, contentHeaders;

		$headers = [];
		$contentHeaders = ["CONTENT_TYPE": true, "CONTENT_LENGTH": true, "CONTENT_MD5": true];

		foreach ( name, $_SERVER as $value ) {
			if ( starts_with(name, "HTTP_") ) {
				$name = ucwords(strtolower(str_replace("_", " ", substr(name, 5)))),
					name = str_replace(" ", "-", name);
				$headers[name] = value;
			} elseif ( isset($contentHeaders[name]) ) {
				$name = ucwords(strtolower(str_replace("_", " ", name))),
					name = str_replace(" ", "-", name);
				$headers[name] = value;
			}
		}

		if ( isset _SERVER["PHP_AUTH_USER"] && isset _SERVER["PHP_AUTH_PW"] ) {
			$headers["Php-Auth-User"] = _SERVER["PHP_AUTH_USER"],
				headers["Php-Auth-Pw"] = _SERVER["PHP_AUTH_PW"];
		} else {
			if ( isset _SERVER["HTTP_AUTHORIZATION"] ) {
				$authHeader = _SERVER["HTTP_AUTHORIZATION"];
			} elseif ( isset _SERVER["REDIRECT_HTTP_AUTHORIZATION"] ) {
				$authHeader = _SERVER["REDIRECT_HTTP_AUTHORIZATION"];
			}

			if ( authHeader ) {
				if ( stripos(authHeader, "basic ") === 0 ) {
					$exploded = explode(":", base64_decode(substr(authHeader, 6)), 2);
					if ( count(exploded) == 2 ) {
						$headers["Php-Auth-User"] = exploded[0],
							headers["Php-Auth-Pw"]   = exploded[1];
					}
				} elseif ( stripos(authHeader, "digest ") === 0 && !fetch digest, _SERVER["PHP_AUTH_DIGEST"] ) {
					$headers["Php-Auth-Digest"] = authHeader;
				} elseif ( stripos(authHeader, "bearer ") === 0 ) {
					$headers["Authorization"] = authHeader;
				}
			}
		}

		if ( isset headers["Authorization"] ) {
			return headers;
        }

		if ( isset headers["Php-Auth-User"] ) {
			$headers["Authorization"] = "Basic " . base64_encode(headers["Php-Auth-User"] . ":" . headers["Php-Auth-Pw"]);
		} elseif ( fetch digest, headers["Php-Auth-Digest"] ) {
			$headers["Authorization"] = digest;
		}

		return headers;
    }

    /***
	 * Gets web page that refers active request. ie: http://www.google.com
	 **/
    public function getHTTPReferer() {
		if ( fetch httpReferer, _SERVER["HTTP_REFERER"] ) {
			return httpReferer;
		}
		return "";
    }

    /***
	 * Process a request header and return the one with best quality
	 **/
    protected final function _getBestQuality($qualityParts , $name ) {
		int i;
		double quality, acceptQuality;

		$i = 0,
			quality = 0.0,
			selectedName = "";

		foreach ( $qualityParts as $accept ) {
			if ( i == 0 ) {
				$quality = (double) accept["quality"],
					selectedName = accept[name];
			} else {
				$acceptQuality = (double) accept["quality"];
				if ( acceptQuality > quality ) {
					$quality = acceptQuality,
						selectedName = accept[name];
				}
			}
			$i++;
		}
		return selectedName;
    }

    /***
	 * Gets content type which request has been made
	 **/
    public function getContentType() {

		if ( fetch contentType, _SERVER["CONTENT_TYPE"] ) {
			return contentType;
		} else {
			/**
			 * @see https://bugs.php.net/bug.php?id=66606
			 */
			if ( fetch contentType, _SERVER["HTTP_CONTENT_TYPE"] ) {
				return contentType;
			}
		}

		return null;
    }

    /***
	 * Gets an array with mime/types and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT"]
	 **/
    public function getAcceptableContent() {
		return $this->_getQualityHeader("HTTP_ACCEPT", "accept");
    }

    /***
	 * Gets best mime/type accepted by the browser/client from _SERVER["HTTP_ACCEPT"]
	 **/
    public function getBestAccept() {
		return $this->_getBestQuality(this->getAcceptableContent(), "accept");
    }

    /***
	 * Gets a charsets array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]
	 **/
    public function getClientCharsets() {
		return $this->_getQualityHeader("HTTP_ACCEPT_CHARSET", "charset");
    }

    /***
	 * Gets best charset accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]
	 **/
    public function getBestCharset() {
		return $this->_getBestQuality(this->getClientCharsets(), "charset");
    }

    /***
	 * Gets languages array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]
	 **/
    public function getLanguages() {
		return $this->_getQualityHeader("HTTP_ACCEPT_LANGUAGE", "language");
    }

    /***
	 * Gets best language accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]
	 **/
    public function getBestLanguage() {
		return $this->_getBestQuality(this->getLanguages(), "language");
    }

    /***
	 * Gets auth info accepted by the browser/client from $_SERVER["PHP_AUTH_USER"]
	 **/
    public function getBasicAuth() {

		if ( isset _SERVER["PHP_AUTH_USER"] && isset _SERVER["PHP_AUTH_PW"] ) {
			$auth = [];
			$auth["username"] = _SERVER["PHP_AUTH_USER"];
			$auth["password"] = _SERVER["PHP_AUTH_PW"];
			return auth;
		}

		return null;
    }

    /***
	 * Gets auth info accepted by the browser/client from $_SERVER["PHP_AUTH_DIGEST"]
	 **/
    public function getDigestAuth() {
		array auth;

		$auth = [];
		if ( fetch digest, _SERVER["PHP_AUTH_DIGEST"] ) {
			$matches = [];
			if ( !preg_match_all("#(\\w+)=(['\"]?)([^'\" ,]+)\\2#", digest, matches, 2) ) {
				return auth;
			}
			if ( gettype($matches) == "array" ) {
				foreach ( $matches as $match ) {
					$auth[match[1]] = match[3];
				}
			}
		}

		return auth;
    }

    /***
	 * Process a request header and return an array of values with their qualities
	 **/
    protected final function _getQualityHeader($serverIndex , $name ) {

		$returnedParts = [];
		for ( part in preg_split("/,\\s*/", $this->getServer(serverIndex), -1, PREG_SPLIT_NO_EMPTY) ) {

			$headerParts = [];
			for ( headerPart in preg_split("/\s*;\s*/", trim(part), -1, PREG_SPLIT_NO_EMPTY) ) {
				if ( strpos(headerPart, "=") !== false ) {
					$split = explode("=", headerPart, 2);
					if ( split[0] === "q" ) {
						$headerParts["quality"] = (double) split[1];
					} else {
						$headerParts[split[0]] = split[1];
					}
				} else {
					$headerParts[name] = headerPart;
					$headerParts["quality"] = 1.0;
				}
			}

			$returnedParts[] = headerParts;
		}

		return returnedParts;
    }

}