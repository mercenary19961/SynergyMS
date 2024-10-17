<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

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
        Livewire::component('summary-card', \App\Http\Livewire\SummaryCard::class);
        Livewire::component('recent-employees', \App\Http\Livewire\RecentEmployees::class);
        Livewire::component('recent-clients', \App\Http\Livewire\RecentClients::class);
        Livewire::component('recent-projects', \App\Http\Livewire\RecentProjects::class);
        Livewire::component('present-employees', \App\Http\Livewire\PresentEmployees::class);
        Livewire::component('absent-employees', \App\Http\Livewire\AbsentEmployees::class);
    }
}
