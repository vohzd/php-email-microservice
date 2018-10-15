<?php

require "vendor/autoload.php";
use Mailgun\Mailgun;

if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Max-Age: 86400");
}

if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
  if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"])){
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
  }

  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])){
    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
  }

  exit(0);
}


if ($_SERVER["REQUEST_METHOD"] === "GET"){
  echo "Use POST instead :D";
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
  $content = trim(file_get_contents("php://input"));
  $decoded = json_decode($content, true);

  if(!is_array($decoded)){
      throw new Exception("Received content contained invalid JSON!");
  }

  $mailgun = new Mailgun("key-820ec8fedd020cd2c1e32edfa345779b", new \Http\Adapter\Guzzle6\Client());
  //$domain = "sandbox231ef7c0b0a24a31b509f2e2b3d3e849.mailgun.org";
  $domain = "vohzd.com";

  $result = $mailgun->sendMessage($domain, array(
    "from"    => $decoded["name"] . " " . $decoded["email"],
    "to"      => "<allobon@gmail.com>",
    "subject" => $decoded["subject"],
    "text"    => $decoded["message"]
  ));

  echo json_encode(array("success" => true ));
}



?>
