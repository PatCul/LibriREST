<?php

    require "pdo.php";

    header("Content-Type: application/json");
    $request_method = $_SERVER["REQUEST_METHOD"];

    switch($request_method){
        case "GET":
            //codice del GET
            
            $stmt = $pdo->query("SELECT * FROM libri");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($data);

            break;

        case "POST":
        //codice del POST
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid JSON"]);
            break;
        }

        if (isset($data["titolo"]) && isset($data["autore"]) && isset($data["anno"])) {
            
            //se ID autoincrement basta rimuovere ID da qua
            $stmt = $pdo->prepare("
                INSERT INTO libri (titolo, autore, anno)
                VALUES (?,?,?)
            ");
            $stmt->execute([
                $data["titolo"],
                $data["autore"],
                $data["anno"]
            ]);

            http_response_code(201);
        
            $response = [
                "libro" => $data,
                "message" => "Created"
            ];

            echo json_encode($response);
        }else{
            http_response_code(400);
            echo json_encode(["message" => "Bad Request"]);
        }

        break;

        case "DELETE":
        //codice del DELETE
        
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid JSON"]);
            break;
        }

        $libro_id = $data["id"] ?? null;

        if($libro_id){

            $stmt = $pdo->prepare("DELETE 
            FROM libri 
            WHERE id=? 
            ");
            $stmt->execute([$libro_id]);
            
            if ($stmt->rowCount() > 0) {
                http_response_code(200);
                echo json_encode(["message" => "OK"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Not Found"]);
            }
            
        }else{
            http_response_code(400);
            echo json_encode(["message" => "Bad Request"]);
        }

        break;

        case "PUT":
        //codice del PUT
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid JSON"]);
            break;
        }

        if (isset($data["id"]) && isset($data["titolo"]) && isset($data["autore"]) && isset($data["anno"])) {
            
            $stmt = $pdo->prepare("UPDATE libri 
            SET titolo = ?, 
            autore = ?, 
            anno = ? 
            WHERE id = ?
            ");
            $stmt->execute([
                $data["titolo"],
                $data["autore"],
                $data["anno"],
                $data["id"]
            ]);

            if ($stmt->rowCount() > 0) {
                http_response_code(200);
                echo json_encode(["message" => "OK"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Not Found"]);
            }
        }else{
            http_response_code(400);
            echo json_encode(["message" => "Bad Request"]);
        }

        break;

        default:
            http_response_code(405);
            echo json_encode(["message" => "Method Not Allowed"]);
            break;    

    }
?>
