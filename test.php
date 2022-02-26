<?php

if (date_default_timezone_get() != 'Asia/Seoul'){
	date_default_timezone_set('Asia/Seoul');
}

include './vendor/autoload.php';
include './HttpServerManager.php';
include './MainLogger.php';
include './utils/DataManager.php';

use React\Http\HttpServer;
use React\Http\Message\Response;
use React\Socket\SocketServer;

use Psr\Http\Message\ServerRequestInterface;


$logger = new MainLogger();

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

$httpsSocket->on('error', function(Exception $e){
	$logger::text('HTTPS SERVER FAIL, ' . $e->getMessage());
});

$logger::text($logger::COLOR_GREEN . 'HTTPS SERVER SUCCESS' . $logger::FORMAT_RESET);


$http = new HttpServer(
	function(ServerRequestInterface $request): Response{
		return Response::html(file_get_contents('html/redirect/redirect.html'));
	}
);

$httpSocket = new SocketServer('0.0.0.0:80');
$http->listen($httpSocket);

$httpSocket->on('error', function(Exception $e){
	$logger::text('HTTP SERVER FAIL, ' . $e->getMessage());
});

$logger::text($logger::COLOR_GREEN . 'HTTP SERVER SUCCESS' . $logger::FORMAT_RESET);

?>
