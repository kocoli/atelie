<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
// timezone para São Paulo América
date_default_timezone_set('America/Sao_Paulo');

ob_start();

require  __DIR__ . "/vendor/autoload.php";

// os headers abaixo são necessários para permitir o acesso à API por clientes externos ao domínio
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header('Access-Control-Allow-Credentials: true'); // Permitir credenciais

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

use CoffeeCode\Router\Router;

$route = new Router(url("api"),":");

$route->namespace("source\Controller");

/* rotas de User */

$route->group("/users");
$route->get("/", "Users:listUsers"); //listar usuários
$route->post("/register","Users:register"); // Registrar usuário comum
$route->post("/login","Users:auth"); // login de usuário comum
$route->put("/update","Users:update"); // update de usuário comum
$route->delete("/inactive", "Users:inactive"); //active = 0
$route->delete("/delete", "Users:deleteRegister"); //Exclui de vez

$route->post("/register-admin","Users:registerAdmin"); // Registrar usuário admin NÃO IMPLEMENTADO
$route->post("/login-admin","Users:authAdmin"); // login de usuário admin
$route->put("/update-admin","Users:updateAdmin"); // update de usuário admin
$route->group(null);

/* Fim das rotas de User */

/* rotas de Type (no caso type_users) */

$route->group("/users/types");
$route->get("/", "UsersTypes:listAll");
$route->get("/{typeId}", "UsersTypes:userTypeById");
$route->post("/", "UsersTypes:createTypeUser");
$route->put("/{typeId}", "UsersTypes:update");
$route->delete("/inactive/{typeId}", "UsersTypes:inactive");
$route->delete("/{typeId}", "UsersTypes:delete");
$route->group(null);
/* fim das rotas type_users */

/* rotas de product */

$route->group("/products");
$route->get("/", "Products:selectAll");
$route->get("/{product_id}", "Products:selectById");
$route->post("/", "Products:create");
$route->put("/{product_id}", "Products:update");
$route->delete("/inactive/{product_id}", "Products:inactive");
$route->delete("/{product_id}", "Products:delete");
$route->group(null);

/* fim das rotas de product */

/* rotas de Categoria de produto */

$route->group("/categories");
$route->get("/", "Categories:selectAll");
$route->get("/{category_id}", "Categories:selectById");
$route->post("/", "Categories:create");
$route->put("/{category_id}", "Categories:update");
$route->delete("/inactive/{category_id}", "Categories:inactive");
$route->delete("/{category_id}", "Categories:delete");
$route->group(null);

/* fim das rotas category */

/* rotas de Status de encomendas */

$route->group("/order/status");
$route->get("/", "StatusController:selectAll");
$route->get("/{status_id}", "StatusController:selectById");
$route->post("/", "StatusController:create");
$route->put("/{status_id}", "StatusController:update");
$route->delete("/inactive/{status_id}", "StatusController:inactive");
$route->delete("/{status_id}", "StatusController:delete");
$route->group(null);

/* fim das rotas status */

/* rotas de customers */

$route->group("/customers");
$route->get("/", "Customers:selectAll");
$route->get("/{customer_id}", "Customers:selectById");
$route->post("/", "Customers:create");
$route->put("/{customer_id}", "Customers:update");
$route->delete("/inactive/{customer_id}", "Customers:inactive");
$route->delete("/{customer_id}", "Customers:delete");
$route->group(null);

/* fim das rotas customers */

/* rotas de Orders */

$route->group("/orders");
$route->get("/", "Orders:selectAll");
$route->get("/{order_id}", "Orders:selectById");
$route->post("/", "Orders:create");
$route->put("/{order_id}", "Orders:update");
$route->delete("/inactive/{order_id}", "Orders:inactive");
$route->delete("/{order_id}", "Orders:delete");
$route->group(null);

/* fim das rotas Orders */

/* rotas de Orders Items */

$route->group("/orders/item");
$route->get("/", "OrderItems:selectAll");
$route->get("/{orderItem_id}", "OrderItems:selectById");
$route->post("/", "OrderItems:create");
$route->put("/{orderItem_id}", "OrderItems:update");
$route->delete("/inactive/{orderItem_id}", "OrderItems:inactive");
$route->delete("/{orderItem_id}", "OrderItems:delete");
$route->group(null);

/* fim das rotas Orders */

/* rotas das categorias (FAQ) */

$route->group("/faqs/types");
$route->get("/", "FaqTypes:selectAll");
$route->get("/{type_id}", "FaqTypes:selectById");
$route->post("/", "FaqTypes:create");
$route->put("/{type_id}", "FaqTypes:update");
$route->delete("/inactive/{type_id}", "FaqTypes:inactive");
$route->delete("/{type_id}", "FaqTypes:delete");
$route->group(null);

/* fim das rotas categoria (FAQ) */

/* rotas das question (FAQ) */

$route->group("/faqs");
$route->get("/", "FaqQuestions:selectAll");
$route->get("/{question_id}", "FaqQuestions:selectById");
$route->post("/", "FaqQuestions:create");
$route->put("/{question_id}", "FaqQuestions:update");
$route->delete("/inactive/{question_id}", "FaqQuestions:inactive");
$route->delete("/{question_id}", "FaqQuestions:delete");
$route->group(null);

/* fim das rotas question (FAQ) */

$route->dispatch();

/** ERROR REDIRECT */
if ($route->error()) {
    header('Content-Type: application/json; charset=UTF-8');
    http_response_code(404);

    echo json_encode([
        "code" => 404,
        "type" => "error",
        "status" => "not_found",
        "message" => "O recurso solicitado não existe."
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

ob_end_flush();