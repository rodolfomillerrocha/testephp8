<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\View\View;

class FilamentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        FilamentView::registerRenderHook(
            'panels::body.end',
            fn (): View => view('filament.hooks.body-end'),
            scopes: [
                \App\Filament\Resources\LayerResource::class,
            ],
        );
    }
}






