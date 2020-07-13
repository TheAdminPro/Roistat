<?php 
// tmp
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

// Include
include './Api/Api.php';
include './Api/ZohoApi.php';

// Init
$api = new Api();
$zoho = new ZohoApi();

$api->post("/create-lead", function ($param, $data) {
  global $zoho;
  $response;

  // Set Modules to cURL
  $searcherLead = $zoho->searchLead(['phone' => $data['phone']]);
  if(empty($searcherLead)){
    // Insert Lead
    $response = $zoho->insertLead($data);
  }else{
    // Convert Lead
    $leadID = $searcherLead->data[0]->id;
    $response = $zoho->convertLead($leadID, $data);
  }

  echo json_encode($response);
});