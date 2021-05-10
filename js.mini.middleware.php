<?php
    function autoConfig($method){
        $acceptRequestStartsFrom = 'http://localhost/';
        $reffererPage = $_SERVER['HTTP_REFERER'];
        
        if(! str_starts_with($reffererPage, $acceptRequestStartsFrom)){
            returnResponseMiddleware("Server Refused Connection..!");
        }

        $suffix = '.'.end(explode('.',basename($reffererPage)));
        $fromPage = basename($reffererPage, $suffix);

        $globalExt = [
            '.php',
            '.html'
        ];

        if(! in_array($suffix, $globalExt)){
            returnResponseMiddleware("Server Refused Connection..! You must add your current file extension in globalExt..!");
        }

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
            returnResponseMiddleware ("You cannot access $method from here..!");
        }

        $index = [
            'insertForm',
            'getSValue',
            'describe'
        ];

        if(! in_array($method, $$fromPage ?? $globalCheck)){
            returnResponseMiddleware ("You cannot access $method from $fromPage page..!");
        }

        $individualFileCheck = [
            "http://localhost/mini/index.html" => [
                "describe",
                "insertForm"
            ],
        ];

        if(isset($individualFileCheck[$reffererPage])){
            if(! in_array($method, $individualFileCheck[$reffererPage])){
                returnResponseMiddleware ("You cannot access $method from $reffererPage page..!");
            }
        }

    }
    function configResponse($response){
        $restrictedFields = [
            'Key',
            'Field'
        ];
        if(is_array($response)){
            foreach ($response as $key => $value) {
                if(is_array($value)){
                    $response[$key] = configResponse($value);
                }
                else{
                    if(in_array($key, $restrictedFields)){
                        unset($response[$key]);
                    }
                }
            }
        }
        return $response;
    }
?>