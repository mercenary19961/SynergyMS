<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Illuminate\Support\Facades\Gate;

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
        Livewire::component('user-search', \App\Http\Livewire\UserSearch::class);
        Livewire::component('priority-dropdown', \App\Http\Livewire\PriorityDropdown::class);
        Livewire::component('notifications', \App\Http\Livewire\Notifications::class);
        Livewire::component('notification-page', \App\Http\Livewire\NotificationPage::class);
        Livewire::component(('notification-bell'), \App\Http\Livewire\NotificationBell::class);
        Livewire::component('popup-message', \App\Http\Livewire\PopupMessage::class);
        Livewire::component('registration-form', \App\Http\Livewire\Register\RegistrationForm::class);
        Livewire::component('register.client-component', \App\Http\Livewire\Register\ClientComponent::class);
        Livewire::component(('calendar'), \App\Http\Livewire\Calendar::class);
        Livewire::component(('events'), \App\Http\Livewire\Events::class);
        Livewire::component(('employee-summary-card'), \App\Http\Livewire\EmployeeSummaryCard::class);
        Livewire::component(('assigned-tasks'), \App\Http\Livewire\AssignedTasks::class);
        Livewire::component(('assigned-projects'), \App\Http\Livewire\AssignedProjects::class);
        Livewire::component(('assigned-tickets'), \App\Http\Livewire\AssignedTickets::class);
        Livewire::component(('clock-out-button'), \App\Http\Livewire\ClockOutButton::class);
    }
}
