<?php
/**
 * Drop this class into you CodeIgniter application/libraries folder to automatically provide REST
 * routing to your application.
 *
 * This looks for a config/rest.php file that contains a list of controllers that you want to make
 * available via REST. See that file for a full description of how it works.
 *
 * As an aside, this class provides a couple other nuggets: it makes url's case insensitive, and
 * it provides a way for you to expose other web services only when the incoming request is
 * of a certain method. For example, GET methods should not have side-effects, POST can, so you
 * can make your web services more clear if you use those semantics. (even outside of REST)
 *
 * Keep in mind that using this Router will AUTOMATICALLY CHANGE YOUR CONFIG FOR THE FOLLOWING
 *
 * $config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-\?\=\&';
 * $config['uri_protocol']	= "REQUEST_URI";
 *
 *
 *
 */
class MY_Router extends CI_Router {
	private $formats;
	public $key;

	function MY_Router() {
		$this->config =& load_class('Config');
		//fix the config
		$this->config->set_item('permitted_uri_chars', 'a-z 0-9~%.:_\-\?=&\*');
		if ($this->config->item('uri_protocol') == 'AUTO') {
			$_GET = array();
		}

		// REST accepted formats
		$this->formats = $this->config->item('REST_formats');

		// Check for the KEY
		$this->needKey = $this->config->item('REST_key');

		parent::CI_Router();
	}

	/**
	 * used to curry the parameters sent to your REST methods
	 *
	 * @param array $segments
	 * @param string $type (put, post, get, delete)
	 */
	function _set_rest_request($segments = array(), $type) {
		parent::_set_request($segments);
		$type = strtolower($type);

		//this is our chance to add arguments
		//for post/put lets provide the raw post
		//data as an extra parameter

		if ($type == 'post' || $type == 'put') {
			$this->uri->rsegments[] = file_get_contents("php://input");
		} else if ($type == 'get') {
			//if there is an '=' in the final segment, then this is a url-encoded query string
			//query, lets parse it
			$seg = $this->uri->rsegments[count($this->uri->rsegments)-1];
			if (preg_match('/=/', $seg) && preg_match('/\?/', $_SERVER['REQUEST_URI'])) {
				parse_str($seg, $params);
				$this->uri->rsegments[count($this->uri->rsegments)-1] = $params;
			}
		}

		$this->format = $this->parse_format( $this->uri->rsegments );
	}

	/**
	 * detect the requested format
	 */
	function parse_format( $seg ){
		if( in_array( $seg[1], array('findAll', 'findById') ) == TRUE ){
			$format = array_pop( $seg );

			return in_array( strtolower( $format ), $this->formats )
				? $format : DEFAULT_REST_FORMAT;
		} else {
			return FALSE;
		}
	}

	/**
	 * detect the API Key
	 */
	function parse_key( $uri ){
		$parts = explode( '?', $uri );

		if( $this->needKey ){
			// TODO: caso venha usar key no POST / PUT / DELETE tratar aqui ;)
			if( isset( $parts[1] ) ){
				parse_str( $parts[1], $param );

				if( ! isset( $param['key'] ) || ! preg_match('/[a-z0-9]{32}/i', $param['key']) ){
					show_error('Key not found or invalid!', 401);
				}

				$this->key = $param['key'];
			} else {
				show_error('Key not found or invalid!', 401);
			}
		}

		return $parts[0];
	}

	/**
	 * reads the rest.php file and sets up routing as appropriate
	 *
	 */
	function setupRestRouting() {
		define('DEFAULT_REST_METHODS', 'DEFAULT_REST_METHODS');
		define('DEFAULT_REST_FORMAT', 'json');

		$defaultRestMethods = array(
			'find' => 'find',
			'findById' => 'findById',
			'update' => 'update',
			'delete' => 'delete',
			'add' => 'add',
			'findAll' => 'findAll'
		);

		//load the rest config
		@include(APPPATH.'config' . DIRECTORY_SEPARATOR .'rest'. EXT);
		$rest = ( ! isset($rest) OR ! is_array($rest)) ? array() : $rest;

		// format the REST formats
		$formats = implode( "|", $this->formats );

		foreach($rest as $controller => $methods) {
			if ($methods == DEFAULT_REST_METHODS) {
				$methods = $defaultRestMethods;
			}
			$controller = strtolower($controller);

			if (isset($methods['findById']) && $methods['findById']) {
				$route[$controller . '/(:num)']['GET'] = $controller . '/' . $methods['findById'] . '/$1';
				$route[$controller . '/(:num)\.('. $formats .')']['GET'] = $controller . '/' . $methods['findById'] . '/$1/$2';
			}
			if (isset($methods['update']) && $methods['update']) {
				$route[$controller . '/(:num)']['POST'] = $controller . '/' . $methods['update'] . '/$1';
				$route[$controller . '/(:num)']['PUT'] = $controller . '/' . $methods['update'] . '/$1';
			}
			if (isset($methods['delete']) && $methods['delete']) {
				$route[$controller . '/(:num)']['DELETE'] = $controller . '/' . $methods['delete'] . '/$1';
			}
			if (isset($methods['findAll']) && $methods['findAll']) {
				$route[$controller]['GET'] = $controller . '/' . $methods['findAll'];
				$route[$controller . '\.('. $formats .')']['GET'] = $controller . '/' . $methods['findAll'] . '/$1';
			}
			if (isset($methods['add']) && $methods['add']) {
				$route[$controller]['POST'] = $controller . '/' . $methods['add'];
			}
			//default for extra methods
			$route[$controller . '/(:any)'] = $controller . '/$1';
		}

		$this->routes = array_merge($this->routes, $route);

	}

