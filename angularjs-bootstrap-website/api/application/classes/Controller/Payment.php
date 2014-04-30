<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Payment extends Controller_Base {

    private $SUBS_CODE_NEW = "new";
    private $SUBS_CODE_UPDATED = "updated";
    private $SUBS_CODE_EXISTING = "existing";
    private $SUBS_CODE_REACTIVATED = "reactivated";

    //-- Initiated via purchase.js
	public function action_index()
	{
		$subscriptionResponse = json_decode("{'code':'','id':'','card_type':'','last_four':''}");
		$postData = json_decode($this->request->body(), true);

		Kohana::$log->add(LOG::DEBUG, "Payment Request: ".$this->request->body());

        if($postData != null){
            //-- $postData['plan_info']['type'] defined in config.js
			if( $postData['planInfo']['type'] == "credit")
		        $this->processViaRecurly($postData);
		    else if( $postData['planInfo']['type'] == "invoice")
                $this->processViaWufoo($postData);
            else
                $this->failed("No Plan Info Type.");
		}
		else{
            $this->failed("Posted data is empty.");
		}
	}

    public function processViaWufoo($postData)
    {
        $err = "";
        $returnID = "";

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

		$wuFoo = new ApiWufoo();
		$obj = $wuFoo->submitForm($submitData);
		
		if ($obj->Success == 1) {
			$meesage['code'] = $this->SUBS_CODE_EXISTING;
			$meesage['id'] = $obj->EntryId;

			Kohana::$log->add(LOG::DEBUG, "Form Id: ".$obj->EntryId);

			$this->success($meesage);
		}
		else 
		{
			$err = $obj->FieldErrors;
			$this->failed($err);
		}
		
   }

    public function processViaRecurly($postData)
	{
        $err = "";

        $this->paymentSetup();

        if (isset($postData['billing_info']['promo_code']))
            $this->plan_code = $postData['billing_info']['promo_code'];
        else
            $this->plan_code = $postData['plan_code'];

        $this->account_code = $postData['networkPageID'];
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

        //-- FOR TESTING : REMOVE LATER
//		$this->account_code = '10132013558_'.uniqid();
        //-- FOR TESTING : TEST ACCOUNT CODE '10132013558_5265cf3305d05'
  //     $this->account_code = '10132013558_52668ebf1c714';


        Kohana::$log->add(LOG::DEBUG, "Account Code: ".$this->account_code);

        $accountExits = false;
        try{
            $this->account = Recurly_Account::get($this->account_code);
            $accountExits = true;
        }
        catch (Recurly_NotFoundError $e) {
          //'Record could not be found';
        }

        if ($accountExits) {
            $subscriptions = Recurly_SubscriptionList::getForAccount($this->account_code);
            Kohana::$log->add(LOG::DEBUG, "Existing Account: ".$this->account_code );
            //Kohana::$log->add(LOG::DEBUG, "Existing Account: ".print_r($this->account,true));

            //-- If account is closed Reopen it
            if ($this->account->state == 'closed') {
                $this->account = Recurly_Account::reopenAccount($this->account_code);
                Kohana::$log->add(LOG::DEBUG, "Reopening Account: ".$this->account_code );

                Controller_Install::install_page($this->account_code, $this->config);
                Controller_Authorize::paid($this->account_code, $this->config);
            }
            //-- Update Billiing Info
            $err = $this->billingUpdate();
            if($err != ""){
                Kohana::$log->add(LOG::DEBUG, $err );
                //Return Error Response
                $this->failed( $err );
                return;
            }

            // See http://docs.recurly.com/api/accounts under "Update Account"
            $err = $this->accountUpdate();
            if($err != ""){
                Kohana::$log->add(LOG::DEBUG, $err );
                $this->failed( $err );
                return;
            }

             //-- Proceed only if account is OPEN and new CC authorization is successful
            $activeSubscriptionFound = false;
            //-- Find an active subscription
            foreach($subscriptions as $subscription) {
               if($subscription->state == 'active' || $subscription->state == 'modified'){
                  if($subscription->plan->plan_code != $this->plan_code){
                       //Update the subscription with a new plan code
                       $this->subscription = Recurly_Subscription::get($subscription->uuid);
                       $this->subscription->plan_code = $this->plan_code;

                       $subscriptionResponse["code"] = $this->SUBS_CODE_UPDATED;

                       //TODO: Catch recurly errors
                       $this->subscription->updateImmediately();     // Update immediately.
                       // or $subscription->updateAtRenewal(); // Update when the subscription renews.

                      Kohana::$log->add(LOG::DEBUG, "Existing Subscription with new Plancode: ". $this->plan_code);
                  }
                  else{
                      $this->subscription = $subscription;

                      $subscriptionResponse["code"] = $this->SUBS_CODE_EXISTING;

                      //No updated needed
                      Kohana::$log->add(LOG::DEBUG, "All is well. Subscription is active and well.");

                    //Authorize in API-APPS
                    //TODO: Confirm success from API_APPS
                    Controller_Install::install_page($this->account_code, $this->config);
                    Controller_Authorize::paid($this->account_code, $this->config);
                  }

                  $activeSubscriptionFound = true;
                   break;
               }
                else if($subscription->state == 'canceled'){
                   //$subscription = Recurly_Subscription::get('44f83d7cba354d5b84812419f923ea96');
                   //TODO: Catch recurly errors
                   $subscription->reactivate();
                   $this->subscription = $subscription;

                   $subscriptionResponse["code"] = $this->SUBS_CODE_REACTIVATED;

                   //Authorize in API-APPS
                   Controller_Authorize::paid($this->account_code, $this->config);
                   $activeSubscriptionFound = true;

                   Kohana::$log->add(LOG::DEBUG, "Subscription reactivated.");

                   break;
                }
                else if($subscription->state == 'expired'){
                   $err = $this->createSubscription();
                    if($err != ""){
                        Kohana::$log->add(LOG::DEBUG, $err );
                        $this->failed( $err );
                        return;
                    }

                    $subscriptionResponse["code"] = $this->SUBS_CODE_REACTIVATED;

                   $activeSubscriptionFound = true;

                    Kohana::$log->add(LOG::DEBUG, "New Subscription for Account: ".$this->account_code );
                   Kohana::$log->add(LOG::DEBUG, "New Subscription: ". $this->subscription->uuid);

                   break;
                }
                else{
                   //Throw Error: "Unknown subscription state. Something has really gone wrong!"
                   Kohana::$log->add(LOG::DEBUG, "Unknown subscription state: ".$this->account_code );
                   break;
                }
            }

            if( !$activeSubscriptionFound ){
               $err = $this->createSubscription();
                if($err != ""){
                    Kohana::$log->add(LOG::DEBUG, $err );
                    $this->failed( $err );
                    return;
                }
                $subscriptionResponse["code"] = $this->SUBS_CODE_NEW;

                Kohana::$log->add(LOG::DEBUG, "New Subscription for Account without an active subscription: ".$this->account_code );
                Kohana::$log->add(LOG::DEBUG, "SubscriptionID: ". $this->subscription->uuid);
            }
        }
        else {
            $this->account = new Recurly_Account($this->account_code);
            $err = $this->account->create();
            if($err != ""){
                Kohana::$log->add(LOG::DEBUG, $err );
                $this->failed( $err );
                return;
            }

            $err = $this->billingUpdate();
            if($err != ""){
                Kohana::$log->add(LOG::DEBUG, $err );
                $this->failed( $err );
                return;
            }

            $err = $this->accountUpdate();
            if($err != ""){
                Kohana::$log->add(LOG::DEBUG, $err );
                $this->failed( $err );
                return;
            }

            $err = $this->createSubscription();
            if($err != ""){
                Kohana::$log->add(LOG::DEBUG, $err );
                $this->failed( $err );
                return;
            }
           
			$subscriptionResponse["code"] = $this->SUBS_CODE_NEW;
            Kohana::$log->add(LOG::DEBUG, "New Account/Subscription: ". $this->account_code);
            Kohana::$log->add(LOG::DEBUG, "SubscriptionID: ". $this->subscription->uuid);

        }
		 
        if ($this->subscription){
            $err = $this->getBillingInfo();
			if($err != ""){
                Kohana::$log->add(LOG::DEBUG, $err );
                $this->failed( $err );
                return;
            }
			$subscriptionResponse["id"] =  $this->subscription->uuid ;
			$subscriptionResponse["card_type"] =  $this->billing_info->card_type;
			$subscriptionResponse["last_four"] =  $this->billing_info->last_four ;
            $this->success($subscriptionResponse );
        }
	}

    //------------------- Transaction Responses ---------------------//
    /*
        General functions for REST transaction responses.
    */
    protected function failed($message){
        $this->transaction->status = Model_Transaction::Error;
        $this->transaction->message = $message;
        $this->auto_render = FALSE;
        $this->response->body( json_encode($this->transaction) );
    }

    protected function success($message){
        $this->transaction->status = Model_Transaction::Success;
        $this->transaction->message = $message;
        $this->auto_render = FALSE;
        $this->response->body( json_encode($this->transaction) );
    }

}
