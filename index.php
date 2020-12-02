<?php
// ruta
// http://localhost/SegundoParcial/


//Slim
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteCollectorProxy;
use Slim\Middleware\ErrorMiddleware;
//JWT
use \Firebase\JWT\JWT;
//Propias
use Clases\Usuario;
//Middleware
use App\Middlewares\JsonMiddleware;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\UserMiddleware;
use App\Middlewares\ProfesorMiddleware;
//Controller
use App\Controllers\UserController;
use App\Controllers\LoginController;
use App\Controllers\MateriaController;
use App\Controllers\InscripcioneController;
use App\Controllers\NotaController;
use App\Controllers\MascotaController;
use App\Controllers\TurnoController;
use Config\Database;

require __DIR__ . '/vendor/autoload.php'; // siempre que utilicemos composer hay que poner esto

$app = AppFactory::create();
$app->setBasePath('/SegundoParcial');
new Database;

$app->group('/users', function (RouteCollectorProxy $group) {
    
    $group->get('/{id}', UserController::class . ":getOne")->add(new UserMiddleware);  // obtener uno solo

    $group->get('[/]', UserController::class . ":getAll")->add(new UserMiddleware);  // Para obtener todos los registros

    $group->post('[/]', UserController::class . ":add");
    
    $group->put('[/]', UserController::class . ":update");
    //$group->put('/[id}', UserController::class . ":update");  //original

    $group->delete('/{id}', UserController::class . ":delete");
})->add(new AuthMiddleware); //Aca valida al grupo el Token


$app->group('/login', function (RouteCollectorProxy $group) {
    
    $group->post('[/]', LoginController::class . ":add");
    
});

$app->group('/mascota', function (RouteCollectorProxy $group) {
    
    $group->post('[/]', MascotaController::class . ":add")->add(new UserMiddleware);
});

$app->group('/turno', function (RouteCollectorProxy $group) {
    
    $group->post('[/]', TurnoController::class . ":add")->add(new UserMiddleware);
    $group->put('/{id}', TurnoController::class . ":update")->add(new UserMiddleware);
});

$app->add(new JsonMiddleware); //Aca agrego mi Middleware - istancio mi clase

$app->addErrorMiddleware(true, true, true);

$app->run();