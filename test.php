<?php

date_default_timezone_set('Asia/Seoul');

include './vendor/autoload.php';
include './HttpServerManager.php';
include './utils/DataManager.php';

use React\Http\HttpServer;
use React\Http\Message\Response;
use React\Socket\SocketServer;

use Psr\Http\Message\ServerRequestInterface;

function getTime(): string{
	return '[' . date("H-i-s") . '] ';
}

# ---------------------------------------------------------------------------------------------------
# ---------------------------------------------------------------------------------------------------
# ---------------------------------------------------------------------------------------------------

$https = new HttpServer(
	function(ServerRequestInterface $request): Response{
		$manager = new HttpServerManager($request);
		return $manager->onRequest();
	}
);
$uri = 'tls://0.0.0.0:443';
$httpsSocket = new SocketServer(
	$uri, [
		'tls' => [
			'local_cert' => '/etc/letsencrypt/live/withq.kr/fullchain.pem',
			'local_pk' => '/etc/letsencrypt/live/withq.kr/privkey.pem',
			'verify_peer' => FALSE
		]
	]
);
$https->listen($httpsSocket);

echo getTime() . 'HTTPS 정상 작동' . "\n";

/*$https_socket->on('error', function (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
});*/

# ---------------------------------------------------------------------------------------------------
# ---------------------------------------------------------------------------------------------------
# ---------------------------------------------------------------------------------------------------

$http = new HttpServer(
	function(ServerRequestInterface $request): Response{
		$path = $request->getUri()->getPath();
		$clear_path = '/' . implode('/', array_filter(explode('/', $path)));
		$ip = $request->getServerParams()['REMOTE_ADDR'];
		
		echo getTime() . $ip . ', status: redirect, url: ' . $clear_path . "\n";
		
		return Response::html(file_get_contents('html/redirect/redirect.html'));
	}
);

$httpSocket = new SocketServer('0.0.0.0:80');
$http->listen($httpSocket);

echo getTime() . 'HTTP 정상 작동' . "\n";

?>
