<?php defined('SYSPATH') or die('No direct access allowed!'); 
  
class RecurlyTest extends Kohana_UnitTest_TestCase 
{
	public function test_create_payment() 
    {
		$config = Kohana::$config->load('test.recurly');
        $postData = $config;

		Recurly_Client::$subdomain = $config['subdomain'];
		Recurly_Client::$apiKey = $config['apiKey'];

		$this->account_code = '10132013558_'.uniqid();
		$this->account_first_name = $postData['account']['first_name'];
		$this->account_last_name = $postData['account']['last_name'];
		$this->account_email = $postData['account']['email'];
		$this->account_company_name = isset($postData['account']['company_name']) ? $postData['account']['company_name'] : '';
		$this->billing_info_address1 = $postData['billing_info']['address1'];
		$this->billing_info_address2 = isset($postData['billing_info']['address2']) ? $postData['billing_info']['address2'] : '';
		$this->billing_info_city = $postData['billing_info']['city'];
		$this->billing_info_state = isset($postData['billing_info']['state']) ? $postData['billing_info']['state'] : '';
		$this->billing_info_zip = isset($postData['billing_info']['zip']) ? $postData['billing_info']['zip'] : '';
		$this->billing_info_phone = isset($postData['billing_info']['phone']) ? $postData['billing_info']['phone'] : '';
		$this->billing_info_country = $postData['billing_info']['country'];
		$this->credit_card_number = $postData['credit_card']['number'];
        $this->credit_card_month = $postData['credit_card']['month'];
        $this->credit_card_year = $postData['credit_card']['year'];
		$this->credit_card_verification_value = $postData['credit_card']['verification_value'];
		$this->plan_code = $postData['plan_code'];
		
		$account = new Recurly_Account($this->account_code);
		$account->create();
		
		$billing_info = new Recurly_BillingInfo();
		$billing_info->account_code = $this->account_code;
		$billing_info->first_name = $this->account_first_name;
		$billing_info->last_name = $this->account_last_name;
		$billing_info->address1 = $this->billing_info_address1;
		$billing_info->verification_value = $this->credit_card_verification_value;
		$billing_info->number = $this->credit_card_number;
		$billing_info->month = $this->credit_card_month;
		$billing_info->year = $this->credit_card_year;
		$billing_info->country = $this->billing_info_country;
		$billing_info->city = $this->billing_info_city;
		$billing_info->zip = $this->billing_info_zip;
		$billing_info->address2 = $this->billing_info_address2;
		$billing_info->phone = $this->billing_info_phone;
		$billing_info->state = $this->billing_info_state;
		$billing_info->update();
		
		$account->username = $this->account_code;
		$account->first_name = $this->account_first_name;
		$account->last_name = $this->account_last_name;
		$account->email = $this->account_email;
		$account->company_name = $this->account_company_name;

		$subscription = new Recurly_Subscription();
		$subscription->plan_code = $this->plan_code;
		$subscription->subscription_add_ons = '';
		$subscription->currency = 'USD';
		$account->billing_info = $billing_info;
		$subscription->account = $account;

		$subscription->create();
			
		$this->assertEquals($subscription->uuid, '');
	}

