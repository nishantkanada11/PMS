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

    public function saveProduct($id, $name, $description, $price, $profile_picture, $mdescription, $brand_name, $brand_logo)
    {
        if ($id) {
            $stmt = $this->conn->prepare("UPDATE product SET name = ?, description = ?, price = ?, img = ?, mdescription = ?, brand_name = ?, brand_logo = ? WHERE id = ?");
            $stmt->bind_param("sssssssi", $name, $description, $price, $profile_picture, $mdescription, $brand_name, $brand_logo, $id);
        } else {
            $stmt = $this->conn->prepare("INSERT INTO product (name, description, price, img, mdescription, brand_name, brand_logo) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $name, $description, $price, $profile_picture, $mdescription, $brand_name, $brand_logo);
        }
        return $stmt->execute();
    }


    public function deleteProduct($id)
    {
        if (!$this->conn) {
            die("Database connection failed.");
        }

        $stmt = $this->conn->prepare("SELECT img, brand_logo FROM product WHERE id = ?");
        if (!$stmt) {
            die("SQL Prepare Error (SELECT): " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product && !empty($product['img'])) {
            $imgPath = __DIR__ . '/../../public/uploads/' . $product['img'];
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }

        if ($product && !empty($product['brand_logo'])) {
            $logoPath = __DIR__ . '/../../public/uploads/' . $product['brand_logo'];
            if (file_exists($logoPath)) {
                unlink($logoPath);
            }
        }

        $stmt = $this->conn->prepare("DELETE FROM product WHERE id = ?");
        if (!$stmt) {
            die("SQL Prepare Error (DELETE): " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function searchProducts($query = '', $brand = '')
    {
        $sql = "SELECT * FROM product WHERE (name LIKE ? OR description LIKE ? OR mdescription LIKE ? OR brand_name LIKE ? OR price LIKE ?) AND status = 'active'";

        $params = ["%$query%", "%$query%", "%$query%", "%$query%", "%$query%"];
        $types = "sssss";

        if (!empty($brand)) {
            $sql .= " AND brand_name = ?";
            $params[] = $brand;
            $types .= "s";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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

    public function getAllBrandNames()
    {
        $sql = "SELECT DISTINCT brand_name FROM product WHERE brand_name IS NOT NULL AND brand_name <> '' ORDER BY brand_name ASC";
        $result = $this->conn->query($sql);

        $brands = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $brands[] = $row['brand_name'];
            }
        }
        return $brands;
    }

    public function getPage($limit, $offset)
    {
        $sql = "SELECT * FROM product WHERE status = 'active' LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function aGetPage($limit, $offset)
    {
        $sql = "SELECT * FROM product ORDER BY id DESC LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalCount()
    {
        $sql = "SELECT COUNT(*) AS total FROM product WHERE status = 'active'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }
}