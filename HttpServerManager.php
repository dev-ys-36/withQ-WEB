<?php

use React\Http\Message\Response;
use Psr\Http\Message\ServerRequestInterface;

class HttpServerManager{

    protected ServerRequestInterface $request;

    protected string $path;
    protected string $clearPath;

    protected $serverParams;

    public function __construct(ServerRequestInterface $request){

        $this->request = $request;

        $this->path = $request->getUri()->getPath();
	    $this->clearPath = '/' . implode('/', array_filter(explode('/', $this->path)));

        $this->serverParams = $request->getServerParams();

    }

    public function getTime(): string{

        return '[' . date("H-i-s") . '] ';

    }

    /*public function onRequest(): Response{
        
        //$ip = $this->serverParams['REMOTE_ADDR'];

        //echo $this->getTime() . $ip . ', status: join, url: ' . $this->clearPath . "\n";

        if ($this->clearPath === '/'){

            return Response::plaintext("Hello World");

            //return Response::html(file_get_contents('html/warning/system_url.html'));

        }

    }*/

    public function onRequest(): Response{

        $ip = $this->serverParams['REMOTE_ADDR'];
    
        $login = new utils\DataManager('/root/web/datas/login.json', utils\DataManager::JSON);
        $db['login'] = $login->getAll();
    
        //$data = new utils\DataManager('/root/main/plugin_data/Email_Authentication/data.json', utils\DataManager::JSON);
        //$db['data'] = $data->getAll();
        $db['data'] = [];
    
        //echo $this->getTime() . $ip . ', status: join, url: ' . $this->clearPath . "\n";
    
        if ($this->clearPath === '/'){
    
            if (isset($db['login'][$ip])){
    
                $a = [];
                exec("php /root/web/html/main/index.php " . $db['login'][$ip]['username'] . " " . $db['login'][$ip]['e-mail'], $a);

                return Response::html(implode("\n", $a));
    
                /*return new React\Http\Message\Response(
                    200,
                    array('Content-Type' => 'text/html'),
                    implode("\n", $a)
                );*/
    
            }
    
            $a = [];
            exec("php /root/web/html/main/index.php", $a);

            return Response::html(implode("\n", $a));
    
            /*return new React\Http\Message\Response(
                200,
                array('Content-Type' => 'text/html'),
                implode("\n", $a)
            );*/
    
        }else if ($this->clearPath === '/login'){
    
            if (isset($db['login'][$ip])){

                return Response::html(file_get_contents('html/login/login_success.html'));
    
                /*return new React\Http\Message\Response(
                    200,
                    array('Content-Type' => 'text/html'),
                    file_get_contents('html/login/login_success.html')
                );*/
    
            }

            return Response::html(file_get_contents('html/login/login.html'));
    
            /*return new React\Http\Message\Response(
                200,
                array('Content-Type' => 'text/html'),
                file_get_contents('html/login/login.html')
            );*/
    
        }else if ($this->clearPath === '/logout'){
    
            if (isset($db['login'][$ip])){
    
                unset($db['login'][$ip]);
    
                $login->setAll($db['login']);
                $login->save();

                return Response::html(file_get_contents('html/login/logout_success.html'));
    
                /*return new React\Http\Message\Response(
                    200,
                    array('Content-Type' => 'text/html'),
                    file_get_contents('html/login/logout_success.html')
                );*/
    
            }

            return Response::html(file_get_contents('html/login/logout_fail.html'));
    
            /*return new React\Http\Message\Response(
                200,
                array('Content-Type' => 'text/html'),
                file_get_contents('html/login/logout_fail.html')
            );*/
    
        }else if ($this->clearPath === '/login_check' and $this->request->getMethod() == "POST"){
    
            $email = $this->request->getParsedBody()['email'];
            $username = strtolower($this->request->getParsedBody()['username']);
    
            if (isset($db['data'][$username]) and isset($db['data'][$username]['e-mail'])){
    
                if ($db['data'][$username]['e-mail'] == $email){
    
                    $db['login'][$ip] = [];
                    $db['login'][$ip]['username'] = $username;
                    $db['login'][$ip]['e-mail'] = $email;
    
                    $login->setAll($db['login']);
                    $login->save();

                    return Response::html(file_get_contents('html/login/login_success.html'));
    
                    /*return new React\Http\Message\Response(
                        200,
                        array('Content-Type' => 'text/html'),
                        file_get_contents('html/login/login_success.html')
                    );*/
    
                }

                return Response::html(file_get_contents('html/login/login_fail.html'));
    
                /*return new React\Http\Message\Response(
                    200,
                    array('Content-Type' => 'text/html'),
                    file_get_contents('html/login/login_fail.html')
                );*/
    
            }

            return Response::html(file_get_contents('html/login/login_fail.html'));
    
            /*return new React\Http\Message\Response(
                200,
                array('Content-Type' => 'text/html'),
                file_get_contents('html/login/login_fail.html')
            );*/
        
        }else if ($this->clearPath === '/write_check' and $this->request->getMethod() == "POST"){
    
            if (isset($db['login'][$ip])){
    
                $title = $this->request->getParsedBody()['title'];
                $content = $this->request->getParsedBody()['content'];
    
                $board_data = new utils\DataManager('/root/web/datas/board_data.json', utils\DataManager::JSON);
                $db['board_data'] = $board_data->getAll();
    
                if (!isset($db['board_data']['num-count']) or !isset($db['board_data']['board-data'])){
    
                    $db['board_data']['num-count'] = 0;
                    $db['board_data']['board-data'] = [];
    
                }
    
                $write = [];
                $write['num'] = ++$db['board_data']['num-count'];
                $write['title'] = $title;
                $write['content'] = $content;
                $write['writer'] = $db['login'][$ip]['username'];
                $write['view'] = 0;
    
                $db['board_data']['board-data'][] = $write;
    
                $board_data->setAll($db['board_data']);
                $board_data->save();
    
                $a = [];
                exec("php /root/web/html/board/board_index.php", $a);

                return Response::html(implode("\n", $a));
    
                /*return new React\Http\Message\Response(
                    200,
                    array('Content-Type' => 'text/html'),
                    implode("\n", $a)
                );*/
    
            }

            return Response::html(file_get_contents('html/login/login_fail.html'));
    
            /*return new React\Http\Message\Response(
                200,
                array('Content-Type' => 'text/html'),
                file_get_contents('html/login/login_fail.html')
            );*/
    
        }else if ($this->clearPath === '/profile'){
    
            if (isset($db['login'][$ip])){
    
                $a = [];
                exec("php /root/web/html/main/profile.php " . $db['login'][$ip]['username'] . " " . $db['login'][$ip]['e-mail'], $a);

                return Response::html(implode("\n", $a));
    
                /*return new React\Http\Message\Response(
                    200,
                    array('Content-Type' => 'text/html'),
                    implode("\n", $a)
                );*/
        
            }

            return Response::html(file_get_contents('html/warning/unknown_error.html'));
        
            /*return new React\Http\Message\Response(
                200,
                array('Content-Type' => 'text/html'),
                file_get_contents('html/warning/unknown_error.html')
            );*/
    
        }else if (substr($this->clearPath, 0, 7) === '/board/'){
    
            $path_ = explode('/', $this->clearPath)[2];
    
            if ($path_ === 'write'){
    
                if (isset($db['login'][$ip])){
    
                    $a = [];
                    exec("php /root/web/html/board/board_write.php " . $db['login'][$ip]['username'] . " " . $db['login'][$ip]['e-mail'], $a);

                    return Response::html(implode("\n", $a));
                
                    /*return new React\Http\Message\Response(
                        200,
                        array('Content-Type' => 'text/html'),
                        implode("\n", $a)
                    );*/
                }

                return Response::html(file_get_contents('html/warning/unknown_error.html'));
    
                /*return new React\Http\Message\Response(
                    200,
                    array('Content-Type' => 'text/html'),
                    file_get_contents('html/warning/unknown_error.html')
                );*/
    
            }
    
            $board_data = new utils\DataManager('/root/web/datas/board_data.json', utils\DataManager::JSON);
            $db['board_data'] = $board_data->getAll();
    
            foreach($db['board_data']['board-data'] as $datas => $type){
    
                if ($db['board_data']['board-data'][$datas]['num'] == $path_){
    
                    $db['board_data']['board-data'][$datas]['view'] += 1;
    
                    $board_data->setAll($db['board_data']);
                    $board_data->save();
    
                    $a = [];
    
                    if (isset($db['login'][$ip])){
                        exec("php /root/web/html/board/board_read.php {$path_} " . $db['login'][$ip]['username'] . " " . $db['login'][$ip]['e-mail'] . "", $a);
                    }else{
                        exec("php /root/web/html/board/board_read.php {$path_}", $a);
                    }

                    return Response::html(implode("\n", $a));
    
                    /*return new React\Http\Message\Response(
                        200,
                        array('Content-Type' => 'text/html'),
                        implode("\n", $a)
                    );*/
            
                }
    
            }

            return Response::html(file_get_contents('html/warning/system_url.html'));
    
            /*return new React\Http\Message\Response(
                404,
                array('Content-Type' => 'text/html'),
                file_get_contents('html/warning/system_url.html')
            );*/
    
        }else if ($this->clearPath === '/board'){
    
            if (isset($db['login'][$ip])){
    
                $a = [];
                exec("php /root/web/html/board/board_index.php " . $db['login'][$ip]['username'] . " " . $db['login'][$ip]['e-mail'], $a);

                return Response::html(implode("\n", $a));
    
                /*return new React\Http\Message\Response(
                    200,
                    array('Content-Type' => 'text/html'),
                    implode("\n", $a)
                );*/
        
            }
    
            $a = [];
            exec("php /root/web/html/board/board_index.php", $a);

            return Response::html(implode("\n", $a));
    
            /*return new React\Http\Message\Response(
                200,
                array('Content-Type' => 'text/html'),
                implode("\n", $a)
            );*/
            
        }else{

            return Response::html(file_get_contents('html/warning/system_url.html'));
    
            /*return new React\Http\Message\Response(
                404,
                array('Content-Type' => 'text/html'),
                file_get_contents('html/warning/system_url.html')
            );*/
            
        }

    }

}

?>