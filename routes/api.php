<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get('/redirects', function (Request $request) {
    $rows = \Bernhardh\NovaRedirectTester\Models\NovaRedirectTesterGroup::query()
        ->has("items")
        ->get();

    $validUrl = function($url) {
        if(!filter_var($url, FILTER_VALIDATE_URL)) {
            return url($url);
        }
        return $url;
    };

    if($rows) {
        return $rows->map(function($row) use ($validUrl) {
            return [
                "name" => $row->name,
                "description" => $row->description,
                "items" => $row->items->map(function($item) use ($validUrl) {
                    return [
                        "url_from" => $validUrl($item->url_from),
                        "url_to" => $validUrl($item->url_to),
                        "expected_status_code" => $item->expected_status_code
                    ];
                })
            ];
        });
    }

    return [];
});
