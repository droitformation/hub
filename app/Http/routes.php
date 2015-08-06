<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('ok', function () {
    echo 'ok redirection';
});

Route::get('oauth/authorize', ['as' => 'oauth.authorize.get','middleware' => ['check-authorization-params', 'auth'], function() {
    // display a form where the user can authorize the client to access it's data
    $authParams = Authorizer::getAuthCodeRequestParams();
    $formParams = array_except($authParams,'client');
    $formParams['client_id'] = $authParams['client']->getId();
    return view('oauth.authorization-form', ['params'=>$formParams,'client'=>$authParams['client']]);
}]);

Route::post('oauth/authorize', ['as' => 'oauth.authorize.post','middleware' => ['check-authorization-params', 'auth'], function() {

    $params = Authorizer::getAuthCodeRequestParams();
    $params['user_id'] = Auth::user()->id;

    $redirectUri = '';

    // if the user has allowed the client to access its data, redirect back to the client with an auth code
    if (Input::get('approve') !== null) {
        $redirectUri = Authorizer::issueAuthCode('user', $params['user_id'], $params);
    }

    // if the user has denied the client to access its data, redirect back to the client with an error message
    if (Input::get('deny') !== null) {
        $redirectUri = Authorizer::authCodeRequestDeniedRedirectUri();
    }

    return Redirect::to($redirectUri);

}]);

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::get('api/user', ['middleware' => 'oauth', function(){

    $user_id = Authorizer::getResourceOwnerId();
    $user    = \App\User::find($user_id);

    return Response::json(['first_name' => $user->first_name, 'last_name' => $user->last_name, 'email' => $user->email, 'id' => $user_id]);

}]);


/* **************************
* Authentication routes...
* ***************************/
Route::get('login/{provider?}', 'Auth\AuthController@login');

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
