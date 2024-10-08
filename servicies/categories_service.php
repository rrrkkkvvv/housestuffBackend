<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../obj/Category.php");
$method = $_SERVER["REQUEST_METHOD"];

if ($method == "OPTIONS") {
    http_response_code(200);
    exit();
}
 

switch($method){
    case "GET":
        if(isset($_GET['id'])){


            $stmt = $category->getById( $_GET['id']);

            $categories_arr = array();
            $categories_arr["records"] = array();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);

            $category_item = array(
                "id"=>$id,
                "title"=>$title,
                "visible_title"=>$visible_title
            );

            array_push($categories_arr["records"], $category_item);
        
            

            http_response_code(200);
            echo json_encode($categories_arr);
            break;

        }else{
        $stmt = $category->get();
        $num = $stmt->rowCount();
        if($num>0){
            $categories_arr = array();
            $categories_arr["records"] = array();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $category_item = array(
                    "id"=>$id,
                    "title"=>$title,
                    "visible_title"=>$visible_title
                );
                array_push($categories_arr["records"], $category_item);
            }
            http_response_code(200);
            echo json_encode($categories_arr);
        }else{
            http_response_code(200);
            echo json_encode(array("message"=>"Categories arent found"));
        }
        break;
    }
    case "POST":
        $data  = json_decode(file_get_contents("php://input"));
        if(!empty($data->title) && !empty($data->visible_title)){
            $category->title = $data->title;
            $category->visible_title = $data->visible_title;

            if($category->create()){
                http_response_code(201);
                echo json_encode(array("message"=>"Category was created"));
            }else{
                http_response_code(503);
                echo json_encode(array("message"=>"Category creating error"));
            }
        }else{
            http_response_code(503);
            echo json_encode(array("message"=>"Cannot create a category, there is not enough data"));
        }
        break;
    case "PUT":
        $data  = json_decode(file_get_contents("php://input"));
        if(!empty($data->title) && !empty($data->visible_title)){
            $category->title = $data->title;
            $category->visible_title = $data->visible_title;
            $category->id = $data->id;
    
            if($category->update()){
                http_response_code(201);
                echo json_encode(array("message"=>"Category was updated"));
            }else{
                http_response_code(503);
                echo json_encode(array("message"=>"Category updating error"));
            }
        }else{
            http_response_code(503);
            echo json_encode(array("message"=>"Cannot update a category, there is not enough data"));
        }
        break;
    case "DELETE":
        $data = json_decode(file_get_contents("php://input"));
        
        if (!empty($data->id)) {
            $category->id = $data->id;
     
        
            if ($category->delete()) {
                http_response_code(201);
                echo json_encode(array("message" => "Category was deleted"));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Category deleting error"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Cannot delete a category, there is not enough data."));
        }
            
        break;       

    default:
        http_response_code(405);
        echo json_encode(array("message"=>"Method is not allowed"));
        break;

}