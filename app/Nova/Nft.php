<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Nft extends Resource
{
    public static $model = \App\Models\Nft::class;

    public static $title = 'name';

    public static $search = [
        'id', 'name', 'contract_address', 'token_id',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Owner Address')
                ->sortable()
                ->rules('required'),

            Text::make('Name')
                ->sortable()
                ->rules('required'),

            Text::make('Blockchain')
                ->sortable()
                ->rules('required'),

            Text::make('Description')
                ->sortable()
                ->rules('nullable'),

            Text::make('Image Url')
                ->sortable()
                ->rules('required'),

            Text::make('Contract Address')
                ->sortable()
                ->rules('required'),

            Text::make('Token Id')
                ->sortable()
                ->rules('required'),

            Text::make('Transaction Hash')
                ->sortable()
                ->rules('required'),

            Boolean::make('Is Available')
                   ->sortable()
                   ->readonly(),

            DateTime::make('Created At')
                    ->sortable()
                    ->readonly(),
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
}
