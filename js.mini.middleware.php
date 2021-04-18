<?php
    function autoConfig($method){
        $acceptRequestStartsFrom = 'http://localhost/';
        $reffererPage = $_SERVER['HTTP_REFERER'];

        /*
            refuse from array,
            accept file name extension array,
            new => manually addable for particular directory 
        */

        if(! str_starts_with($reffererPage, $acceptRequestStartsFrom)){
            echo "Server Refused Connection..!";
            exit;
        }

        $suffix = '.'.end(explode('.',basename($reffererPage)));
        $fromPage = basename($reffererPage, $suffix);

        $globalCheck = [
            'getSValue',
            'getMValue',
            'insert',
            'insertForm',
            'update',
            'delete',
            'query',
            'describe',
        ];

        if(! in_array($method, $globalCheck)){
            echo "You cannot access $method from here..!";
            exit;
        }

        $index = [
            'insertForm'
        ];

        if(! in_array($method, $$fromPage ?? $globalCheck)){
            echo "You cannot access $method from $fromPage page..!";
            exit;
        }
    }
?>