<?
class welcome extends controller
{

	function main()
	{
		//echo "Hello";
		$this->view->set("name","afif");
		$this->view->set("abcd","afif2");
	}

	function index()
	{
		//echo "He;l";
	}

	function base()
	{
		//$var = $this->params[0]."".$this->params[1];
		//$var = $this->model->post->getPost();
		$this->redirect("welcome","main");
		$this->view->set("abcd",$var);
		unittest::assertTrue(!empty($this->model->post->name));
		unittest::assertEqual($this->model->post->name,"hasin");
		base::pr($this);
		//$this->cache->set("abcd",array("hello2","hi","aa"=>array(1,2,3,4,4)));
		//if (!$this->cache->isExpired("abcd"))
		//base::pr($this->cache->get("abcd"));



		//die();
		//if (!empty($this->model->post->name)) echo $this->model->post->name."<br/>";
		//if (!empty($this->model->post->roll)) echo $this->model->post->roll."<br/>";
		//if (!empty($this->model->post->subject)) echo $this->model->post->subject."<br/>";

		//if (!empty($this->model->post->name)) die();

	}

	public function dbtest()
	{
		//$this->use_layout = false;
		//$this->db->hi(1,2,3,4);
		
		//$this->db->execute("create table posts(id INTEGER, name TEXT)");
		//$this->db->execute("insert into posts (id, name) values (null, 'afif')");
		$this->db->execute("select * from posts");
		$this->db->execute("select * from destinations");
		$this->db->execute("select * from posts");
		$this->db->execute("select * from posts");
		$this->db->execute("select * from posts_destinations");
		$this->db->execute("select * from posts");
		$tc = $this->db->count();
		while($row = $this->db->getRow())
		{
			base::pr($row);
		}

		$this->db->rewind();

		$tc = $this->db->count();
		while($row = $this->db->getRow())
		{
			base::pr($row);
		}
		//base::pr($row);
		$this->view->set("count",$tc);
		//die();
	}
	
	function ajaxeffect()
	{
		
	}
	
	function gmap()
	{
		
	}
	
	function cssbutton()
	{
		
	}
	
	function pt(){}
	
}
?>