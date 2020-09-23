<?php

namespace Bernhardh\NovaRedirectTester\Nova;

use Bernhardh\NovaRedirectTester\Models\NovaRedirectTester;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class RedirectTest extends \App\Nova\Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = NovaRedirectTester::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'url_from';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'url_from'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            BelongsTo::make('Group', 'redirectTesterGroup', RedirectTestGroup::class)
                ->rules('required')
                ->showCreateRelationButton(true),
            Select::make("Status Code", "expected_status_code")
                ->options([
                    301 => "301 Moved Permanently",
                    404 => "404 Not found",
                ])
                ->rules('required')
                ->default(301)
                ->sortable(),
            Text::make("Url From", "url_from")
                ->rules('required')
                ->sortable(),
            Text::make("Url To", "url_to")
                ->sortable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
