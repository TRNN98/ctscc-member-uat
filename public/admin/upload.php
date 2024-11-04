<?php

    require __DIR__.'./../../vendor/autoload.php';
    $app = require_once __DIR__.'/../../bootstrap/app.php';

    $kernel = $app->make('Illuminate\Contracts\Http\Kernel');

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );

    $id = $app['encrypter']->decrypt($_COOKIE[$app['config']['session.cookie']]);
    $app['session']->driver()->setId($id);
    $app['session']->driver()->start();


use Illuminate\Support\Facades\Auth;
//
session_start();

if($_SESSION['checkUpload'] == "A" || $_SESSION['checkUpload'] == "S" || Auth::guard('admin')->check()){


    // Allowed origins to upload images
    $accepted_origins = array(
        "http://localhost:8000",
        "https://localhost:8000",
        "http://healthcoop.test",
        "https://healthcoop.test",
        "http://test.healthcoop.or.th",
        "https://test.healthcoop.or.th",
        "http://healthcoop.or.th",
        "https://healthcoop.or.th",
    );


    // Images upload path
    // $imageFolder = "../mediafiles/picture/";
    $imageFolder = "../mediafiles/images/";

    reset($_FILES);
    $temp = current($_FILES);
    if(is_uploaded_file($temp['tmp_name'])){
        if(isset($_SERVER['HTTP_ORIGIN'])){
            // Same-origin requests won't set an origin. If the origin is set, it must be valid.
            if(in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)){
                header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
            }else{
                header("HTTP/1.1 403 Origin Denied");
                return;
            }
        }

        // Sanitize input
        if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])){
            $ext = pathinfo($temp['name'], PATHINFO_EXTENSION);
            $rand = rand();
            $temp['name'] = $rand.'.'.$ext;
            // dd($temp['name']);
            // header("HTTP/1.1 400 Invalid file name.");
            // return;
        }

        // Verify extension
        if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))){
            header("HTTP/1.1 400 Invalid extension.");
            return;
        }

        // Accept upload if there was no origin, or if it is an accepted origin

        $ext = pathinfo($temp['name'], PATHINFO_EXTENSION);
        $rand = rand();
        $temp['name'] = $rand.'.'.$ext;

        $filetowrite = $imageFolder . $temp['name'];
        move_uploaded_file($temp['tmp_name'], $filetowrite);

        // Respond to the successful upload with JSON.
        echo json_encode(array('location' => $filetowrite));

    } else {
        // Notify editor that the upload failed
        header("HTTP/1.1 500 Server Error");
    }
}
