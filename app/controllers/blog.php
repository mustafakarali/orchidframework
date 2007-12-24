<?
class blog extends controller
{
	function base()
	{
		$username = $this->session->username;
		if (!empty($username))
		$this->redirect("blog","dashboard");
	}

	function hello()
	{
		$this->view->set("param1",'World');
	}

	function login()
	{
		$this->setView("base");
		$this->view->set("username",$this->post->username);
		
		$usersmodel = $this->model->users;

		if (!empty($this->post->username)){
			$user = $usersmodel->find("username = '{$this->post->username}' and password='{$this->post->password}'");
			if (empty($user))
			{
				$this->view->set("error","Username/password doesn't match. Please try again");
			}
			else {
				$this->session->username = $this->post->username;
				$this->redirectUrl("blog","dashboard");
			}
		}



	}

	function register()
	{

		if (!empty($this->post->username)){
			$usersmodel = $this->model->users;
			$user = $usersmodel->find("username = '{$this->post->username}'");

			$this->view->set("username",$this->post->username);

			if (empty($user)){
				$usersmodel->insert();
				$this->view->set("error","success");
			}
			else
			$this->view->set("error","This Username Already Exists");
		}

	}

	function dashboard()
	{

		$baseurl = base::baseUrl();
		$this->use_view=false;
		$username = $this->session->username;
		if (!empty($username)){
			echo "<h1 style='margin-bottom:25px;'>Welcome to your blog</h1>";
			echo "You can now create your blog post or <a href='{$baseurl}/blog/logout'>Logout</a>";
		}

	}

	function logout()
	{
		$this->use_view=false;
		$this->session->username=null;
		$this->redirectUrl("blog","login");
	}

	function test()
	{
		$usersmodel = $this->model->users;
		/*$usersmodel->username = "test";
		$usersmodel->password = "testpass";
		$usersmodel->insert();*/
		
		$usersmodel->find("username = 'test'");
		$usersmodel->username = "tester";
		$usersmodel->update();
	}
	function __construct()
	{
		$this->session = loader::load("session");
	}
}
?>
