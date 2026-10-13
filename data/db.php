<?php
function getConnection(): mysqli {
    $host = getenv("DB_HOST") ?: "localhost";
    $user = getenv("DB_USER") ?: "root";
    $pass = getenv("DB_PASS") ?: "";
    $name = getenv("DB_NAME") ?: "csdistsys_db";
    return new mysqli($host, $user, $pass, $name);
}