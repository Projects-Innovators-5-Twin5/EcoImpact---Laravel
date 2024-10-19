
//livesearch compaign list
const searchRoute = '/search';
document.addEventListener('DOMContentLoaded', function() {
document.getElementById('searchInput').addEventListener('keyup', function() {
    let query = this.value;

    fetch(searchRoute + "?query=" + query)
        .then(response => response.json())
        .then(data => {
            let results = '';
            const thead = 
                `<thead>
                    <tr>
                        <th class="border-gray-200">Title</th>						
                        <th class="border-gray-200">Start Date</th>
                        <th class="border-gray-200">End Date</th>
                        <th class="border-gray-200">target audience</th>
                        <th class="border-gray-200">Status</th>
                        <th class="border-gray-200">Action</th>
                    </tr>
                </thead>`
            data.forEach(campaign => {
                var startDate = new Date(campaign.start_date); 
                var endDate = new Date(campaign.end_date); 
                var options = { 
                    weekday: 'long',  
                    year: 'numeric',  
                    month: 'long',    
                    day: 'numeric'   
                };
                var formattedStartDate = startDate.toLocaleDateString('en-US', options);
                var formattedEndDate = endDate.toLocaleDateString('en-US', options);
                results += `
                
                <tr>
              
                <td>
                    <span class="fw-normal">${campaign.title }</span>
                </td>
                <td><span class="fw-normal">${formattedStartDate }</span></td>                        
                <td><span class="fw-normal">${formattedEndDate }</span></td>
                    <td>
                        ${campaign.target_audience.map(audience => `<div>${audience}</div>`).join('')} 
                    </td>
                <td>
                   ${getStatusBadge(campaign.status)}
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
                            <a class="dropdown-item rounded-top" href="/campaigns/back/show/${campaign.id}"><span class="fas fa-eye me-2"></span>View Details</a>

                            <a class="dropdown-item" href="/campaigns/${campaign.id}/edit"><span class="fas fa-edit me-2" ></span>Edit</a>   

                            <button type="button" class="dropdown-item text-danger rounded-bottom" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modal-confirmationsuppression"
                                        data-campaign-id="${campaign.id }}">
                                    <span class="fas fa-trash-alt me-2"></span>Remove
                                </button>                        
                        </div>
                    </div>
                </td>
            </tr>         `; 
            });
            document.getElementById('campaignList').innerHTML = thead+results;
        })
        .catch(error => console.log(error));
})

//search by status

const searchRouteStatus = '/searchByStatus';

const selectElement = document.getElementById('status');
selectElement.addEventListener('change', function() {
    const selectedValue = selectElement.value;
    fetch(searchRouteStatus + "?query=" + selectedValue)
        .then(response => response.json())
        .then(data => {
            let results = '';
            const thead = 
                `<thead>
                    <tr>
                       <th class="border-gray-200">Title</th>						
                        <th class="border-gray-200">Start Date</th>
                        <th class="border-gray-200">End Date</th>
                        <th class="border-gray-200">target audience</th>
                        <th class="border-gray-200">Status</th>
                        <th class="border-gray-200">Action</th>
                    </tr>
                </thead>`
            data.forEach(campaign => {
                var startDate = new Date(campaign.start_date); 
                var endDate = new Date(campaign.end_date); 
                var options = { 
                    weekday: 'long',  
                    year: 'numeric',  
                    month: 'long',    
                    day: 'numeric'   
                };
                var formattedStartDate = startDate.toLocaleDateString('en-US', options);
                var formattedEndDate = endDate.toLocaleDateString('en-US', options);
                results += `
                
                <tr>
             
                <td>
                    <span class="fw-normal">${campaign.title }</span>
                </td>
                <td><span class="fw-normal">${formattedStartDate }</span></td>                        
                <td><span class="fw-normal">${formattedEndDate }</span></td>
                    <td>
                        ${campaign.target_audience.map(audience => `<div>${audience}</div>`).join('')} 
                    </td>
                <td>
                   ${getStatusBadge(campaign.status)}
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
                            <a class="dropdown-item rounded-top" href="/campaigns/back/show/${campaign.id}"><span class="fas fa-eye me-2"></span>View Details</a>

                            <a class="dropdown-item" href="/campaigns/${campaign.id}/edit"><span class="fas fa-edit me-2" ></span>Edit</a>   

                            <button type="button" class="dropdown-item text-danger rounded-bottom" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modal-confirmationsuppression"
                                        data-campaign-id="${campaign.id }}">
                                    <span class="fas fa-trash-alt me-2"></span>Remove
                                </button>                        
                        </div>
                    </div>
                </td>
            </tr>         `; 
            });
            document.getElementById('campaignList').innerHTML = thead+results;
        })
        .catch(error => console.log(error));
    
})});



