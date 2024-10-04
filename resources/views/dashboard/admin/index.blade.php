@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <!-- Timesheet Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Timesheet Card -->
            <div class="bg-white p-6 rounded shadow text-center xxs:w-3/4 w-full xs:w-full sm:w-full md:w-full lg:w-full xl:w-full">
                <h2 class="text-xl font-semibold mb-4">Timesheet {{ \Carbon\Carbon::now()->format('D M Y') }}</h2>
                <div class="text-4xl font-bold mb-4">0 Hours</div>
                <button class="bg-orange-500 text-white py-2 px-6 rounded-full mb-4">Clock Out</button>
                <p>Started At <span class="font-semibold">{{ \Carbon\Carbon::now()->format('H:i:s A') }}</span></p>
            </div>

            <!-- Statistics Card -->
            <div class="bg-white p-6 rounded shadow xxs:w-3/4 w-full xs:w-full sm:w-full md:w-full lg:w-full xl:w-full">
                <h2 class="text-xl font-semibold mb-4">Statistics</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-semibold">Today</p>
                        <p class="text-lg font-bold">0 Hours</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">This Week</p>
                        <p class="text-lg font-bold">0 Hours</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">This Month</p>
                        <p class="text-lg font-bold">0 Hours</p>
                    </div>
                </div>
            </div>

            <!-- Today's Activity Card -->
            <div class="bg-white p-6 rounded shadow xxs:w-3/4 w-full xs:w-full sm:w-full md:w-full lg:w-full xl:w-full">
                <h2 class="text-xl font-semibold mb-4">Today Activity</h2>
                <ul class="space-y-2">
                    <li>
                        <p>Punch In at <span class="font-semibold">15:38 PM</span></p>
                    </li>
                    <li>
                        <p>Punch Out at <span class="font-semibold">15:42 PM</span></p>
                    </li>
                    <li>
                        <p>Punch In at <span class="font-semibold">16:13 PM</span></p>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Log Table -->
        <div class="mt-8 ">
            <h2 class="text-xl font-bold mb-4">Daily Logs</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-4 text-left">#</th>
                            <th class="py-2 px-4 text-left">Date</th>
                            <th class="py-2 px-4 text-left">Punch In</th>
                            <th class="py-2 px-4 text-left">Punch Out</th>
                            <th class="py-2 px-4 text-left">Total Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example rows -->
                        <tr class="border-t">
                            <td class="py-2 px-4">1</td>
                            <td class="py-2 px-4">Tue Jul 2024</td>
                            <td class="py-2 px-4">15 PM</td>
                            <td class="py-2 px-4">15 PM</td>
                            <td class="py-2 px-4">0</td>
                        </tr>
                        <tr class="border-t">
                            <td class="py-2 px-4">2</td>
                            <td class="py-2 px-4">Tue Jul 2024</td>
                            <td class="py-2 px-4">16 PM</td>
                            <td class="py-2 px-4"></td>
                            <td class="py-2 px-4">0</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
