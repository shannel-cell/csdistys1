<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
ini_set("display_errors", 0);

header("Content-Type: application/json");
require_once __DIR__ . "/../data/UserRepository.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method not allowed"]);
    exit;
}

$name     = trim($_POST["full_name"] ?? "");
$email    = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

if ($name === "" || $email === "" || $password === "") {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email address"]);
    exit;
}
if (strlen($password) < 8) {
    echo json_encode(["success" => false, "message" => "Password must be at least 8 characters"]);
    exit;
}

try {
    $repo = new UserRepository();

    if ($repo->emailExists($email)) {
        echo json_encode(["success" => false, "message" => "Email already registered"]);
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    if ($repo->create($name, $email, $hash)) {
        echo json_encode(["success" => true, "message" => "Registration successful!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Could not save user"]);
    }
} catch (Throwable $e) {
    http_response_code(500);
    // Shows the real cause while you are testing; remove the detail later
      echo json_encode(["success" => false, "message" => "Server error"]);
}