function getStatusBadge(status) {
    if (status === 'active') return '<span class="fw-bold status-active">active</span>';
    if (status === 'upcoming') return '<span class="fw-bold status-upcoming">upcoming</span>';
    if (status === 'completed') return '<span class="fw-bold status-completed">completed</span>';
    return '<span class="fw-bold status-archived">archived</span>';
}






//fixer lemodal create quand il ya une erreur
document.addEventListener('DOMContentLoaded', function() {
    var errorsExist = document.getElementById('error-exist').value === 'true';
    
    if (errorsExist) {
        var modal = document.getElementById('modal-createC-form');
        modal.classList.add('show'); 
        modal.style.display = 'block';
    }


    const title = document.getElementById('title');
    const start_date = document.getElementById('start_date');
    const end_date = document.getElementById('end_date');
    const description = document.getElementById('description');
    const image = document.getElementById('image');

    const errorTitle = document.getElementById('error-title');

    const errorSdate = document.getElementById('error-startdate');
    const errorEdate = document.getElementById('error-enddate')
    const errorImage = document.getElementById('error-image')
    const errorDes = document.getElementById('error-description')


    
    title.addEventListener('input', function() {
        if (title.value.trim() !== '' && title.value.length >= 4 ) { 
            title.classList.add('is-valid');
            title.classList.remove('is-invalid'); 
            errorTitle.classList.add('d-none'); 
        } else {
            title.classList.remove('is-valid'); 
            title.classList.add('is-invalid'); 
            errorTitle.classList.remove('d-none'); 
            errorTitle.textContent = 'Title is invalid'
        }
    });


    /*const today = new Date();
    const startDateValue = new Date(start_date.value);
    console.log(today);
    console.log(start_date.value)
    console.log(startDateValue)
    start_date.addEventListener('input', function() {
        if (start_date.value.trim() !== '' && startDateValue.getTime() >= today.getTime()) { 
            start_date.classList.add('is-valid');
            start_date.classList.remove('is-invalid'); 
            errorSdate.classList.add('d-none'); 

        } else {
            start_date.classList.remove('is-valid'); 
            start_date.classList.add('is-invalid'); 
            errorSdate.classList.remove('d-none'); 
            errorSdate.textContent = 'Start date is invalid'
        }
    });


    const endDateValue = new Date(end_date.value);
    console.log(today);
    console.log(end_date.value)
    console.log(endDateValue)
    end_date.addEventListener('input', function() {
        if (end_date.value.trim() !== '' && endDateValue.getTime() <= startDateValue.getTime()) { 
            end_date.classList.add('is-valid');
            end_date.classList.remove('is-invalid'); 
            errorEdate.classList.add('d-none'); 
        } else {
            end_date.classList.remove('is-valid'); 
            end_date.classList.add('is-invalid'); 
            errorEdate.classList.remove('d-none'); 
            errorEdate.textContent = 'End date is invalid'
        }
    });*/


    description.addEventListener('input', function() {
        if (description.value.trim() !== '' && description.value.length >= 150 ) { 
            description.classList.add('is-valid');
            description.classList.remove('is-invalid'); 
            errorDes.classList.add('d-none'); 

        } else {
            description.classList.remove('is-valid'); 
            description.classList.add('is-invalid'); 
            errorDes.classList.remove('d-none'); 
            errorDes.textContent = 'Description is invalid';
        }
    });

    image.addEventListener('input', function() {
        const allowedExtensions = ['jpg', 'jpeg', 'png' , 'gif'];
        const fileExtension = image.value.split('.').pop().toLowerCase();

        if (image.value.trim() !== '' && allowedExtensions.includes(fileExtension)) { 
            image.classList.add('is-valid');
            image.classList.remove('is-invalid'); 
            errorImage.classList.add('d-none'); 

        } else {
            image.classList.remove('is-valid'); 
            image.classList.add('is-invalid'); 
            errorImage.classList.remove('d-none'); 
            errorImage.textContent = 'Image is invalid';

        }
    });

});
