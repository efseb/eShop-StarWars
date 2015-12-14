<?php

require_once __DIR__ .'/vendor/autoload.php';

define('SALT', '1fJxj0yZigmMNCAq');
define('DEBUG', false);
define('URL_SITE', 'http://localhost:8000/');
//define('URL_SITE', 'http://localhost/PHP/base/AppStarWars/public/index.php/');
/* --------------------------------------------------- *\
            Helpers
\* --------------------------------------------------- */

function view($path, array $data, $status = '200 Ok')
{
    $fileName = __DIR__ . '/resources/views/' . str_replace(".", '/', $path) . '.php';

    if (!file_exists($fileName)) die(sprintf('Le fichier %s n\'existe pas', $fileName));
    if (!empty($data)) extract($data);

    header('HTTP/1.1 ' . $status);
    header('Content-type: text/html; charset=UTF-8');

    include $fileName;
}

function url($path='', $params='')
{
    if(!empty($params)) $params = "/$params";

    return URL_SITE.$path.$params;
}

function token()
{
    $token = md5(date('Y-m-d h:i:00') . SALT);
    return '<input type="hidden" name="_token" value="' . $token . '">';
}
function checked_token($token)
{
    if (!empty($token)) {
        foreach (range(0, VALID_TIME_TOKEN) as $v) {
            if (($token == md5(date('Y-m-d h:i:00', time() - $v * 60) . SALT))) {
                return true;
            }
        }
        return false;
    }
    throw new RuntimeException('no _token checked');
}


/* --------------------------------------------------- *\
            REQUEST
\* --------------------------------------------------- */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = strtolower($_SERVER["REQUEST_METHOD"]);

//var_dump($uri);
//var_dump($method);

/* --------------------------------------------------- *\
            Controllers
\* --------------------------------------------------- */

use Controllers\FrontController;

/* --------------------------------------------------- *\
            Connect Database
\* --------------------------------------------------- */

\Connect::set(['dsn' => 'mysql:host=localhost;dbname=db_starwars', 'username' => 'root', 'password' => '']);

//var_dump(\Connect::$pdo);

/* --------------------------------------------------- *\
            Router
\* --------------------------------------------------- */

if ($method == 'get')
{
    switch ($uri)
    {
        case "/":
            $frontController = new FrontController;
            $frontController->index();
            break;

        case preg_match('/\/product\/([1-9][0-9]*)/', $uri, $m) == 1:
            $front = new Controllers\FrontController;
            $front->show($m[1]);
            break;

        case "/cart":
            $front = new Controllers\FrontController;
            $front->showCart();
            break;

        case "/store":
            $front = new Controllers\FrontController;
            $front->store();
            break;

        default:
            $message = 'Page Not Found';
            view('404', compact('message'));
    }
}
if($method =='post')
{
    switch($uri)
    {
        case'/command':

            $front = new Controllers\FrontController;
            $front->command();
            break;
    }
}
