<?php

require __DIR__ . '/../vendor/autoload.php';

use Exception\HttpException;
use Http\Request;
use Http\Response;

// Config
$debug = true;

// Persistence
$dsn = "mysql:host=localhost;dbname=uframework";
$connection = new \Model\Database\Connection($dsn, "uframework", "passw0rd");
$statusFinder = new \Model\Database\StatusFinder($connection);
$statusMapper = new \Model\Database\StatusMapper($connection);
$userMapper = new \Model\Database\UserMapper($connection);
$userFinder = new \Model\Database\UserFinder($connection);


// Template engine
$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates'
), $debug);


// Home
$app->get('/', function () use ($app) {
    $app->redirect('/statuses');
});


// Posts
$app->get('/statuses', function (Request $request) use ($app, $statusFinder){
    $format = $request->guessBestFormat();
    $response = null;
    $parameters = $request->getParameters();
    $statuses = $statusFinder->findAll($parameters);
    if ('json' === $format) {
        $response = new Response(json_encode($statuses,JSON_FORCE_OBJECT), 200, array('Content-Type' => 'application/json'));
        $response->send();
        return;
    }

    return $app->render('statusesList.php', array('array' => $statuses));
});

$app->get('/statusNotFound', function (Request $request) use ($app){
    return $app->render('statusNotFound.php',[], 404);
});

$app->get('/statuses/(\d+)', function (Request $request, $id) use ($app, $statusFinder){
    $status = $statusFinder->findOneById($id);
    if (!$status instanceof \Model\Status) {
        $app->redirect("/statusNotFound",404);
    }
    $format = $request->guessBestFormat();
    if ('json' === $format) {
        $response = new Response(json_encode($status), 200, array('Content-Type' => 'application/json'));
        $response->send();
        return;
    }
    return  $app->render('status.php', array('status' => $status));
});

$app->delete('/statuses/(\d+)', function (Request $request, $id) use ($app,$statusMapper){
    $statusMapper->remove($id);
    $app->redirect('/statuses');
});

$app->post('/statuses', function (Request $request) use ($app,$statusMapper){
    $format = $request->guessBestFormat();
    if ("html" === $format || "json" === $format) {
        if (isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated']) {
            $user = $_SESSION['user'];
        } else {
            $user = new \Model\User(null,"Anonymous", null);
        }
        $status = new \Model\Status(null, new \DateTime(), $user, $request->getParameter('message'));
        $statusMapper->persist($status);
    }
    $app->redirect('/statuses');
});


// Session
$app->get('/login', function () use ($app) {
    return $app->render('login.php');
});

$app->post('/login', function (Request $request) use ($app, $userFinder) {
    $name = $request->getParameter('user');
    $password = $request->getParameter('password');

    $user = $userFinder->findOneByName($name);

    if (null === $user) {
        return $app->redirect('/login');
    }

    if (password_verify($password, $user->getPassword())) {
        session_start();
        $_SESSION['is_authenticated'] = true;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user'] = $user;
        return $app->redirect('/');
    }

    return $app->render('/login');
});

$app->get('/logout', function (Request $request) use ($app) {
    session_destroy();

    return $app->redirect('/');
});


//Register
$app->get('/register', function () use ($app) {
    return $app->render('register.php');
});

$app->post('/register', function (Request $request) use ($app, $userMapper) {
    $name = $request->getParameter('user');
    $password = $request->getParameter('password');
    $user = new \Model\User(null, $name, password_hash($password,PASSWORD_DEFAULT));
    $userMapper->persist($user);
    return $app->redirect('/login');
});

// Firewall
$app->addListener('process.before', function(Request $req) use ($app) {
    session_start();

    $allowed = [
        '/login' => [ Request::GET, Request::POST ],
        '/statuses/(\d+)' => [ Request::GET ],
        '/statuses' => [ Request::GET, Request::POST ],
        '/register' => [ Request::GET, Request::POST ],
        '/statusNotFound' => [ Request::GET ],
        '/' => [ Request::GET ],
    ];

    if (isset($_SESSION['is_authenticated'])
        && true === $_SESSION['is_authenticated']) {
        return;
    }

    foreach ($allowed as $pattern => $methods) {
        if (preg_match(sprintf('#^%s$#', $pattern), $req->getUri())
            && in_array($req->getMethod(), $methods)) {
            return;
        }
    }

    switch ($req->guessBestFormat()) {
        case 'json':
            throw new HttpException(401);
    }

    return $app->redirect('/login');
});

return $app;


