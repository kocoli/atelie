DROP DATABASE IF EXISTS atelie;
CREATE DATABASE atelie;
USE atelie;

CREATE TABLE users_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    active TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    photo VARCHAR(255),
    active TINYINT(1) NOT NULL DEFAULT 1,

    CONSTRAINT fk_users_user_types
        FOREIGN KEY (type_id)
        REFERENCES users_types(id)
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    active TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    active TINYINT(1) NOT NULL DEFAULT 1,

    CONSTRAINT fk_products_categories
        FOREIGN KEY (category_id)
        REFERENCES categories(id)
);

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    phone VARCHAR(20),
    address VARCHAR(255),
    active TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE order_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status VARCHAR(50) NOT NULL,
    active TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    status_id INT NOT NULL,
    active TINYINT(1) NOT NULL DEFAULT 1,

    CONSTRAINT fk_orders_customers
        FOREIGN KEY (customer_id)
        REFERENCES customers(id),

    CONSTRAINT fk_orders_status
		FOREIGN KEY (status_id)
		REFERENCES order_status(id)
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    active TINYINT(1) NOT NULL DEFAULT 1,

    CONSTRAINT fk_order_items_orders
        FOREIGN KEY (order_id)
        REFERENCES orders(id),

    CONSTRAINT fk_order_items_products
        FOREIGN KEY (product_id)
        REFERENCES products(id)
);

CREATE TABLE faq_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(150) NOT NULL,
    active TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE faq_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    type_id INT NOT NULL,
    active TINYINT(1) NOT NULL DEFAULT 1,

    CONSTRAINT fk_faq_questions_types
        FOREIGN KEY (type_id)
        REFERENCES faq_types(id)
);

USE atelie;

-- ==========================
-- USERS TYPES
-- ==========================
INSERT INTO users_types (name) VALUES
('Administrador'),
('Artesão'),
('Funcionário');

-- ==========================
-- USERS
-- ==========================
INSERT INTO users (type_id, name, email, password, photo) VALUES
(1, 'Nicóli Pereira', 'nicoli@atelie.com', '123456', 'nicoli.jpg'),
(2, 'Maria Souza', 'maria@atelie.com', '123456', 'maria.jpg'),
(3, 'João Oliveira', 'joao@atelie.com', '123456', 'joao.jpg');

-- ==========================
-- CATEGORIES
-- ==========================
INSERT INTO categories (name) VALUES
('Crochê'),
('Cerâmica'),
('Pintura');

-- ==========================
-- PRODUCTS
-- ==========================
INSERT INTO products (category_id, name, price, stock) VALUES
(1, 'Amigurumi de Gato', 85.00, 12),
(2, 'Vaso Artesanal', 120.00, 8),
(3, 'Quadro Floral', 180.00, 5);

-- ==========================
-- CUSTOMERS
-- ==========================
INSERT INTO customers (name, phone, address) VALUES
('Ana Martins', '(51) 99999-1111', 'Rua das Flores, 120'),
('Carlos Henrique', '(51) 98888-2222', 'Av. Central, 350'),
('Fernanda Lima', '(51) 97777-3333', 'Rua do Artesão, 78');

-- ==========================
-- ORDER STATUS
-- ==========================
INSERT INTO order_status (status) VALUES
('Pendente'),
('Em Produção'),
('Entregue');

-- ==========================
-- ORDERS
-- ==========================
INSERT INTO orders (customer_id, status_id) VALUES
(1, 1),
(2, 2),
(3, 3);

-- ==========================
-- ORDER ITEMS
-- ==========================
INSERT INTO order_items (order_id, product_id, quantity) VALUES
(1, 1, 2),
(2, 2, 1),
(3, 3, 3);

-- ==========================
-- FAQ TYPES
-- ==========================
INSERT INTO faq_types (description) VALUES
('Pedidos'),
('Pagamentos'),
('Entrega');

-- ==========================
-- FAQ QUESTIONS
-- ==========================
INSERT INTO faq_questions (question, answer, type_id) VALUES
(
'Como faço um pedido personalizado?',
'Entre em contato pelo formulário ou WhatsApp informando as características desejadas.',
1
),
(
'Quais formas de pagamento são aceitas?',
'Aceitamos Pix, cartão de crédito e boleto bancário.',
2
),
(
'Qual é o prazo de entrega?',
'O prazo varia entre 5 e 15 dias úteis, dependendo do produto e da região.',
3
);