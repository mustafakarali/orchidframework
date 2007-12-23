<?
class sessionm extends controller
{
	public function base()
	{
		$this->use_view=false;
		echo "Hello";

		$session = loader::load("session");
		echo $session->name2;
		$session->name2="abcd44dm44444";
		//echo $session->name2;
	}

	public function acttest()
	{
		$this->use_view=false;
		echo "Hello";

		$s = $this->model->sessions;
		$s->find("id = 16");
		echo $s->getData();

		$s->setData("Nirjhor");
		$s->save();
		//base::pr($s);
	}

	public function first()
	{
		$this->use_view=false;
		echo "Hello world";
		echo date("Y-m-d");
		for($i=0; $i<10; $i++){
			for($j=0; $j<$i; $j++){
				echo "1";
			}
			echo "<br/>";
		}
		for($i=10; $i>=1; $i--){
			for($j=0; $j<$i; $j++){
				echo "1";
			}
			echo "<br/>";
		}
	}
}
?>