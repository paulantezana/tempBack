<?php

class Router
{
	public $uri;
	public $controller;
	public $method;
	public $param;

	public function __construct()
	{
		$this->setUri();
		$this->setcontroller();
		$this->setmethod();
	}

	public function setUri()
	{
		$this->uri = explode('/', explode('?' ,$_SERVER['REQUEST_URI'])[0]);
	}

	public function setcontroller()
	{
		$this->controller = !empty($this->uri[3]) ? $this->uri[3] : DEFAULT_CONTROLLER;

		if (!isset($_SESSION[SESS])){
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				echo json_encode('Solicitud denegada, por favor vuelva a autenticarse.');
				exit();
			}
			else{
				if ($this->controller == 'ManagerLogin') {
					$_SESSION[CONTROLLER_GROUP] = 'Manager/';
					$this->controller = "Login";
				}
				else if($this->controller == 'UserLogin') {
					$_SESSION[CONTROLLER_GROUP] = 'User/';
					$this->controller = "Login";
				}
				else if($this->controller == 'ApiRequest'){
                    $_SESSION[CONTROLLER_GROUP] = 'User/';
                    $this->controller = "ApiRequest";
                }
				else{
					header('Location: '. DEFAULT_URL);
					exit();
				}
			}
		}else{
			if(!ValidateController($this->controller)){
				$this->controller = DEFAULT_CONTROLLER;
			}
		}

		$this->controller .='Controller';

  		require_once(CONTROLLER_PATH . $_SESSION[CONTROLLER_GROUP] . "$this->controller.php");
	}

	public function setmethod()
	{
		$this->method =! empty($this->uri[4]) ? $this->uri[4] : DEFAULT_METHOD;

		if(!ValidateMethodController($this->controller, $this->method))
			$this->method = DEFAULT_METHOD;
	}

	public function setParam(){
		if(REQUEST_METHOD === 'POST')
		  $this->param = $_POST;
		else if (REQUEST_METHOD === 'GET')
			$this->param =! empty($this->uri[5]) ? $this->uri[5] : '';
			/*if(!empty($this->uri[4])){$this->param[]=$this->uri[4];}
			if(!empty($this->uri[5])){$this->param[]=$this->uri[5];}
			if(!empty($this->uri[6])){$this->param[]=$this->uri[6];}*/
	}
}

?>
