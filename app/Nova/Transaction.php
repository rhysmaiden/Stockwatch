<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Http\Requests\NovaRequest;

class Transaction extends Resource
{
    public static $model = \App\Models\Transaction::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(Request $request)
    {
        return [
            BelongsTo::make('User'),
            BelongsTo::make('Houseguest'),
            Text::make('Action'),
            Number::make('Quantity'),
            Currency::make('At Price', 'current_price')
        ];
    }
}
