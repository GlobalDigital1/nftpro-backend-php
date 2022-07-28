<?php

namespace App\Nova;

use App\Models\Config as ConfigModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class Config extends Resource
{
    public static $model = ConfigModel::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(Request $request): array
    {
        return [
            Text::make('Ios Min Version')
                ->sortable()
                ->rules('required'),

            Number::make('Eth Mint Price')
                ->sortable()
                ->rules('required', 'min:0'),

            Number::make('Polygon Mint Price')
                ->sortable()
                ->rules('required', 'min:0'),
        ];
    }

    public function cards(Request $request): array
    {
        return [];
    }

    public function filters(Request $request): array
    {
        return [];
    }

    public function lenses(Request $request): array
    {
        return [];
    }

    public function actions(Request $request): array
    {
        return [];
    }

    public static function label()
    {
        return 'Config';
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public function authorizedToReplicate(Request $request)
    {
        return false;
    }
}
