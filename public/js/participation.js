document.addEventListener('DOMContentLoaded', function() {
    var modalDefault = document.getElementById('modal-default');
    modalDefault.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        
        var btnAccept = document.getElementById('accept');
        var btnRejected = document.getElementById('reject');

        var name = button.getAttribute('data-namep');
        var email = button.getAttribute('data-emailp');
        var reasons = button.getAttribute('data-reasonsp');
        var phone = button.getAttribute('data-phonep');
        var status = button.getAttribute('data-statusp');


        if (status == 'accepted') {
            btnAccept.classList.add('d-none'); 
            btnRejected.classList.remove('d-none'); 
        } else if (status == 'rejected') {
            btnRejected.classList.add('d-none'); 
            btnAccept.classList.remove('d-none'); 
        } else {
            btnAccept.classList.remove('d-none');  
            btnRejected.classList.remove('d-none');
        }

        var nameDisplay = document.getElementById('name');
        var emailDisplay = document.getElementById('email');
        var phoneDisplay = document.getElementById('phone');
        var reasonsDisplay = document.getElementById('reasons');
        var imageDisplay = document.getElementById('image-user');

        nameDisplay.textContent = name;
        emailDisplay.textContent = email;
        reasonsDisplay.textContent = reasons;
        phoneDisplay.textContent = "+216 " + phone;
        imageDisplay.src = imageSrc;

        var participantId = button.getAttribute('data-participant-id'); 
        console.log(participantId);
        var formA = document.getElementById('accept-form');
        var formR = document.getElementById('reject-form');
     
        if (formA) {
            formA.action = `/participants/${participantId}/accept`;
        }
        if (formR) {
            formR.action = `/participants/${participantId}/reject`;
        }

    });

});


//livesearch participation list

const searchRouteP = '/participants/search';
document.addEventListener('DOMContentLoaded', function() {
const campaignId = document.getElementById('campaignId').value;

document.getElementById('searchInputP').addEventListener('keyup', function() {
    let query = this.value;
    console.log(query);

    fetch(searchRouteP + "/" + campaignId + "?query=" + query)
        .then(response => response.json())
        .then(data => {
            
            let results = '';
            const thead = 
                `  <thead>
                        <tr>
                            <th class="border-gray-200">Name</th>						
                            <th class="border-gray-200">Email</th>
                            <th class="border-gray-200">Phone</th>
                            <th class="border-gray-200">Date created</th>
                            <th class="border-gray-200">Status</th>
                            <th class="border-gray-200">Action</th>
                        </tr>
                    </thead>`
            data.forEach(participation => {
                var createdAtDate = new Date(participation.created_at); 
                var options = { 
                    weekday: 'long',  
                    year: 'numeric',  
                    month: 'long',    
                    day: 'numeric'   
                };
                var formattedCreatedAtDate = createdAtDate.toLocaleDateString('en-US', options);
                results += `
                
                <tr>
              
                <td>
                    <span class="fw-normal">${participation.user.name }</span>
                </td>
                <td><span class="fw-normal">${participation.user.email }</span></td>                        
                <td><span class="fw-normal">${participation.user.phone }</span></td>
                <td><span class="fw-normal">${formattedCreatedAtDate }</span></td>
                <td>
                   ${getStatusBadge(participation.status)}
                </td>
                <td> 
                    <div class="btn-group">
                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="icon icon-sm">
                                <span class="fas fa-ellipsis-h icon-dark"></span>
                            </span>
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu py-0">
                            <a class="dropdown-item rounded-top" data-bs-toggle="modal" data-bs-target="#modal-default"  data-namep="${participation.name }" data-phonep="${participation.phone }" data-emailp="${participation.email}" data-reasonsp="${participation.reasons }" data-participant-id="${participation.id}" data-statusp="${participation.status}"><span class="fas fa-eye me-2" ></span>View Details</a>

                            <button type="button" class="dropdown-item text-danger rounded-bottom" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modal-confirmationsuppression-participant"
                                        data-participant-id="${participation.id}">
                                    <span class="fas fa-trash-alt me-2"></span>Remove
                                </button>                        
                        </div>
                    </div>
                </td>
            </tr>         `; 
            });
            document.getElementById('participationList').innerHTML = thead+results;
        })
        .catch(error => console.log(error));
})

//search participation by status

const searchRouteStatusP = '/participants/searchByStatusP';

const selectElement = document.getElementById('statusP');
selectElement.addEventListener('change', function() {
    const selectedValue = selectElement.value;
    fetch(searchRouteStatusP + "/" + campaignId + "?query=" + selectedValue)
        .then(response => response.json())
        .then(data => {
            let results = '';
            const thead = 
                `  <thead>
                        <tr>
                            <th class="border-gray-200">Name</th>						
                            <th class="border-gray-200">Email</th>
                            <th class="border-gray-200">Phone</th>
                            <th class="border-gray-200">Date created</th>
                            <th class="border-gray-200">Status</th>
                            <th class="border-gray-200">Action</th>
                        </tr>
                    </thead>`
            data.forEach(participation => {
                var createdAtDate = new Date(participation.created_at); 
                var options = { 
                    weekday: 'long',  
                    year: 'numeric',  
                    month: 'long',    
                    day: 'numeric'   
                };
                var formattedCreatedAtDate = createdAtDate.toLocaleDateString('en-US', options);
                results += `
                
                <tr>
              
                <td>
                    <span class="fw-normal">${participation.user.name }</span>
                </td>
                <td><span class="fw-normal">${participation.user.email }</span></td>                        
                <td><span class="fw-normal">${participation.user.phone }</span></td>
                <td><span class="fw-normal">${formattedCreatedAtDate }</span></td>
                <td>
                   ${getStatusBadge(participation.status)}
                </td>
                 <td> 
                    <div class="btn-group">
                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="icon icon-sm">
                                <span class="fas fa-ellipsis-h icon-dark"></span>
                            </span>
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu py-0">
                            <a class="dropdown-item rounded-top" data-bs-toggle="modal" data-bs-target="#modal-default"  data-namep="${participation.name }" data-phonep="${participation.phone }" data-emailp="${participation.email}" data-reasonsp="${participation.reasons }" data-participant-id="${participation.id}" data-statusp="${participation.status}"><span class="fas fa-eye me-2" ></span>View Details</a>

                            <button type="button" class="dropdown-item text-danger rounded-bottom" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modal-confirmationsuppression-participant"
                                        data-participant-id="${participation.id}">
                                    <span class="fas fa-trash-alt me-2"></span>Remove
                                </button>                        
                        </div>
                    </div>
                </td>
            </tr>         `; 
            });
            document.getElementById('participationList').innerHTML = thead+results;
        })
        .catch(error => console.log(error));
    
})});




function getStatusBadge(status) {
    if (status === 'pending') return '<span class="fw-bold status-pending">Pending</span>';
    if (status === 'accepted') return '<span class="fw-bold status-active">Accepted</span>';
    if (status === 'rejected') return '<span class="fw-bold status-archived">Rejected</span>';
}


document.addEventListener('DOMContentLoaded', function() {
    const usersSelect = document.getElementById('users');
    
    fetch('/getUsers')
        .then(response => response.json() )  
        .then(users => {
            users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.name;  
                option.textContent = user.name; 
                usersSelect.appendChild(option);  
            });
        })
        .catch(error => console.error('Error fetching users:', error));  
});