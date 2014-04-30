<?php

/*
    EVENTS:
    RequestReceived
    DBUpdate
    Info
*/
class Createsend
{
    //https://www.loggly.com/docs/api-sending-data/#tags
	protected $logglyUrl = "https://logs-01.loggly.com/inputs/f10600ad-fddb-4a3d-8227-875252619851/tag/{tag}/";

    //curl -X POST http://logs100.jixee.me:9200/simran/1 -d '{"value":"data"}'
    protected $elasticSearch = "http://logs100.jixee.me:9200/simran/1";
    protected $APP_ENV;

	public function getLogglyURL(){
        $newUrl = $this->logglyUrl;

        $env = "";
        if($this->APP_ENV)
            $env = $this->APP_ENV;
        else
           $env = APP_ENV;

        $newUrl = str_replace("{tag}", $env.",socialapps", $newUrl );
        return $newUrl;
    }

    public function setEnv($env){
        $this->APP_ENV = $env;
    }

    public function event($event, $type, $arr){
            $default =  array(
                            "event"=>$event,
                            "type"=>$type,
                            "ip" => $_SERVER['REMOTE_ADDR']
                       );
            $newMessage = array_merge($default,$arr);
            $jsonMessage = json_encode($newMessage);

            if(class_exists(Kohana))
                Kohana::$log->add(LOG::INFO, $jsonMessage);

            $myUrl = $this->getLogglyURL();
            $this->post_without_wait_socket($myUrl, $jsonMessage);
        }

    public function sendDetailed($app, $type, $arr){
        $default =  array(
                       "type"=>$type,
                       "app"=>$app,
                       "ip" => $_SERVER['REMOTE_ADDR']
                   );
        $newMessage = array_merge($default,$arr);
        $jsonMessage = json_encode($newMessage);
        Kohana::$log->add(LOG::INFO, $jsonMessage);

        $myUrl = $this->getLogglyURL();
        $this->post_without_wait_socket($myUrl, $jsonMessage);
    }

    public function send($message){
        Kohana::$log->add(LOG::INFO, $message);
        $jsonMessage = json_encode(
                            array(
                                "ip" => $_SERVER['REMOTE_ADDR'],
                                "message" => $message
                            )
                        );

        $myUrl = $this->getLogglyURL();

        //$request = Request::factory($myUrl)
          //->method('POST');
          //->post('key', 'value');
        //$response = $request->execute();

        $this->post_without_wait_socket($myUrl, $jsonMessage);
        //echo $response->body();
    }

    function post_without_wait_curl($url, $data, $optional_headers = null,$getresponse = false) {
          $params = array('http' => array(
                       'method' => 'POST',
                       'content' => $data
                    ));
          if ($optional_headers !== null) {
             $params['http']['header'] = $optional_headers;
          }
          $ctx = stream_context_create($params);
          $fp = @fopen($url, 'rb', false, $ctx);
          if (!$fp) {
            return false;
          }
          if ($getresponse){
            $response = stream_get_contents($fp);
            return $response;
          }
        return true;
    }

    function post_without_wait_socket($url, $post_string)
    {
    /*
        foreach ($params as $key => &$val) {
          if (is_array($val)) $val = implode(',', $val);
            $post_params[] = $key.'='.urlencode($val);
        }
        */
        //$post_string = implode('&', $post_params);

        $parts=parse_url($url);

        $fp = fsockopen($parts['host'],
            isset($parts['port'])?$parts['port']:80,
            $errno, $errstr, 30);

        $out = "POST ".$parts['path']." HTTP/1.1\r\n";
        $out.= "Host: ".$parts['host']."\r\n";
        $out.= "Content-Type: application/json\r\n";
        $out.= "Content-Length: ".strlen($post_string)."\r\n";
        $out.= "Cache-Control: no-cache\r\n\r\n";
        //$out.= "Content-Length: 0\r\n";
        //$out.= "Connection: Close\r\n\r\n";
        if (isset($post_string)) $out.= $post_string;
        if(class_exists(Kohana))
            Kohana::$log->add(LOG::INFO, $out);
        fwrite($fp, $out);
        fclose($fp);
    }


}