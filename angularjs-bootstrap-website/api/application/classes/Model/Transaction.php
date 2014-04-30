<?php defined('SYSPATH') or die('No direct script access');

/**
 * Status returned on each transaction
 *
 */
class Model_Transaction{
    const Info = "Info";
    const Success = "Success";
    const Error = "Error";
    const Warning = "Warning";

    //TODO: implement getter setters
    public $status = "";
    public $code = "";
    public $message = "";
    public $transactionID = "";
    public $timestamp = "";

    public function fillTransactionData(){
        $this->transactionID = uniqid();
        $this->timestamp = time();
    }
}