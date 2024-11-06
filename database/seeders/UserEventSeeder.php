<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;

class UserEventSeeder extends Seeder
{
    public function run()
    {
        // Define which events to attach to specific users
        // Here, we're assuming user ID 4 and user ID 2 exist
        $user1 = User::find(4); // Adjust to your actual user ID
        $user2 = User::find(2); // Adjust to your actual user ID

        // Fetch events by name or ID from the seeded data
        $event1 = Event::where('name', 'Annual Company Retreat')->first();
        $event2 = Event::where('name', 'Quarterly Performance Review')->first();
        $event3 = Event::where('name', 'Client Project Kickoff')->first();

        // Attach events to the first user
        if ($user1 && $event1) {
            $user1->events()->attach($event1->id, ['is_attending' => true]);
        }

        if ($user1 && $event2) {
            $user1->events()->attach($event2->id, ['is_attending' => null]);
        }

        // Attach events to the second user
        if ($user2 && $event2) {
            $user2->events()->attach($event2->id, ['is_attending' => true]);
        }

        if ($user2 && $event3) {
            $user2->events()->attach($event3->id, ['is_attending' => true]);
        }

    }
}