	public function test_update_payment() 
    {
		$config = Kohana::$config->load('test.recurly');
		$postData = $config;

		Recurly_Client::$subdomain = $config['subdomain'];
		Recurly_Client::$apiKey = $config['apiKey'];

		$account_code = '10132013558_5265cf3305d05';
		$this->account_first_name = $postData['account']['first_name'];
		$this->account_last_name = $postData['account']['last_name'];
		$this->account_email = $postData['account']['email'];
		$this->account_company_name = isset($postData['account']['company_name']) ? $postData['account']['company_name'] : '';
		$this->billing_info_address1 = $postData['billing_info']['address1'];
		$this->billing_info_address2 = isset($postData['billing_info']['address2']) ? $postData['billing_info']['address2'] : '';
		$this->billing_info_city = $postData['billing_info']['city'];
		$this->billing_info_state = isset($postData['billing_info']['state']) ? $postData['billing_info']['state'] : '';
		$this->billing_info_zip = isset($postData['billing_info']['zip']) ? $postData['billing_info']['zip'] : '';
		$this->billing_info_phone = isset($postData['billing_info']['phone']) ? $postData['billing_info']['phone'] : '';
		$this->billing_info_country = $postData['billing_info']['country'];
		$this->credit_card_number = $postData['credit_card']['number'];
        $this->credit_card_month = $postData['credit_card']['month'];
        $this->credit_card_year = $postData['credit_card']['year'];
		$this->credit_card_verification_value = $postData['credit_card']['verification_value'];
		$this->plan_code = $postData['plan_code'];

        $accountExits = false;
        try{
		    $account = Recurly_Account::get($this->account_code);
		    $accountExits = true;
        }
        catch (Recurly_NotFoundError $e) {
          //'Record could not be found';
        }

		if ($accountExits) {
			$subscriptions = Recurly_SubscriptionList::getForAccount($this->account_code);
			//Kohana::$log->add(LOG::DEBUG, "Existing Account: ".print_r($account,true));

			//TODO: IF account is closed Reopen it
			if ($account->state == 'closed') {
				$account = Recurly_Account::reopenAccount($this->account_code);
			}

            $billing_info = new Recurly_BillingInfo();
            $billing_info->account_code = $this->account_code;
            $billing_info->first_name = $this->account_first_name;
            $billing_info->last_name = $this->account_last_name;
            $billing_info->address1 = $this->billing_info_address1;
			$billing_info->verification_value = $this->credit_card_verification_value;
			$billing_info->number = $this->credit_card_number;
			$billing_info->month = $this->credit_card_month;
			$billing_info->year = $this->credit_card_year;
            $billing_info->country = $this->billing_info_country;
            $billing_info->city = $this->billing_info_city;
            $billing_info->zip = $this->billing_info_zip;
            $billing_info->address2 = $this->billing_info_address2;
			$billing_info->phone = $this->billing_info_phone;
		    $billing_info->state = $this->billing_info_state;
            $billing_info->update();

            
			//TODO: Update Account Name, Address, Credit Card Info
            // See http://docs.recurly.com/api/accounts under "Update Account"

			$account->first_name = $this->account_first_name;
            $account->last_name = $this->account_last_name;
            $account->email = $this->account_email;
            $account->company_name = $this->account_company_name;
            $account->billing_info = $billing_info;

			 //-- Proceed only if account is OPEN and new CC authorization is successful
            $activeSubscriptionFound = false;
            //-- Find an active subscription
            foreach($subscriptions as $subscription) {
               if($subscription->state == 'active' || $subscription->state == 'modified'){
                      if($subscription->plan->plan_code != $this->plan_code){
                           //Update the subscription with a new plan code
                           $subscription = Recurly_Subscription::get($subscription->uuid);
                           $subscription->plan_code = $this->plan_code;
                           $subscription->updateImmediately();     // Update immediately.
                           // or $subscription->updateAtRenewal(); // Update when the subscription renews.

                          Kohana::$log->add(LOG::DEBUG, "New Subscription Plancode: ". $this->plan_code);
                      }
                      else{
                          //No updated needed
                          Kohana::$log->add(LOG::DEBUG, "All is well. Subscription is active and well");
                      }

                      $activeSubscriptionFound = true;
               }
            }

            if( !$activeSubscriptionFound ){
                foreach($subscriptions as $subscription) {
                    Kohana::$log->add(LOG::DEBUG, "SubscriptionID: ". $subscription->uuid);
                    Kohana::$log->add(LOG::DEBUG, "Subscription Plancode: ". $subscription->plan->plan_code);
                    Kohana::$log->add(LOG::DEBUG, "Subscription State: ". $subscription->state);

                    if($subscription->state == 'canceled'){
                        //$subscription = Recurly_Subscription::get('44f83d7cba354d5b84812419f923ea96');
                        $subscription->reactivate();
                        Kohana::$log->add(LOG::DEBUG, "Subscription reactivated.");
                    }
                    else if($subscription->state == 'expired'){
                       //TODO - Create a new subscription
                        $subscription = new Recurly_Subscription();
                        $subscription->plan_code = $this->plan_code;
                        $subscription->subscription_add_ons = '';
                        $subscription->currency = 'USD';
                        $subscription->billing_info = $billing_info;
                        $subscription->account = $account;
                        $subscription->create();

                        Kohana::$log->add(LOG::DEBUG, "New Subscription: ". $subscription->uuid);
                    }
                    else{
                        //Throw Error: "Unknown subscription state. Something has really gone wrong!"
                    }
                }//END - foreach($subscriptions as $subscription)
			}//END - if( !$activeSubscriptionFound )
		}
	}
	public function test_notification() 
    {
		$config = Kohana::$config->load('test');
		
		Recurly_Client::$subdomain = $config['recurly']['subdomain'];
		Recurly_Client::$apiKey = $config['recurly']['apiKey'];

		$post_xml_array = $config['recurly']['post_xml'];
		foreach ($post_xml_array as $key => $post_xml) {
			$notification = new Recurly_PushNotification($post_xml);
			$this->assertEquals($notification->type, $key);
		}
	}
}