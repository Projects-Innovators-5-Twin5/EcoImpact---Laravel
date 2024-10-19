import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction'; 


function getCookie(name) {
    let cookieValue = null;
    if (document.cookie && document.cookie !== '') {
        const cookies = document.cookie.split(';');
        for (let i = 0; i < cookies.length; i++) {
            const cookie = cookies[i].trim();
            if (cookie.substring(0, name.length + 1) === (name + '=')) {
                cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                break;
            }
        }
    }
    return cookieValue;
}


const csrfToken = getCookie('XSRF-TOKEN');

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
     console.log(calendar)
    if (calendarEl) {
        var calendar = new Calendar(calendarEl, {
            plugins: [ dayGridPlugin, timeGridPlugin, interactionPlugin ],
            initialView: 'dayGridMonth',
            editable: true,
            selectable: true,
            events: [
              
            ],
            eventDrop: function(info) {
                updateEvent(info.event); 
            },
            
            eventResize: function(info) {
                updateEvent(info.event); 
            }
        });
    }
    fetch('/calendarData')
            .then(response => response.json())
            .then(campaigns => {
                const events = campaigns.map(campaign => {
                    let endDate = new Date(campaign.end_date);
                    endDate.setDate(endDate.getDate() + 1);
    
                    return {
                        id:campaign.id,
                        title: campaign.title,
                        start: campaign.start_date,
                        end: endDate.toISOString().split('T')[0], 
                        color: getColorByStatus(campaign.status)
                    };
                });
    
                calendar.addEventSource(events);
                calendar.render();
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des campagnes:', error);
            });

            function updateEvent(event) {
                let startDate = new Date(event.start); 
                startDate.setDate(startDate.getDate() + 1);
                let updatedEvent = {
                    id: event.id,
                    start: startDate.toISOString().split('T')[0], 
                    end: event.end ? event.end.toISOString().split('T')[0] : null  
                };
        
                fetch('/calendar/updateEvent', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-XSRF-TOKEN': csrfToken 

                    },
                    body: JSON.stringify(updatedEvent) 
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors de la mise à jour de l\'événement');
                    }
                    console.log(updatedEvent)
                    console.log('Événement mis à jour avec succès');
                })
                .catch(error => {
                    console.error('Erreur lors de la mise à jour de l\'événement:', error);
                    alert('La modification n\'a pas pu être enregistrée.');
                });
            }        
})


function getColorByStatus(status) {
    switch (status) {
        case 'active':
            return '#28a745'; 
        case 'upcoming':
            return '#007bff'; 
        case 'completed':
            return '#fd7e14'; 
        default:
            return 'gray'; 
    }
}



