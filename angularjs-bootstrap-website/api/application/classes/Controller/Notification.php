<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Notification extends Controller_Base {


	public function action_index()
	{
        //LOG
        $ml = new Metricslogger();
        $ml->setEnv("web.". $this->config['envName']);
        $logmsg =  array(
                "page"=>Request::$client_ip
            );
        $ml->event("Notification","Recurly", $logmsg);

	    echo "Welcome to North Social.";
	}

	public function action_receive()
	{

        $this->transaction->status = Model_Transaction::Success;
        $this->transaction->message = "Notification Receive Called.";
        Kohana::$log->add(LOG::DEBUG, "Notification Receive Called: ".Request::$client_ip);



        if ($this->request->method() === HTTP_Request::POST){
            $post_xml = $this->request->body();
            if($post_xml != "")
                $this->doPost($post_xml);
            else{
                $this->transaction->status = Model_Transaction::Error;
                $this->transaction->message = "Post empty.";
            }
        }

        //Return Response
        $this->transaction->fillTransactionData();
        $strResponse = json_encode($this->transaction);
        //$this->auto_render = FALSE;
        $this->response->body($strResponse);
	}

	public function doPost($post_xml){
        //Initialize API Configurations
        $this->apiSetup();
        $this->paymentSetup();

        Kohana::$log->add(LOG::DEBUG, "PostXML: ".$post_xml);

	    $notification = new Recurly_PushNotification($post_xml);
	    $account_code = $notification->account->account_code;
	    Kohana::$log->add(LOG::DEBUG, "Account code: ".$account_code);
        switch ($notification->type) {
            case "failed_payment_notification":
            case "expired_subscription_notification":
            case "canceled_subscription_notification":
            case "canceled_account_notification":
                Controller_Authorize::notpaid($account_code, $this->config);

                $this->transaction->status = Model_Transaction::Success;
                $this->transaction->message = "Subscriber unauthorized. AccountCode: ".$account_code;
                break;
            case "reactivated_account_notification":
                Controller_Authorize::paid($account_code, $this->config);

                $this->transaction->status = Model_Transaction::Success;
                $this->transaction->message = "Subscriber authorized. AccountCode: ".$account_code;
                break;
            case "new_subscription_notification":
            case "successful_payment_notification":
                Controller_Install::install_page($account_code, $this->config);
                Controller_Authorize::paid($account_code, $this->config);

                $this->transaction->status = Model_Transaction::Success;
                $this->transaction->message = "Subscriber installed/authorized. AccountCode: ".$account_code;
                break;
            default:
                Kohana::$log->add(LOG::DEBUG, "Unknown Notification Type: ".$notification->type);
                break;
        }

	}

}
