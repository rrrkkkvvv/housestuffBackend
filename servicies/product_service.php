<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];

include_once("../obj/Product.php");

if ($method == "OPTIONS") {
    http_response_code(200);
    exit();
}



 

switch ($method) {
    case "GET":
        if(isset($_GET['id'])){


            $stmt = $product->getById( $_GET['id']);

            $products_arr = array();
            $products_arr["records"] = array();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);

            $product_item = array(
                "id" => $id,
                "title" => $title,
                "img" => $img,
                "description" => html_entity_decode($description),
                "fullDesc" => html_entity_decode($fullDesc),
                "price" => $price,
                "category" => $category
            );

            array_push($products_arr["records"], $product_item);
        
            

            http_response_code(200);
            echo json_encode($products_arr);
            break;

        }else{

        
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 6;
        $category = isset($_GET['category']) ? $_GET['category'] : "all";


        $stmt = $product->get($page, $limit, $category);

        $num = $stmt->rowCount();
        if ($num > 0) {
            $products_arr = array();
            $products_arr["records"] = array();
            $products_arr["pagination"] = array(
                "page"=> $page,
                "limit"=>$limit,
                "total"=>$product->count($category)
            );  
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $product_item = array(
                    "id" => $id,
                    "title" => $title,
                    "img" => $img,
                    "description" => html_entity_decode($description),
                    "fullDesc" => html_entity_decode($fullDesc),
                    "price" => $price,
                    "category" => $category
                );

                array_push($products_arr["records"], $product_item);
            }

            http_response_code(200);
            echo json_encode($products_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Products aren't found."));
        }
        break;
    }
    case "POST":
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->title) && !empty($data->category) && !empty($data->description) && !empty($data->fullDesc) && !empty($data->price) && !empty($data->img)) {
            $product->title = $data->title;
            $product->fullDesc = $data->fullDesc;
            $product->description = $data->description;
            $product->price = $data->price;
            $product->category = $data->category;
            $product->img = $data->img;

            if ($product->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "Product was created"));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Product creating error"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Cannot create a product, there is not enough data."));
        }

        break;
    case "PUT":
        $data = json_decode(file_get_contents("php://input"));
    
        if (!empty($data->title) && !empty($data->category) && !empty($data->description) && !empty($data->fullDesc) && !empty($data->price) && !empty($data->img)) {
            $product->title = $data->title;
            $product->fullDesc = $data->fullDesc;
            $product->description = $data->description;
            $product->price = $data->price;
            $product->category = $data->category;
            $product->img = $data->img;
            $product->id = $data->id;

            if ($product->update()) {
                http_response_code(201);
                 echo json_encode(array("message" => "Product was updated"));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Product updating error"));
            }
        } else {
               http_response_code(400);
            echo json_encode(array("message" => "Cannot update a product, there is not enough data."));
        }
    
        break;
    case "DELETE":
        $data = json_decode(file_get_contents("php://input"));
    
        if (!empty($data->id)) {
            $product->id = $data->id;
 
    
            if ($product->delete()) {
                http_response_code(201);
                echo json_encode(array("message" => "Product was deleted"));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Product deleting error"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Cannot delete a product, there is not enough data."));
        }
        
        break;
    
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method is not allowed."));
        break;
}
