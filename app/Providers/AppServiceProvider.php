<?php

namespace App\Providers;


use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use BezhanSalleh\PanelSwitch\PanelSwitch;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       
        // Super-Admin hat immer alle Berechtigungen
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super-Admin') ? true : null;
        });



        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
        $panelSwitch
        ->visible(fn (): bool => auth()->user()?->hasAnyRole([
            'admin',
            'Super-Admin',
        ]))
        ->canSwitchPanels(fn (): bool => auth()->user()?->hasAnyRole([
            'admin',
            'Super-Admin',
        ]))
        ->modalHeading('Available Panels')
        ->modalWidth('sm')
        ->slideOver()
        ->icons([
            'dashboard' => 'heroicon-o-star',
            'configure' => 'heroicon-o-square-2-stack',
        ])
        ->iconSize(16)
        ->labels([
            'dashboard' => 'Application',
            'configure' => 'Admin Panel',
        ]);


});
    }
}