	/**
	 * override _set_routing to allow us to setup our REST routing
	 * before we parse the routs
	 *
	 */
	function _set_routing() {
		// Are query strings enabled in the config file?
		// If so, we're done since segment based URIs are not used with query strings.
		if ($this->config->item('enable_query_strings') === TRUE AND isset($_GET[$this->config->item('controller_trigger')]))
		{
			$this->set_class(trim($this->uri->_filter_uri($_GET[$this->config->item('controller_trigger')])));

			if (isset($_GET[$this->config->item('function_trigger')]))
			{
				$this->set_method(trim($this->uri->_filter_uri($_GET[$this->config->item('function_trigger')])));
			}

			return;
		}

		// Load the routes.php file.
		@include(APPPATH.'config/routes'.EXT);
		$this->routes = ( ! isset($route) OR ! is_array($route)) ? array() : $route;
		unset($route);
		$this->setupRestRouting();
		// Set the default controller so we can display it in the event
		// the URI doesn't correlated to a valid controller.
		$this->default_controller = ( ! isset($this->routes['default_controller']) OR $this->routes['default_controller'] == '') ? FALSE : strtolower($this->routes['default_controller']);

		// Fetch the complete URI string
		$this->uri->_fetch_uri_string();

		// Is there a URI string? If not, the default controller specified in the "routes" file will be shown.
		if ($this->uri->uri_string == '')
		{
			if ($this->default_controller === FALSE)
			{
				show_error("Unable to determine what should be displayed. A default route has not been specified in the routing file.");
			}

			$this->set_class($this->default_controller);
			$this->set_method('index');
			$this->_set_request(array($this->default_controller, 'index'));

			// re-index the routed segments array so it starts with 1 rather than 0
			$this->uri->_reindex_segments();

			log_message('debug', "No URI present. Default controller set.");
			return;
		}
		unset($this->routes['default_controller']);

		// Do we need to remove the URL suffix?
		$this->uri->_remove_url_suffix();

		// Compile the segments into an array
		$this->uri->_explode_segments();

		// Parse any custom routing that may exist
		$this->_parse_routes();

		// Re-index the segment array so that it starts with 1 rather than 0
		$this->uri->_reindex_segments();

	}


	/**
	 * the meat of REST (and all) routing. if regular routing, this is the same as _parse_requests
	 * but this adds the REST capable routing, calls _set_rest_request instead of _set_request
	 * when appropriate to allow currying of params, and, as a bonus, builds in case-insenitivity
	 * so that the url typed into the browser can be of any case without any problems
	 *
	 */
   function _parse_routes()
   {

      // Do we even have any custom routing to deal with?
      // There is a default scaffolding trigger, so we'll look just for 1
      if (count($this->routes) == 1)
      {
         $this->_set_request($this->uri->segments);
         return;
      }

      // Turn the segment array into a URI string
      $uri = strtolower(implode('/', $this->uri->segments));

      // REST key
      $uri = $this->parse_key( $uri );

      // Is there a literal match?  If so we're done
      if (isset($this->routes[$uri]))
      {
         if (is_array($this->routes[$uri])) {
            //loop through the options and see if we find a match
            foreach ($this->routes[$uri] as $method => $route) {
                  foreach ($this->routes[$uri] as  $method => $route) {
                     if (strtolower($method) == strtolower($_SERVER['REQUEST_METHOD'])) {
                        $this->_set_rest_request(explode('/', $route), strtolower($_SERVER['REQUEST_METHOD']));
                        return;
                     }
                  }
            }
         }

         $this->_set_request(explode('/', $this->routes[$uri]));
         return;
      }

      $restRequest = false;
      // Loop through the route array looking for wild-cards
      foreach ($this->routes as $key => $val)
      {
         // Convert wild-cards to RegEx
         $key = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $key));
         // Does the RegEx match?
         if (preg_match('#^'.$key.'$#i', $uri))
         {
            if (is_array($val)) {
               //loop through the options and see if we find a match
               foreach ($val as  $method => $route) {
                  if (strtolower($method) == strtolower($_SERVER['REQUEST_METHOD'])) {
                     $val = $route;
                     $restRequest = strtolower($_SERVER['REQUEST_METHOD']);
                     break;
                  }
               }
            }
            // Do we have a back-reference?
            if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE)
            {
               $val = preg_replace('#^'.$key.'$#', $val, $uri);
            }

            if ($restRequest) {
            	$this->_set_rest_request(explode('/', $val), $restRequest);
            } else {
	            $this->_set_request(explode('/', $val));
            }
            return;
         }
      }

      // If we got this far it means we didn't encounter a
      // matching route so we'll set the site default route
      $this->_set_request($this->uri->segments);
   }
}
