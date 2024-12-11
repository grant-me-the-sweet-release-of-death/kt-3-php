<?php
require_once 'config.php';
require_once 'core/lib.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;

    $name = htmlspecialchars($name);
    $description = htmlspecialchars($description);
    $price = floatval($price);

    if ($id) {
        $stmt = $conn->prepare("CALL spUpdateProduct(?, ?, ?, ?)");
        $stmt->bind_param("issd", $id, $name, $description, $price);
    } else {
        $stmt = $conn->prepare("CALL spCreateProduct(?, ?, ?)");
        $stmt->bind_param("ssd", $name, $description, $price);
    }

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<p>Товар успешно сохранён!</p>";
    } else {
        echo "<p>Ошибка при сохранении товара.</p>";
    }
    $stmt->close();
}

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = $conn->query("CALL spReadProductById($id)");
    $product = $result->fetch_assoc();
    $name = htmlspecialchars($product['name']);
    $description = htmlspecialchars($product['description']);
    $price = floatval($product['price']);
} else {
    $id = $name = $description = $price = null;
}

$conn->close();
?>

<form method="POST">
    <input type="hidden" name="id" value="<?= $id ?>">

    <label for="name">Название товара:</label>
    <input type="text" id="name" name="name" value="<?= $name ?>" required>

    <label for="description">Описание товара:</label>
    <textarea id="description" name="description" required><?= $description ?></textarea>

    <label for="price">Цена товара:</label>
    <input type="number" id="price" name="price" step="0.01" value="<?= $price ?>" required>

    <button type="submit">Сохранить товар</button>
</form>

<?php
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<p>Товар успешно удалён!</p>";
    } else {
        echo "<p>Ошибка при удалении товара.</p>";
    }
    $stmt->close();
}
?>
