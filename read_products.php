<?php
require_once 'config.php';
require_once 'core/lib.php';

// подключение к бд
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CALL spReadProducts()";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul class='product-list'>";
    while ($row = $result->fetch_assoc()) {
        echo "<li class='product'>";
        echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        echo "<p>Цена: " . number_format($row['price'], 2) . " руб.</p>";
        echo "<a href='?edit=" . $row['id'] . "'>Редактировать</a>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Товары отсутствуют.</p>";
}

$conn->close();
