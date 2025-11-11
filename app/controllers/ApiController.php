<?php
class ApiController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
        header('Content-Type: application/json');
    }

    public function getProducts()
    {
        $products = $this->userModel->aGetPage(100, 0);
        echo json_encode(["status" => "success", "data" => $products]);
    }

    public function getProduct()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo json_encode(["status" => "error", "message" => "Product ID required"]);
            return;
        }

        $product = $this->userModel->getProductById($id);
        echo json_encode($product ? ["status" => "success", "data" => $product] : ["status" => "error", "message" => "Not found"]);
    }

    public function saveProduct()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input) {
            echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
            return;
        }

        $id = $_GET['id'] ?? null; 

        //for new producr validation
        if (!$id && (empty($input['name']) || empty($input['description']) || empty($input['price']))) {
            echo json_encode(["status" => "error", "message" => "Missing fields"]);
            return;
        }

        $name = $input['name'] ?? null;
        $description = $input['description'] ?? null;
        $price = $input['price'] ?? null;
        $img = $input['img'] ?? null;
        $mdescription = $input['mdescription'] ?? '';
        $brand_name = $input['brand_name'] ?? '';
        $brand_logo = $input['brand_logo'] ?? '';

        $result = $this->userModel->saveProduct($id, $name, $description, $price, $img, $mdescription, $brand_name, $brand_logo);

        // reesponse
        if ($result) {
            if ($id) {
                $updatedProduct = $this->userModel->getProductById($id);
                echo json_encode([
                    "status" => "success",
                    "message" => "Product updated successfully",
                    "data" => $updatedProduct
                ]);
            } else {
                echo json_encode(["status" => "success", "message" => "Product created successfully"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => $id ? "Failed to update product" : "Failed to create product"]);
        }
    }

    public function deleteProduct()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo json_encode(["status" => "error", "message" => "Product ID required"]);
            return;
        }
        $deleted = $this->userModel->deleteProduct($id);
        echo json_encode($deleted ? ["status" => "success", "message" => "Deleted"] : ["status" => "error", "message" => "Delete failed"]);
    }
}
