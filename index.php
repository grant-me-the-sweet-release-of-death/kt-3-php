<?php
  $id = '';
  require_once 'core/lib.php';
  require_once 'config.php';

  // Routing for products
  if(isset($_GET['create'])) require_once 'core/create_product.php';
  if(isset($_GET['edit']) or isset($_GET['update'])) require_once 'core/update_product.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Магазин</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <main>
    <header>
      <h1>Мой Магазин</h1>
      <p>Лучшие товары для вас</p>
    </header>
    <nav>
      <a href='?admin' id='login'>Добавить товар</a>
    </nav>
    <?php
      // Render admin page or product list
      if(isset($_GET['admin']) or $id) require_once 'core/admin_products.php';
      else require_once 'core/read_products.php';
    ?>
    <!-- Список товаров -->
    <footer>
      <h3>Все права защищены &copy; Я 2015-<?= date('Y')?> </h3>
      <p>Всё работает на PHP-<?=PHP_VERSION?></p>
    </footer>
  </main>
</body>
</html>
