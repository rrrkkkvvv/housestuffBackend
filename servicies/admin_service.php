<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../db/db.php");
session_start();

$database = new Database();
$db = $database->getConnection();
$input = json_decode(file_get_contents("php://input"), true);

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "OPTIONS") {
    http_response_code(200);
    exit();
}
if($method == "POST"){
    if(isset($input['method']) && $input['method'] == "login" && $input["params"]){
        login($db, $input["params"]);
    }else{
        echo json_encode(array("message" => "No valid method specified."));

    }
}else{
    http_response_code(404);
    echo json_encode(array("message" => "Method is not allowed."));
}

function login($db, $params){
    $query = "SELECT * FROM admins WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $params['username']);
    $stmt->execute();

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($params['password'],$admin['password']) ) {
        $_SESSION['admin'] = $admin['id'];
        echo json_encode(["message" => "Login successful"]);
    } else {
        echo json_encode(["message" => "Invalid credentials"]);
    }


}