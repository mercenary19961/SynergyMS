<div wire:ignore>
    <div id="fullCalendar"></div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css" rel="stylesheet">

<script>
    document.addEventListener('livewire:load', function () {
        // Initialize FullCalendar with options
        var calendarEl = document.getElementById('fullCalendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: @json($events), // Pass events from the Livewire component
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            selectable: true,
            editable: true
        });
        
        calendar.render();
    });
</script>
@endpush
