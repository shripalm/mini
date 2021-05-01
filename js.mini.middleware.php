<?php
    function autoConfig($method){
        $acceptRequestStartsFrom = 'http://localhost/';
        $reffererPage = $_SERVER['HTTP_REFERER'];

        /*
            refuse from array, refugeGlobalCheck, Refuge any method for global thing
            accept file name extension array, like accept only .php or .html from HTTP_REFERRER
            new => manually addable for particular directory, like every directory can have own globalCkeck 
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