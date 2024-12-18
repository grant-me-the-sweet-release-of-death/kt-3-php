CREATE TABLE `products` (
    `id` INT AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL DEFAULT '',
    `description` TEXT,
    `price` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

-- добавить новый продукт
CREATE PROCEDURE spCreateProduct(IN name VARCHAR(255), IN description TEXT, IN price DECIMAL(10, 2))
BEGIN
    INSERT INTO `products`(`name`, `description`, `price`) VALUES(name, description, price);
END;

-- читает все продукты
CREATE PROCEDURE spReadProducts()
BEGIN
    SELECT `id`, `name`, `description`, `price`, UNIX_TIMESTAMP(`created`) as `created` FROM `products`;
END;

-- читает по айди
CREATE PROCEDURE spReadProductById(IN idx INT)
BEGIN
    SELECT `id`, `name`, `description`, `price` FROM `products` WHERE `id` = idx;
END;

-- обновить продукт
CREATE PROCEDURE spUpdateProduct(IN idx INT, IN name VARCHAR(255), IN description TEXT, IN price DECIMAL(10, 2))
BEGIN
    UPDATE `products` SET
        `name` = name,
        `description` = description,
        `price` = price
    WHERE `id` = idx;
END;
