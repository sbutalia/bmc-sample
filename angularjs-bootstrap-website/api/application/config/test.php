<?php defined('SYSPATH') OR die('No direct script access.');

return array(
    'envName' => 'test',
	'recurly' => array(
		'subdomain' => 'peace',
		'apiKey' => 'af6c8ef1175b47679f8801669621615d',
		'account'=> array(
			'first_name' => 'Dima',
			'last_name' => 'Sliva',
			'email' => 'ggg@gmail.com',
			'company_name' => 'peace'
		),
		'billing_info'=> array(
			'address1' => 'address1',
			'address2' => 'address2',
			'country' => 'Ukraine',
			'city' => 'Kremenchuk',
			'zip' => '39600',
			'state' => '',
			'phone' => '418 56 2517',
		),
		'credit_card'=> array(
			'verification_value' => '123',
			'number' => '4111-1111-1111-1111',
			'year' => '2014',
			'month' => '2'
		),
		'plan_code' => 'mobileentrepreneurcredit199',
		'post_xml' => array('failed_payment_notification' => '<?xml version="1.0" encoding="UTF-8"?>
																<failed_payment_notification>
																  <account>
																	<account_code>1</account_code>
																	<username nil="true">verena</username>
																	<email>verena@example.com</email>
																	<first_name>Verena</first_name>
																	<last_name>Example</last_name>
																	<company_name nil="true">Company, Inc.</company_name>
																  </account>
																  <transaction>
																	<id>a5143c1d3a6f4a8287d0e2cc1d4c0427</id>
																	<invoice_id>8fjk3sd7j90s0789dsf099798jkliy65</invoice_id>
																	<invoice_number type="integer">2059</invoice_number>
																	<subscription_id>1974a098jhlkjasdfljkha898326881c</subscription_id>
																	<invoice_number type="integer">2059</invoice_number>
																	<subscription_id>1974a098jhlkjasdfljkha898326881c</subscription_id>
																	<action>purchase</action>
																	<date type="datetime">2009-11-22T13:10:38Z</date>
																	<amount_in_cents type="integer">1000</amount_in_cents>
																	<status>Declined</status>
																	<message>This transaction has been declined</message>
																	<reference></reference>
																	<cvv_result code=""></cvv_result>
																	<avs_result code=""></avs_result>
																	<avs_result_street></avs_result_street>
																	<avs_result_postal></avs_result_postal>
																	<test type="boolean">true</test>
																	<voidable type="boolean">false</voidable>
																	<refundable type="boolean">false</refundable>
																  </transaction>
																</failed_payment_notification>'),
					array('expired_subscription_notification' => '<?xml version="1.0" encoding="UTF-8"?>
																	<expired_subscription_notification>
																	  <account>
																		<account_code>1</account_code>
																		<username nil="true"></username>
																		<email>verena@example.com</email>
																		<first_name>Verena</first_name>
																		<last_name>Example</last_name>
																		<company_name nil="true"></company_name>
																	  </account>
																	  <subscription>
																		<plan>
																		  <plan_code>1dpt</plan_code>
																		  <name>Subscription One</name>
																		</plan>
																		<uuid>d1b6d359a01ded71caed78eaa0fedf8e</uuid>
																		<state>expired</state>
																		<quantity type="integer">1</quantity>
																		<total_amount_in_cents type="integer">200</total_amount_in_cents>
																		<activated_at type="datetime">2010-09-23T22:05:03Z</activated_at>
																		<canceled_at type="datetime">2010-09-23T22:05:43Z</canceled_at>
																		<expires_at type="datetime">2010-09-24T22:05:03Z</expires_at>
																		<current_period_started_at type="datetime">2010-09-23T22:05:03Z</current_period_started_at>
																		<current_period_ends_at type="datetime">2010-09-24T22:05:03Z</current_period_ends_at>
																		<trial_started_at nil="true" type="datetime">
																		</trial_started_at><trial_ends_at nil="true" type="datetime"></trial_ends_at>
																	  </subscription>
																	</expired_subscription_notification>'),
					array('canceled_subscription_notification' => '<?xml version="1.0" encoding="UTF-8"?>
																	<canceled_subscription_notification>
																	  <account>
																		<account_code>1</account_code>
																		<username nil="true"></username>
																		<email>verena@example.com</email>
																		<first_name>Verena</first_name>
																		<last_name>Example</last_name>
																		<company_name nil="true"></company_name>
																	  </account>
																	  <subscription>
																		<plan>
																		  <plan_code>1dpt</plan_code>
																		  <name>Subscription One</name>
																		</plan>
																		<uuid>dccd742f4710e78515714d275839f891</uuid>
																		<state>canceled</state>
																		<quantity type="integer">1</quantity>
																		<total_amount_in_cents type="integer">200</total_amount_in_cents>
																		<activated_at type="datetime">2010-09-23T22:05:03Z</activated_at>
																		<canceled_at type="datetime">2010-09-23T22:05:43Z</canceled_at>
																		<expires_at type="datetime">2010-09-24T22:05:03Z</expires_at>
																		<current_period_started_at type="datetime">2010-09-23T22:05:03Z</current_period_started_at>
																		<current_period_ends_at type="datetime">2010-09-24T22:05:03Z</current_period_ends_at>
																		<trial_started_at nil="true" type="datetime"></trial_started_at>
																		<trial_ends_at nil="true" type="datetime"></trial_ends_at>
																	  </subscription>
																	</canceled_subscription_notification>'),
					array('canceled_account_notification' => '<?xml version="1.0" encoding="UTF-8"?>
																<canceled_account_notification>
																  <account>
																	<account_code>1</account_code>
																	<username nil="true"></username>
																	<email>verena@example.com</email>
																	<first_name>Verena</first_name>
																	<last_name>Example</last_name>
																	<company_name nil="true"></company_name>
																  </account>
																</canceled_account_notification>'),
					array('reactivated_account_notification' => '<?xml version="1.0" encoding="UTF-8"?>
																	<reactivated_account_notification>
																	  <account>
																		<account_code>1</account_code>
																		<username nil="true"></username>
																		<email>verena@example.com</email>
																		<first_name>Verena</first_name>
																		<last_name>Example</last_name>
																		<company_name nil="true"></company_name>
																	  </account>
																	  <subscription>
																		<plan>
																		  <plan_code>bootstrap</plan_code>
																		  <name>Bootstrap</name>
																		</plan>
																		<uuid>6ab458a887d38070807ebb3bed7ac1e5</uuid>
																		<state>active</state>
																		<quantity type="integer">1</quantity>
																		<total_amount_in_cents type="integer">9900</total_amount_in_cents>
																		<activated_at type="datetime">2010-07-22T20:42:05Z</activated_at>
																		<canceled_at nil="true" type="datetime"></canceled_at>
																		<expires_at nil="true" type="datetime"></expires_at>
																		<current_period_started_at type="datetime">2010-09-22T20:42:05Z</current_period_started_at>
																		<current_period_ends_at type="datetime">2010-10-22T20:42:05Z</current_period_ends_at>
																		<trial_started_at nil="true" type="datetime"></trial_started_at>
																		<trial_ends_at nil="true" type="datetime"></trial_ends_at>
																	  </subscription>
																	</reactivated_account_notification>'),
					array('new_subscription_notification' => '<?xml version="1.0" encoding="UTF-8"?>
																<new_subscription_notification>
																  <account>
																	<account_code>1</account_code>
																	<username nil="true">verena</username>
																	<email>verena@example.com</email>
																	<first_name>Verena</first_name>
																	<last_name>Example</last_name>
																	<company_name nil="true">Company, Inc.</company_name>
																  </account>
																  <subscription>
																	<plan>
																	  <plan_code>bronze</plan_code>
																	  <name>Bronze Plan</name>
																	  <version type="integer">2</version>
																	</plan>
																	<uuid>8047cb4fd5f874b14d713d785436ebd3</uuid>
																	<state>active</state>
																	<quantity type="integer">2</quantity>
																	<total_amount_in_cents type="integer">2000</total_amount_in_cents>
																	<activated_at type="datetime">2009-11-22T13:10:38Z</activated_at>
																	<canceled_at type="datetime"></canceled_at>
																	<expires_at type="datetime"></expires_at>
																	<current_period_started_at type="datetime">2009-11-22T13:10:38Z</current_period_started_at>
																	<current_period_ends_at type="datetime">2009-11-29T13:10:38Z</current_period_ends_at>
																	<trial_started_at type="datetime">2009-11-22T13:10:38Z</trial_started_at>
																	<trial_ends_at type="datetime">2009-11-29T13:10:38Z</trial_ends_at>
																  </subscription>
																</new_subscription_notification>'),
					array('successful_payment_notification' => '<?xml version="1.0" encoding="UTF-8"?>
																<successful_payment_notification>
																  <account>
																	<account_code>1</account_code>
																	<username nil="true">verena</username>
																	<email>verena@example.com</email>
																	<first_name>Verena</first_name>
																	<last_name>Example</last_name>
																	<company_name nil="true">Company, Inc.</company_name>
																  </account>
																  <transaction>
																	<id>a5143c1d3a6f4a8287d0e2cc1d4c0427</id>
																	<invoice_id>1974a09kj90s0789dsf099798326881c</invoice_id>
																	<invoice_number type="integer">2059</invoice_number>
																	<subscription_id>1974a098jhlkjasdfljkha898326881c</subscription_id>
																	<action>purchase</action>
																	<date type="datetime">2009-11-22T13:10:38Z</date>
																	<amount_in_cents type="integer">1000</amount_in_cents>
																	<status>success</status>
																	<message>Bogus Gateway: Forced success</message>
																	<reference></reference>
																	<cvv_result code=""></cvv_result>
																	<avs_result code=""></avs_result>
																	<avs_result_street></avs_result_street>
																	<avs_result_postal></avs_result_postal>
																	<test type="boolean">true</test>
																	<voidable type="boolean">true</voidable>
																	<refundable type="boolean">true</refundable>
																  </transaction>
																</successful_payment_notification>')

	),
	'wufoo' => array(
		'subdomain' => 'devrkm',
		'apiKey' => '74QT-C7JD-W0FN-Z9TH'
	),
	'api' => array(
		'url' => array(
			'install' => 'http://dev-socialapps.rkm-group.com/app/default/install/',
			'authorize' => 'http://dev-socialapps.rkm-group.com/authorize/isSubscriber/'
		),
		'APIKey' => 'k7GQOxXwF12',
		'APIPassword' => 'z6qBsdDziF'
	)
);