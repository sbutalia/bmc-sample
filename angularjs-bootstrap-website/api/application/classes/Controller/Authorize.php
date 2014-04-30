<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Authorize extends Controller_Base {

	public function action_index()
	{
        $this->apiSetup();
		$this->base_url = $this->config['api']['url']['authorize'];
		
		$postData = json_decode($this->request->body(), true);
		$this->status = $postData['status'];
		$this->networkPageID = $postData['networkPageID'];

		if ($this->status == "") {
			$authorize_array = array(
				'networkPageID'=>$this->networkPageID, 
				'partner'=>array(
					'APIKey'=>$this->api_key, 
					'APIPassword'=>$this->api_pass
				)
			);
		}
		else {
			$authorize_array = array(
				'status'=>$this->status, 
				'networkPageID'=>$this->networkPageID, 
				'partner'=>array(
					'APIKey'=>$this->api_key, 
					'APIPassword'=>$this->api_pass
				)
			);
		}
		
		$json = $this->getResponse($authorize_array);
		$this->response->body($json);
	}

	public static function paid($account_code, $config){
	    $authorize_array = array(
            'status'=>'PAID',
            'networkPageID'=>$account_code,
            'partner'=>array(
                'APIKey'=>$config['api']['APIKey'],
                'APIPassword'=>$config['api']['APIPassword']
            )
        );

        $base_authorize_url = $config['api']['url']['updateSubscriber'];
        $url = $base_authorize_url.base64_encode(json_encode($authorize_array));
        Kohana::$log->add(LOG::DEBUG, "Sending Request To API_APPS: ".$url);
        Kohana::$log->add(LOG::DEBUG, "Request: ".json_encode($authorize_array) );

        $request = Request::factory($url);
        $response = $request->execute();
        $json = $response->body();

        Kohana::$log->add(LOG::DEBUG, "Response from API_APPS: ".$json);

        return $response;
	}

	public static function notpaid($account_code, $config){
	    $authorize_array = array(
            'status'=>'NOT_PAID',
            'networkPageID'=>$account_code,
            'partner'=>array(
                'APIKey'=>$config['api']['APIKey'],
                'APIPassword'=>$config['api']['APIPassword']
            )
        );

        $base_authorize_url = $config['api']['url']['updateSubscriber'];
        $url = $base_authorize_url.base64_encode(json_encode($authorize_array));
        Kohana::$log->add(LOG::DEBUG, "Sending Request To API_APPS: ".$url);
        Kohana::$log->add(LOG::DEBUG, "Request: ".json_encode($authorize_array) );

        $request = Request::factory($url);
        $response = $request->execute();
        $json = $response->body();

        Kohana::$log->add(LOG::DEBUG, "Response from API_APPS: ".$json);

        return $response;
	}

}
