<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Health extends Controller_Base {

	public function action_echo()
	{
		Kohana::$log->add(LOG::DEBUG, "TEST LOG ENTRY!");
		echo "Wrote to Log file";
   }
}