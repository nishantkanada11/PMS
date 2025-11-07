<?php
class User
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function findByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = ?");
        if (!$stmt) {
            die("Query preparation failed: " . $this->conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : null;
    }

    // pf update
    public function updateProfileByEmail($email, $name, $mobile, $password = null)
    {
        if ($password) {
            $stmt = $this->conn->prepare("UPDATE user SET name=?, mobile=?, password=? WHERE email=?");
            $stmt->bind_param("ssss", $name, $mobile, $password, $email);
        } else {
            $stmt = $this->conn->prepare("UPDATE user SET name=?, mobile=? WHERE email=?");
            $stmt->bind_param("sss", $name, $mobile, $email);
        }

        if (!$stmt) {
            die("Query preparation failed: " . $this->conn->error);
        }

        return $stmt->execute();
    }

    public function saveProduct($id, $name, $description, $price, $profile_picture, $mdescription)
    {
        if ($id) {
            $stmt = $this->conn->prepare("UPDATE product SET name = ?, description = ?, price = ?, img = ?, mdescription = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $name, $description, $price, $profile_picture, $mdescription, $id);
        } else {
            $stmt = $this->conn->prepare("INSERT INTO product (name, description, price, img, mdescription) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $description, $price, $profile_picture, $mdescription);
        }
        return $stmt->execute();
    }


    public function getAllProducts()
    {
        $query = "SELECT * FROM product ORDER BY id DESC";
        $result = $this->conn->query($query);

        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }

    public function deleteProduct($id)
    {
        // First, get image file name to remove from uploads folder
        $stmt = $this->conn->prepare("SELECT img FROM product WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product && !empty($product['img'])) {
            $filePath = __DIR__ . '/../../public/uploads/' . $product['img'];
            if (file_exists($filePath)) {
                unlink($filePath); // Delete the image file
            }
        }
        $stmt = $this->conn->prepare("DELETE FROM product WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }


    public function getActiveProducts()
    {
        $sql = "SELECT * FROM product WHERE status = 'active' ORDER BY id DESC";
        $result = $this->conn->query($sql);

        $products = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function updateProductStatus($id, $status)
    {
        $sql = "UPDATE product SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }
    public function getProductById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM product WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function search($keyword)
    {
        $keyword = "%" . $keyword . "%";
        $stmt = $this->conn->prepare("
            SELECT * FROM product 
            WHERE CONCAT(id,name, description, price, mdescription) LIKE ?
            ORDER BY id DESC
        ");
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }

}