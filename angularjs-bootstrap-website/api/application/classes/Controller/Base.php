<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Base extends Controller {

    protected $config;

    protected $transaction;

	public $api_key;

	public $api_pass;
	
	public $base_url;

	public $account;

	public $billing_info;

	public $subscription;


	public function before()
    {
		parent::before();

		$this->transaction = new Model_Transaction();

        if (Kohana::$environment === Kohana::DEVELOPMENT)
        {
            $this->config = Kohana::$config->load('dev');
            Kohana::$log->add(LOG::DEBUG, "Kohana environment - DEV".$_SERVER['SERVER_NAME'] );
        }
        else if (Kohana::$environment === "developmentrkm"){
            $this->config = Kohana::$config->load('devrkm');

            Kohana::$log->add(LOG::DEBUG, "Kohana environment - LOCAL RKM" );
        }
        else if (Kohana::$environment === "qa"){
            $this->config = Kohana::$config->load('qa');

            Kohana::$log->add(LOG::DEBUG, "Kohana environment - QA" );
        }
        else if (Kohana::$environment === Kohana::PRODUCTION){
            $this->config = Kohana::$config->load('pro');
            Kohana::$log->add(LOG::DEBUG, "Kohana environment - PRO" );
        }
        else {
            $this->config = Kohana::$config->load('test');
        }


	}

	public function apiSetup()
	{
		$this->api_key = $this->config['api']['APIKey'];
		$this->api_pass = $this->config['api']['APIPassword'];
	}

	public function getResponse($postArray)
	{
		$url = $this->base_url.'{{'.base64_encode(json_encode($postArray)).'}}';
		$request = Request::factory($url);
		$response = $request->execute();
        $json = $response->body();

		return $json;
	}

	public function paymentSetup()
	{
		Recurly_Client::$subdomain = $this->config['recurly']['subdomain'];
		Recurly_Client::$apiKey = $this->config['recurly']['apiKey'];
	}

	public function billingUpdate()
	{
		$err = "";

		$this->billing_info = new Recurly_BillingInfo();
		$this->billing_info->account_code = $this->account_code;
		$this->billing_info->first_name = $this->account_first_name;
		$this->billing_info->last_name = $this->account_last_name;
		$this->billing_info->address1 = $this->billing_info_address1;
		$this->billing_info->verification_value = $this->credit_card_verification_value;
		$this->billing_info->number = $this->credit_card_number;
		$this->billing_info->month = $this->credit_card_month;
		$this->billing_info->year = $this->credit_card_year;
		$this->billing_info->verification_value = $this->credit_card_verification_value;
		$this->billing_info->country = $this->billing_info_country;
		$this->billing_info->city = $this->billing_info_city;
		$this->billing_info->zip = $this->billing_info_zip;
		$this->billing_info->address2 = $this->billing_info_address2;
		$this->billing_info->phone = $this->billing_info_phone;
		$this->billing_info->state = $this->billing_info_state;

        try{
		    $this->billing_info->update();
        }
        catch (Recurly_NotFoundError $e) {
          $err = 'Record could not be found';
        }
        catch (Recurly_ValidationError $e) {
          // If there are multiple errors, they are comma delimited:
          $messages = explode(',', $e->getMessage());
          $err = implode("\n", $messages);
        }
        catch (Recurly_ServerError $e) {
          $err = 'Problem communicating with Recurly';
        }
        catch (Exception $e) {
          // You could use send these messages to a log for later analysis.
          $err = get_class($e) . ': ' . $e->getMessage();
        }

		return $err;
	}

	public function accountUpdate()
	{
	    $err = "";

		$this->account->username = $this->account_code;
		$this->account->first_name = $this->account_first_name;
		$this->account->last_name = $this->account_last_name;
		$this->account->email = $this->account_email;
		$this->account->company_name = $this->account_company_name;
		$this->account->billing_info = $this->billing_info;

        try{
		    $this->account->update();
        }
        catch (Recurly_NotFoundError $e) {
          $err = 'Record could not be found';
        }
        catch (Recurly_ValidationError $e) {
          // If there are multiple errors, they are comma delimited:
          $messages = explode(',', $e->getMessage());
          $err = implode("\n", $messages);
        }
        catch (Recurly_ServerError $e) {
          $err = 'Problem communicating with Recurly';
        }
        catch (Exception $e) {
          // You could use send these messages to a log for later analysis.
          $err = get_class($e) . ': ' . $e->getMessage();
        }

        return $err;
	}

	public function createSubscription()
	{
	    $err = "";

		$this->subscription = new Recurly_Subscription();
		$this->subscription->plan_code = $this->plan_code;
		$this->subscription->subscription_add_ons = '';
		$this->subscription->currency = 'USD';
		$this->subscription->billing_info = $this->billing_info;
		$this->subscription->account = $this->account;

		try{
            $this->subscription->create();
        }
        catch (Recurly_NotFoundError $e) {
          $err = 'Record could not be found';
        }
        catch (Recurly_ValidationError $e) {
          // If there are multiple errors, they are comma delimited:
          $messages = explode(',', $e->getMessage());
          $err = implode("\n", $messages);
        }
        catch (Recurly_ServerError $e) {
          $err = 'Problem communicating with Recurly';
        }
        catch (Exception $e) {
          // You could use send these messages to a log for later analysis.
          $err = get_class($e) . ': ' . $e->getMessage();
        }

		//TODO: Confirm success from API_APPS
		if($err == ""){
		    Controller_Install::install_page($this->account_code, $this->config);
		    Controller_Authorize::paid($this->account_code, $this->config);
		}

		return $err;
	}

	public function getBillingInfo()
	{
		$err = "";

		try {
		  $this->billing_info = Recurly_BillingInfo::get($this->account_code);
		} catch (Recurly_NotFoundError $e) {
		  $err = 'No billing information';
		}
		return $err;
	}

}
