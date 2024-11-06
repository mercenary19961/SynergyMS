<div wire:ignore>
    <div id="fullCalendar" style="width: 100%; height: 600px;"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('fullCalendar');
        if (!calendarEl) {
            console.error("Calendar element not found!");
            return;
        }

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            selectable: true,
            editable: true,
            events: @json($events),

            eventContent: function(info) {
                var eventName = info.event.title;
                var eventStartHour = new Date(info.event.start).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                var eventEl = document.createElement('div');
                eventEl.innerHTML = eventName;
                eventEl.style.fontSize = '8px';
                eventEl.style.fontWeight = 'bold';
                eventEl.style.color = '#00796b';
                eventEl.style.backgroundColor = '#e0f2f1';
                eventEl.style.padding = '1px 3px';
                eventEl.style.borderRadius = '5px';
                eventEl.style.cursor = 'pointer';
                eventEl.style.transition = 'all 0.3s ease';
                eventEl.style.textAlign = 'center';
                eventEl.style.whiteSpace = 'normal';
                eventEl.style.overflowWrap = 'break-word';

                // Tooltip logic
                eventEl.title = "Start Time: " + eventStartHour;

                eventEl.addEventListener('mouseover', function() {
                    eventEl.style.textDecoration = 'underline';
                    eventEl.style.backgroundColor = '#b2dfdb';
                    eventEl.style.color = '#004d40';
                    eventEl.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.2)';
                });
                eventEl.addEventListener('mouseout', function() {
                    eventEl.style.textDecoration = 'none';
                    eventEl.style.backgroundColor = '#e0f2f1';
                    eventEl.style.color = '#00796b';
                    eventEl.style.boxShadow = 'none';
                });

                eventEl.addEventListener('click', function() {
                    if (info.event.id) {
                        window.location.href = `/admin/events/${info.event.id}`;
                    } else {
                        console.error("Event ID not found!");
                    }
                });

                return { domNodes: [eventEl] };
            }
        });

        calendar.render();
    });
</script>
