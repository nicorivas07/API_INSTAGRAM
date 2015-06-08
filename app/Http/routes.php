<?php

Route::group(array('prefix' => 'locations'), function()
{
    Route::group(array('prefix' => 'instagram'), function ()
    {
        Route::get('/{media_id}', 'InstagramController@index');
    });

});
