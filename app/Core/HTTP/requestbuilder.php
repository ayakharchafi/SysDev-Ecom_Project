<?php

namespace core\http;

require("request.php");

class RequestBuilder{

    public function getRequest(){

        $method = $this->getRequestMethod();
        $url = $_SERVER['REQUEST_URI'];
        $headers = getallheaders();
        $body = file_get_contents("php://input");        
        $postFields = $_POST;
        $params =  $this->getURLParams();

        return new Request($method, $url, $headers, $body, $params, $postFields);
    }

    private function getRequestMethod(){

        $requestMethod = "";

        if(isset($this->getURLParams()[1])) {
            $requestMethod = $this->getURLParams()[1];
        }

        switch($requestMethod) {
            case 'list': $requestMethod = 'GET';
                break;
            case 'import': $requestMethod = 'POST';
                break;
            default:
                $requestMethod =  $_SERVER["REQUEST_METHOD"];
        }

        return $requestMethod;
    }

    function getURLParams() {
        return explode("/", trim($_GET["url"], "/") );
    }
}