<?php
    /**
    * north-contact-signup
    * This script is used for north-contact sign-up.
    */

    $username = "aaa8b9fcf02953f3e67d051e20e904e6";
    $password = "magic";
    $url1 = "http://api.createsend.com/api/v3/clients.json";
    $company = $_REQUEST['company'];
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $country = $_REQUEST['country'];
    $username1 = $_REQUEST['username'];
    $password1 = $_REQUEST['password'];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, '{CompanyName:"'.$company.'", ContactName:"'.$name.'", EmailAddress: "'.$email.'", Country: "'.$country.'", "TimeZone": "(GMT-08:00) Pacific Time (US & Canada)"}');
    curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_URL, $url1);
    echo $result = curl_exec($curl);
    curl_close($curl);
    $result = trim($result, '"');

    if($result) 
    {
	    $resultList = "bf64e373ea966424294c3949dfc9d95c";
	    $url3 = "http://api.createsend.com/api/v3/subscribers/".$resultList.".json";
	    $c = curl_init();
	    curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 2);
	    curl_setopt($c, CURLOPT_HEADER, false);
	    curl_setopt($c, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($c, CURLOPT_POST, 1);
	    curl_setopt($c, CURLOPT_POSTFIELDS, '{ "EmailAddress": "'.$email.'", "Name": "'.$name.'", "CustomFields": [{"Key": "website",Value: "http://northsocial.com"}],"Resubscribe": true}');
	    curl_setopt($c, CURLOPT_USERPWD, "$username:$password");
	    curl_setopt($c, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	    curl_setopt($c, CURLOPT_URL, $url3);
	    $result2 = curl_exec($c);
	    $entry = '{"Username":"'.$username1.'", "Password":"'.$password1.'", "AccessLevel": "63"}';
	    $tmpfile = tmpfile();
	    fwrite($tmpfile, $entry);
	    fseek($tmpfile, 0);
	    $headers = array(
			        'Accept: application/json',
			        'Content-Type: application/json',
			    );
	    $url2 = "http://api.createsend.com/api/v3/clients/$result/setaccess.json";
	    $ch = curl_init($url2);
	    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	    curl_setopt($ch, CURLOPT_INFILE, $tmpfile);
	    curl_setopt($ch, CURLOPT_PUT, 1);
	    curl_setopt($ch, CURLOPT_INFILESIZE, strlen($entry));
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_HEADER, false);
	    // Do not return headers
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
	    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	    $result_username = curl_exec($ch);
	    fclose($tmpfile);
	    curl_close($ch);
	    $entry_billing = '{"Username":"'.$username1.'", "Password":"'.$password1.'", "Currency": "USD", "CanPurchaseCredits": true, "ClientPays": true, "MarkupPercentage": 60, "MarkupOnDelivery":3, "MarkupPerRecipient":.6,"MarkupOnDesignSpamTest":3}';
	    $tmpfile_billing = tmpfile();
	    fwrite($tmpfile_billing, $entry_billing);
	    fseek($tmpfile_billing, 0);
	    $headers = array(
			        'Accept: application/json',
			        'Content-Type: application/json',
			    );
	    $url_billing = "http://api.createsend.com/api/v3/clients/$result/setpaygbilling.json";
	    $c = curl_init($url_billing);
	    curl_setopt($c, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	    curl_setopt($c, CURLOPT_USERPWD, "$username:$password");
	    curl_setopt($c, CURLOPT_INFILE, $tmpfile_billing);
	    curl_setopt($c, CURLOPT_PUT, 1);
	    curl_setopt($c, CURLOPT_INFILESIZE, strlen($entry_billing));
	    curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($c, CURLOPT_HEADER, false);
	    // Do not return headers
	    curl_setopt($c, CURLOPT_RETURNTRANSFER, 0);
	    curl_setopt($c, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	    $result_billing = curl_exec($c);
	    fclose($tmpfile_billing);
	    curl_close($c);
    }
?>
