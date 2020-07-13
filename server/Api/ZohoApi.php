<?php
include 'curlApi.php';
include 'config.php';

class ZohoApi{
  protected $access_token;
  protected $curl;

  function __construct(){
    // Set Module to cURL
    $this->curl = new cURL;
    $this->generateAceessToken();
  }

  // Generate Aceess Token
  public function generateAceessToken(){
    global $config;

    $curl = new $this->curl();
    $curl->setURL('https://accounts.zoho.com/oauth/v2/token');
    // Set Params to cURL
    $curl->setParams(http_build_query($config));
    $response = $curl->send();
    // Save access token
    $this->access_token = $response->access_token;
    $curl->close();
  }
  
  // Search Lead
  public function searchLead($query){
    $curl = new $this->curl();
    $curl->setModule('Leads/search?' . http_build_query($query));
    $curl->setHeader('Authorization: Zoho-oauthtoken ' . $this->access_token);
    $response = $curl->send();
    // Save access token
    $curl->close();
    return $response;
  }

  // Insert Lead
  public function insertLead($data){
    $curl = new $this->curl();
    $post_data = [
      "data" => [
        [
          "Company" => $data['company'],
          "Last_Name" => $data['last_name'],
          "First_Name" => $data['first_name'],
          "Email" => $data['email'],
          "State" => "Russia",
          "Phone" => $data['phone']
        ]
      ],
      "trigger" => [
        "approval",
        "workflow",
        "blueprint"
      ]
    ];

    $curl->setModule('Leads');
    $curl->setParams(json_encode($post_data));
    $curl->setHeader('Authorization: Zoho-oauthtoken ' . $this->access_token);
    
    $response = $curl->send();
    $curl->close();
    return $response;
  }
  
  // Convert Lead
  public function convertLead($leadID, $data){
    $curl = new $this->curl();
    $post_data = [
      "data" => [
        [
          "overwrite" => true,
          "notify_lead_owner" => true,
          "notify_new_entity_owner" => true,
          "Deals" => [
            "Deal_Name" => "Сделка с " . $data['company'],
            "Closing_Date" => date("Y-m-d"),
            "Stage" => "Оценка пригодности",
            "Amount" => (float)$data['amount']
          ]
        ]
      ]
    ];
    $curl->setModule('Leads/' . $leadID . '/actions/convert');
    $curl->setParams(json_encode($post_data));
    $curl->setHeader('Authorization: Zoho-oauthtoken ' . $this->access_token);

    $response = $curl->send();
    $curl->close();
    return $response;
  }
}