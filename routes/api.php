<?php

use Illuminate\Http\Request;

Route::get('timecode', 'ApiController@timecode')->name('api.timecode');
Route::get('scenes', 'ApiController@scenes')->name('api.scenes');
Route::get('sections', 'ApiController@sections')->name('api.sections');
Route::get('sections/{section_id}', 'ApiController@events')->name('api.section.events');
Route::get('events', 'ApiController@allEvents')->name('api.events');
