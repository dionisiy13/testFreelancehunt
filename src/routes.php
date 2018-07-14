<?php

use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::group(['namespace' => '\Core\Controller'], function () {

    SimpleRouter::get('/get-all', 'RestController@getAllAction');
    SimpleRouter::get('/get-countries', 'RestController@getCountriesAction');
    SimpleRouter::get('/get-users-filtered', 'RestController@getUsersFilteredAction');


});

SimpleRouter::group(['namespace' => '\Core\Controller'], function () {
    SimpleRouter::get('/not-found', 'PageController@notFound');
    SimpleRouter::get('/', 'PageController@indexAction');
});

SimpleRouter::error(function(\Pecee\Http\Request $request, \Exception $exception) {

    if($exception instanceof \Pecee\SimpleRouter\Exceptions\NotFoundHttpException && $exception->getCode() === 404) {
        (new \Pecee\Http\Response(new \Pecee\Http\Request()))->redirect('/not-found');
    }

});
