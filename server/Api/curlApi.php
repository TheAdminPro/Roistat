<?php

class cURL{
  protected $ch;
  protected $headers = ['Content-Type: application/x-www-form-urlencoded'];
  protected $baseURL = 'https://www.zohoapis.com/crm/v2/';

  public function __construct() {
    $this->ch = curl_init();

    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
  }

  public function setModule($module){
    $url = $this->baseURL . $module;
    curl_setopt($this->ch, CURLOPT_URL, $url);
  }

  public function setURL($URL){
    curl_setopt($this->ch, CURLOPT_URL, $URL);
  }

  public function setParams($data){
    curl_setopt($this->ch, CURLOPT_POST, 1);
    curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
  }

  public function setHeader($header){
    $this->headers[] = $header;
    curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
  }

  public function send(){
    $response = curl_exec($this->ch);
    return json_decode($response);
  }

  public function close(){
    curl_close($this->ch);
  }
}