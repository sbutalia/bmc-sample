<?php defined('SYSPATH') or die('No direct access allowed!'); 
  
class RecurlyTest extends Kohana_UnitTest_TestCase 
{
	public function test_inovice_payment() 
    {
		$config = Kohana::$config->load('test.recurly');
        $postData = $config;

		$submitData['Field1'] = 'mobile entrepreneur  $272.84';
		$submitData['Field2'] = $postData['account']['first_name'];
		$submitData['Field3'] = $postData['account']['last_name'];
		$submitData['Field4'] = $postData['account']['email'];
		$submitData['Field5'] = isset($postData['billing_info']['phone']) ? $postData['billing_info']['phone'] : '';
		$submitData['Field15'] = isset($postData['account']['company_name']) ? $postData['account']['company_name'] : '';
		$submitData['Field6'] = $postData['billing_info']['address1'];
		$submitData['Field7'] = isset($postData['billing_info']['address2']) ? $postData['billing_info']['address2'] : '';
		$submitData['Field8'] = $postData['billing_info']['city'];
		$submitData['Field9'] = isset($postData['billing_info']['state']) ? $postData['billing_info']['state'] : '';
		$submitData['Field10'] = isset($postData['billing_info']['zip']) ? $postData['billing_info']['zip'] : '';
		$submitData['Field11'] = $postData['billing_info']['country'];

		$submitData['Field12'] = $postData['networkPageID'];
		$submitData['Field13'] = "https://facebook.com/".$postData['networkPageID'];

		$submitData['Field14'] =  isset($postData['account']['digital_signature']) ? $postData['account']['digital_signature'] : '';

		$params = $submitData;
		$delete = array();
		
		$dir = '/Users/'.mt_rand(0, 100000).'/';
		mkdir($dir);
		
		foreach ($_FILES as $key => $value) {
			$path = $dir.str_replace('/','', str_replace('..', '', $_FILES[$key]['name']));
			move_uploaded_file($_FILES[$key]['tmp_name'], $path);
			$params[$key] = '@'.$path;
			$delete[] = $path;
		}

		$wufooDomain = $this->config['wufoo']['subdomain'];
		$wufooApiKey = $this->config['wufoo']['apiKey'];
		try {
			$curl = new WufooCurl();
			$response = $curl->post(
				$params,
				'https://'.$wufooDomain.'.wufoo.com/api/v3/forms/invoice-payment-form/entries.json', 
				$wufooApiKey);
		} catch (Exception $e) {
			$this->failed('Not Found');
			return;
		}
		
		foreach ($delete as $file) {
			unlink($file);
		}
		rmdir($dir);
		
		$obj = json_decode($response);
		
		$this->assertEquals($obj->Success, '1');
		
	}
}