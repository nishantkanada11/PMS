<?php
class UserController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
    }

    public function login()
    {
        require __DIR__ . '/../views/users/login.php';
    }

    public function authenticate()
    {


        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            $error = "Email and Password are required.";
            require __DIR__ . '/../views/users/login.php';
            return;
        }

        $user = $this->userModel->findByEmail($email);

        if ($user && $password === $user['password']) {
            header("Location: index.php?controller=User&action=aindex");
            exit;
        } else {
            $error = "Invalid email or password.";
            require __DIR__ . '/../views/users/login.php';
            return;
        }
    }

    public function aindex()
    {

        $products = $this->userModel->getAllProducts();
        require __DIR__ . '/../views/admin/index.php';
    }

    public function aedit()
    {
        $email = "admin@gmail.com";
        $user = $this->userModel->findByEmail($email);
        require __DIR__ . '/../views/admin/edit.php';
    }

    public function updateProfile()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $mobile = $_POST['mobile'] ?? '';
        $password = $_POST['password'] ?? null;

        if (!$name || !$email || !$mobile) {
            echo "<script>alert('All fields except password are required.'); window.history.back();</script>";
            return;
        }

        $updated = $this->userModel->updateProfileByEmail($email, $name, $mobile, $password ?: null);

        if ($updated) {
            echo "<script>alert('Profile updated successfully!');window.location='index.php?controller=User&action=aindex';</script>";
        } else {
            echo "<script>alert('Failed to update profile.');window.location='index.php?controller=User&action=adit';</script>";
        }
    }

    public function saveProduct()
    {
        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $mdescription = trim($_POST['mdescription'] ?? '');

        if (empty($name) || empty($description) || empty($price) || empty($mdescription)) {
            echo "<script>alert('All fields are required.'); window.history.back();</script>";
            return;
        }

        $profilePicName = null;
        $targetDir = __DIR__ . '/../../public/uploads/';

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (!empty($_FILES['profile_picture']['name'])) {
            $fileTmp = $_FILES['profile_picture']['tmp_name'];
            $fileName = basename($_FILES['profile_picture']['name']);
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (!in_array($ext, $allowedExts)) {
                echo "<script>alert('Invalid file type. Only JPG, PNG, GIF, or WEBP allowed.'); window.history.back();</script>";
                return;
            }

            $profilePicName = 'product_' . time() . '.' . $ext;

            if (!move_uploaded_file($fileTmp, $targetDir . $profilePicName)) {
                echo "<script>alert('Failed to upload image.'); window.history.back();</script>";
                return;
            }
        }

        if ($id) {
            // If editing and no new image uploaded, keep the old one
            if (empty($profilePicName)) {
                $oldProduct = $this->userModel->getProductById($id);
                $profilePicName = $oldProduct['img'] ?? null;
            }

            $this->userModel->saveProduct($id, $name, $description, $price, $profilePicName, $mdescription);
        } else {
            $this->userModel->saveProduct(null, $name, $description, $price, $profilePicName, $mdescription);
        }

        header("Location: index.php?controller=User&action=aindex");
        exit;
    }



    public function pcreate()
    {
        require __DIR__ . '/../views/admin/create.php';
    }

    public function pedit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "Invalid product ID.";
            return;
        }

        $product = $this->userModel->getProductById($id);
        if (!$product) {
            echo "Product not found.";
            return;
        }

        require __DIR__ . '/../views/admin/pedit.php';
    }

    public function delete()
    {

        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Invalid product ID.";
            return;
        }
        $deleted = $this->userModel->deleteProduct($id);

        header("Location: index.php?controller=User&action=aindex&msg=deleted");
        exit;

    }
    public function showActiveProducts()
    {
        $products = $this->userModel->getActiveProducts();
        require __DIR__ . '/../views/users/index.php';
    }

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $status = $_POST['status'] ?? null;

            if ($id && $status) {
                $result = $this->userModel->updateProductStatus($id, $status);
                echo $result ? "Status updated successfully!" : "Failed to update status.";
            } else {
                echo "<script>alert('Invalid request data.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Invalid request method.'); window.history.back();</script>";
        }
    }


    public function show()
    {
        if (!isset($_GET['id'])) {
            echo "<script>alert('Product ID is missing!'); window.history.back();</script>";
            return;
        }

        $id = $_GET['id'];
        $product = $this->userModel->getProductById($id);

        if (!$product) {
            echo "<script>alert('Product not found!'); window.history.back();</script>";
            return;
        }

        require __DIR__ . '/../views/users/showProduct.php';
    }
    public function search()
    {
        $query = $_GET['query'] ?? '';
        $results = $this->userModel->search($query);
        echo json_encode($results);
    }
    public function logout()
    {

        header("Location: index.php?controller=User&action=showActiveProducts");
        exit;
    }

}
