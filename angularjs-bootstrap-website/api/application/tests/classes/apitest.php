<?php defined('SYSPATH') or die('No direct access allowed!'); 
  
class ApiTest extends Kohana_UnitTest_TestCase 
{ 
    public function test_get_authorize() 
    {
        $config = Kohana::$config->load('test');

		$api_key = $config['api']['APIKey'];
		$api_pass = $config['api']['APIPassword'];
		$base_url = $config['api']['url']['authorize'];

		$authorze_array = array(
			'networkPageID'=>'385456498187516', 
			'partner'=>array(
				'APIKey'=>$api_key, 
				'APIPassword'=>$api_pass
			)
		);
		
		$url = $base_url.'{{'.base64_encode(json_encode($authorze_array)).'}}';
		$request = Request::factory($url);
		$response = $request->execute();
        $json = $response->body();
		$data = json_decode($json);
		$this->assertEquals($data->message, 'NOT_PAID');
    }
	public function test_set_authorize() 
    {
        $config = Kohana::$config->load('test');

		$api_key = $config['api']['APIKey'];
		$api_pass = $config['api']['APIPassword'];
		$base_url = $config['api']['url']['authorize'];

		$authorze_array = array(
			'status'=>'PAID', 	
			'networkPageID'=>'385456498187516', 
			'partner'=>array(
				'APIKey'=>$api_key, 
				'APIPassword'=>$api_pass
			)
		);
		
		$url = $base_url.'{{'.base64_encode(json_encode($authorze_array)).'}}';
		$request = Request::factory($url);
		$response = $request->execute();
        $json = $response->body();
		$data = json_decode($json);
		$this->assertEquals($data->message, "Subscriber status updated to 'PAID'");
    }
	public function test_install() 
    {
        $config = Kohana::$config->load('test');

		$api_key = $config['api']['APIKey'];
		$api_pass = $config['api']['APIPassword'];
		$base_url = $config['api']['url']['install'];

		$install_array = array( 
			'whitelabel'=>"0", 
			'partner'=>array(
				'id'=>"1",
				'APIKey'=>$api_key, 
				'APIPassword'=>$api_pass
			),
			'page'=>array(
				'name'=>"Dev Framework",
				'category'=>"Internet", 
				'networkPageID'=>"385456498187516",
				'networkID'=>"1"
			)
		);
		
		$url = $base_url.'{{'.base64_encode(json_encode($install_array)).'}}';
		$request = Request::factory($url);
		$response = $request->execute();
        $json = $response->body();
		$data = json_decode($json);
		$this->assertEquals($data->message, "The app was successful installed.");
    }
}