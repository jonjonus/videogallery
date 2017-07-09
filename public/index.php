<?php

// TODO 1. check if the session expired to avoid unhandled errors
// TODO 2. on ajax calls handle expired sessions, reload page on response
// TODO 3. ask if close when not saving changes (modal and panel)
// TODO 4. check if the playlist loaded is the same and if it has change (videos)
// TODO 5. para los videos de youtube ocultar el embed code
// TODO 5. cambiar $cipher = 'AES-128-CBC' x 256
// TODO 6. xq los checkboxes submitean todo el row?
// TODO 7. cuando cargas una lista si la que esta no fue modificada no deberia preguntarte si queres perder los cambios
// TODO 8. deal with the expired sessions (http and ajax)



/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylorotwell@gmail.com>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/

require __DIR__.'/../bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
