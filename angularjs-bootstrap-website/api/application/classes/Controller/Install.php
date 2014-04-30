<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Install extends Controller_Base {

	public function action_index()
	{
		$this->apiSetup();
		$this->base_url = $this->config['api']['url']['install'];

		$postData = json_decode($this->request->body(), true);

		$this->whitelabel = $postData['whitelabel'];
		$this->partner_id = $postData['partner_id'];
		$this->name = $postData['name'];
		$this->category = $postData['category'];
		$this->networkPageID = $postData['networkPageID'];
		$this->networkID = $postData['networkID'];

		$install_array = array( 
			'whitelabel'=>$this->whitelabel, 
			'partner'=>array(
				'id'=>$this->partner_id,
				'APIKey'=>$this->api_key, 
				'APIPassword'=>$this->api_pass
			),
			'page'=>array(
				'name'=>$this->name,
				'category'=>$this->category, 
				'networkPageID'=>$this->networkPageID,
				'networkID'=>$this->networkID
			)
		);

		$json = $this->getResponse($install_array);
		$this->response->body($json);
	}

	public static function install_page($account_code, $config){
	        $install_array = array(
    			'whitelabel'=>'1',
    			'partner'=>array(
    				'id'=>'1',
                    'APIKey'=>$config['api']['APIKey'],
                    'APIPassword'=>$config['api']['APIPassword']
    			),
    			'page'=>array(
    				'name'=>'Somename',
    				'category'=>'none',
    				'networkPageID'=>$account_code,
    				'networkID'=>'1'
    			)
    		);

            $base_authorize_url = $config['api']['url']['install'];
            $url = $base_authorize_url.base64_encode(json_encode($install_array));
            Kohana::$log->add(LOG::DEBUG, "Sending Request To API_APPS: ".$url);
            Kohana::$log->add(LOG::DEBUG, "Request: ".json_encode($install_array) );

            $request = Request::factory($url);
            $response = $request->execute();
            $json = $response->body();

            Kohana::$log->add(LOG::DEBUG, "Response from API_APPS: ".$json);
	}



}
