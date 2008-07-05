<?php
/**
 * Abstract controller class whish is responsible for managing default behaviour of 
 * controller objects
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
define ("HOOK_PRE_ACTION",1);
define ("HOOK_POST_ACTION",2);
Abstract class controller
{
	/**
	 * contains all the parameter passed to controller via url rewrite and query string. for the following url structure
	 * http://path_to_orchid/controllert/action/param1/param2/param3
	 * you can access first paramater as $this->params[0] which is equal to "param1" , and $this->params[1]="param2"
	 *
	 * @var array
	 */
	private $params;

	/**
	 * internally used by dispatcher. when some call redirect() methid, this flag is set to the controller to redirect 
	 * and dispatcher redirect to it, keeping the request url same
	 *
	 * @var string
	 */
	public $redirectcontroller;

	/**
	 * internally used by dispatcher. when some call redirect() methid, this flag is set to the action to redirect 
	 * and dispatcher redirect to it, keeping the request url same
	 *
	 * @var string
	 */
	public $redirectaction;

	/**
	 * a very important flag. user can tell dispatcher to use view when an action finished executing, to use to render output. 
	 * if set to false, dispatcher will not use any view and output raw data from the controller. it is very helpful to echo
	 * some content rapidly for debugging purpose. default value is true
	 *
	 * @var boolean
	 */
	public $use_view=true;

	/**
	 * once set to false, dispatcher will not use the global/local layout to use to merge output from the view into the layout.
	 * for ajax request, you can explicitely set it to false. default value is true and in action in presence of a local or global
	 * template
	 *
	 * @var boolean
	 */
	public $use_layout=true;

	/**
	 * contains all the post parameter as a property of this std class. so if there is a post parameter named "author", you can 
	 * access it as $this->post->author
	 *
	 * @var object
	 */
	public $post;

	/**
	 * used to store the name of the template file, internally used by dispatcher to determine if there is any overridden template 
	 * file set by user. user can always override the default style of templating (like name of view file is same as the action) using
	 * $this->setView() method and passing a view file name to it, excluding the extension.
	 *
	 * @var string
	 */
	public $template;

	/**
	 * used to store the errors to pass to a error template. used by setError method. see the documentation of setError
	 *
	 * @var array
	 */
	private $errors;

	/**
	 * if set to true, dispatcher will use errorview instead of regular view to publish the error
	 *
	 * @var boolean
	 */
	public $error=false;

	/**
	 * list of methods in the current controller to call before executing current action. sort of a hook
	 *
	 * @var array
	 */
	public $pre_action_hooks=array();

	/**
	 * list of methods in the current controller to call after executing current action. sort of a hook
	 *
	 * @var array
	 */
	public $post_action_hooks=array();

	function __construct()
	{
		$this->errors = array();
		$this->pre_action_hooks=array();
		$this->post_action_hooks=array();
	}

	private function __get($var)
	{
		if ($var == "params")
		return $this->params;
		return loader::load($var);
	}

	/**
	 * internally used by dispatcher to set all the get and query variables to a controller. 
	 *
	 * @param array $params
	 */
	public function setParams($params)
	{
		$this->params = $params;
	}

	/**
	 * internally used by dispatcher to set post params
	 *
	 * @param unknown_type $post
	 */
	public function setPostParams($post)
	{
		$this->post = $post;
	}
	public function redirect($controller, $action="base", $params=array(), $postparams=array())
	{
		$this->redirectcontroller=$controller;
		$this->redirectaction=$action;
		if(!empty($params))
		$this->params = $params;
		if(!empty($postparams))
		$this->post= $postparams;
	}

	public function redirectUrl($controller, $action="base")
	{
		$baseurl = base::baseUrl();
		$url = $baseurl."/{$controller}/{$action}";
		header("location: {$url}");
		die();
	}
	public function redirecExternaltUrl($url)
	{
		header("location: {$url}");
		die();
	}
	public function setView($view)
	{
		$this->template = $view;
	}

	public function setError($errorMsg)
	{
		$this->errors[md5($errorMsg)]= $errorMsg;//to avoid storing multiple errors for many times, used this hash
		$this->error = true;
	}

	public function getError()
	{
		return $this->errors;
	}

	/**
	 * set a parameter to view scope
	 *
	 * @param string $key
	 * @param string $value
	 */
	function setViewParam($key,$value)
	{
		$this->view->set($key,$value);
	}

	/**
	 * set each element of the passed array to view scope
	 *
	 * @param associated array $params
	 */
	function setViewParams($params)
	{
		if(is_array($params))
		{
			foreach ($params as $key=>$value);
			$this->view->set($key, $value);
		}
	}

	function installHook($callback,$hookType=null)
	{
		if (HOOK_PRE_ACTION==$hookType)
		{
			$this->pre_action_hooks[$callback]=$callback;
		}
		else if (HOOK_POST_ACTION==$hookType)
		{
			$this->post_action_hooks[$callback]=$callback;
		}
	}

	public function getPreActionHooks()
	{
		return $this->pre_action_hooks;
	}

	public function getPostActionHooks()
	{
		return $this->post_action_hooks;
	}


	function base(){}
}
?>
