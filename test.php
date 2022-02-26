<?php

if (date_default_timezone_get() != 'Asia/Seoul'){
	date_default_timezone_set('Asia/Seoul');
}

include './vendor/autoload.php';
include './HttpServerManager.php';
include './utils/DataManager.php';
include './utils/MainLogger.php';

use React\Http\HttpServer;
use React\Http\Message\Response;
use React\Socket\SocketServer;

use Psr\Http\Message\ServerRequestInterface;

$logger = new utils\MainLogger(__DIR__);

# https -----------------------------------------------------------------------------------------------------

$https = new HttpServer(
	function(ServerRequestInterface $request): Response{
		$manager = new HttpServerManager($request);
		return $manager->onRequest();
	}
);

$uri = 'tls://0.0.0.0:443';
$fullchain = '/etc/letsencrypt/live/withq.kr/fullchain.pem';
$privkey = '/etc/letsencrypt/live/withq.kr/privkey.pem';

$httpsSocket = new SocketServer(
	$uri, [
		'tls' => [
			'local_cert' => $fullchain,
			'local_pk' => $privkey,
			'verify_peer' => FALSE
		]
	]
);

$https->listen($httpsSocket);

$httpsSocket->on('error', function(Exception $e){
	$logger::text($logger::COLOR_RED . 'HTTPS SERVER FAIL, ' . $e->getMessage() . $logger::FORMAT_RESET);
});

$logger::text($logger::COLOR_GREEN . 'HTTPS SERVER SUCCESS' . $logger::FORMAT_RESET);

# http -----------------------------------------------------------------------------------------------------

$http = new HttpServer(
	function(ServerRequestInterface $request): Response{
		return Response::html(file_get_contents('html/redirect/redirect.html'));
	}
);

$httpSocket = new SocketServer('0.0.0.0:80');

$http->listen($httpSocket);

$httpSocket->on('error', function(Exception $e){
	$logger::text($logger::COLOR_RED . 'HTTP SERVER FAIL, ' . $e->getMessage() . $logger::FORMAT_RESET);
});

$logger::text($logger::COLOR_GREEN . 'HTTP SERVER SUCCESS' . $logger::FORMAT_RESET);

?>
