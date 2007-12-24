<?
class googlechart extends controller
{
	function base(){
		$gchart = $this->library->gchart;
		$data = array('01/12' => 1245,'02/12' => 895, '03/12' => 956, '04/12' => 1356,'05/12' => 1542,'06/12' => 1423);
		$gchart->title = 'Daily Visitors'; // this title will be on the chart image
		$gchart->add_data(array_values($data)); // adding values
		$gchart->add_labels('x',array_keys($data)); // adding x labels (bottom axis)
		$gchart->add_labels('y',array(0,500,1000,1500)); // adding y labels (left axis)
		$chartpath =  $gchart->get_Image_Url();
		
		$this->view->set("chartpath",$chartpath);
	}
	
	function pie(){
		$this->setView("base");
		$gchart = $this->library->gchart;
		$gchart->setChartType("p");
		$data = array('A' => 10,'B' => 395, 'C' => 556,"D"=>450);
		$gchart->title = 'Daily Visitors3'; // this title will be on the chart image
		$gchart->add_data(array_values($data)); // adding values
		$gchart->add_labels('x',array_keys($data)); // adding x labels (bottom axis)
		//$gchart->add_labels('y',array(0,500,1000,1500)); // adding y labels (left axis)
		$chartpath =  $gchart->get_Image_Url();
		
		$this->view->set("chartpath",$chartpath);
	}

}
?>