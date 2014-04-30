<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {

	public function action_index()
	{
		require Kohana::find_file('classes', 'lib/recurly');
		$this->response->body('hello, world!');
	}

} // End Welcome
