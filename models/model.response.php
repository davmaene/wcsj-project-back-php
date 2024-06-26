<?php
class Response
{

    public $status;
    public $statusText;
    public $data;

    public function __construct($status, $body)
    {
        $this->status = $status;
        $this->statusText = $this->writeResponse($status);
        $this->data = is_object($body) ? get_object_vars($body) : $body;
        http_response_code($status);
        header("HTTP/1.1 $status $this->statusText");
    }
    public function print()
    {
        $jsonData = (json_encode($this, JSON_PRETTY_PRINT));
        if ($jsonData === false) {
            return "Erreur JSON: " . json_last_error_msg();
        } else return $jsonData;
    }
    private function writeResponse($code = 0)
    {
        $code = (int) $code;
        switch ($code) {
            case 200:
                return "=> success execution";
                // break;
            case 500:
                return "=> server error";
                // break;
            case 205:
                return "=> missing valid or invalid param passed throught the function";
                // break;
            case 405:
                return "=> Methode not allowed !";
                // break;
            case 404:
                return "=> client request could not be process";
                // break;
            case 403:
                return "=> dont have access to ressource, password or user name incorrect";
                // break;
            case 401:
                return "=> dont have access to this server";
                // break;
            default:
                return "=> unknown server error ";
                // break;
        }
    }
    public function getStatus()
    {
        return (int) $this->status;
    }
    public function getstatusText()
    {
        return $this->statusText;
    }
    public function getBody()
    {
        return $this->data;
    }
}
