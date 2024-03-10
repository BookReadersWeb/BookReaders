<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/BookReaders/' :
        // Esta sera la landing page
        require '../app/views/login.php';
        break;
    default:    
        $request = str_replace('/BookReaders/', '', $request);
        $filename = '../app/views/' . $request . '.php';

        if (file_exists($filename)) {
            require_once $filename;
            break;
        } 

        http_response_code(404);
        require '../app/views/404.php';        
        break;
}