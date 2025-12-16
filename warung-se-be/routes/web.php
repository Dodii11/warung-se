<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;



Route::get('api/menu-image/{folder}/{filename}', function ($folder, $filename) {
    $path = storage_path("app/public/$folder/$filename");

    if (!file_exists($path)) {
        abort(404);
    }

    return Response::file($path);
});
            