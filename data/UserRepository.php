<?php
require_once __DIR__ . "/db.php";

class UserRepository {
    public function emailExists(string $email): bool {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        $conn->close();
        return $exists;
    }

    public function create(string $name, string $email, string $hash): bool {
        $conn = getConnection();
        $stmt = $conn->prepare(
            "INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $name, $email, $hash);
        $ok = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $ok;
    }
        public function getAll(): array {
        $conn = getConnection();
        $result = $conn->query("SELECT id, full_name, email, created_at FROM users ORDER BY id DESC");
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $conn->close();
        return $rows;
    }
}