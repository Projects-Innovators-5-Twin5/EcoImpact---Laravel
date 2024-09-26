@extends('back.layout')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.11/jspdf.plugin.autotable.min.js"></script>
<script src="jspdf.min.js"></script>
<script src="jspdf.plugin.autotable.min.js"></script>



<div class="container mt-4">
   
    <div class="card shadow-sm">
        
        <div class="card-body">
            <h3 class="mb-4 text-center" style="font-size: 1.5rem; font-weight: bold; color: #343a40; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 30px;">
                Détails de la consommation énergétique
            </h3>

            <div class="mb-4 d-flex align-items-center">
    <h5 class="me-3" style="margin: 0; color: #343a40; font-weight: bold;">Recherche</h5>
    <input type="text" id="searchInput" placeholder="Rechercher par nom..." class="form-control me-2" style="width: 300px;">
    <button id="downloadPdfBtn" class="btn" style="background-color: #ff948b; border: none; padding: 10px 15px; display: flex; align-items: center; cursor: pointer;">
    <i class="fas fa-file-pdf" style="margin-right: 5px;"></i> 
    Télécharger en PDF
</button>

</div>



<div class="table-responsive">
    <table class="custom-table align-items-center table-flush" id="consumptionTable">
        <thead class="thead-light">
            <tr>
                <th class="border-bottom" scope="col">Nom de l'utilisateur</th>
                <th class="border-bottom" scope="col">Valeur totale de consommation (kWh)</th>
                <th class="border-bottom" scope="col">Valeur totale de carbone</th>
                <th class="border-bottom" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="text-gray-900">{{ $user->name }}</td>
                <td class="fw-bolder text-gray-500">{{ number_format($user->consumptions->sum('energy_value'), 2) }}</td>
                <td class="fw-bolder text-gray-500">{{ number_format($user->consumptions->sum('carbon_value'), 2) }}</td>
                <td>
                    <button onclick="openModal({{ $user->id }})" class="btn btn-link" style="padding: 0; color:#e8cb68;">
                        <i class="fas fa-eye" title="Voir les consommations" style="font-size: 1rem;"></i>
                    </button>
                    <button class="btn btn-link" style="color: #4689b4; padding: 0;" title="Modifier" onclick="window.location.href='{{ route('editConsumptionback', $user->id) }}'">
                        <i class="fas fa-pencil-alt" style="font-size: 1rem;"></i>
                    </button>
                    <form action="{{ route('consumptionsback.delete', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link" style="color: red; padding: 0;" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette consommation ?');">
                            <i class="fas fa-trash" style="font-size: 1rem;"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination Controls -->
<div id="paginationControls" style="text-align: center; margin-top: 20px;">
    <!-- Pagination buttons will be added here -->
</div>


            <!-- Overlay for the modal -->
            <div id="modalOverlay" style="display:none;" class="modal-overlay" onclick="closeModal()"></div>

            <!-- Modal for displaying consumption details -->
            <div id="consumptionModal" style="display:none; position: fixed; top: 20%; left: 50%; transform: translate(-50%, -20%); background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3); max-width: 800px; width: 90%; z-index: 1001;">
                <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e0e0e0; padding-bottom: 10px;">
                    <h2 id="modalTitle" style="margin: 0; font-size: 24px;">Liste de consommations</h2>
                    <span class="close" onclick="closeModal()" style="cursor: pointer; font-size: 24px; color: #e5d982;">&times;</span>
                </div>
                <div style="max-height: 400px; overflow-y: auto; margin-top: 15px;">
                    <table class="custom-table" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                        <thead class="thead-light">
                            <tr>
                                <th>Date de consommation</th>
                                <th>Valeur de consommation (kWh)</th>
                                <th>Type de consommation</th>
                                <th>Valeur de carbone</th>
                            </tr>
                        </thead>
                        <tbody id="modalTableBody">
                            <!-- Data will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>




















<script>

function updateChart(energyType) {
    // Fetch total energy consumption data for all users by energy type
    fetch(`/api/consumption/${energyType}`)
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('consumptionChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'line', // Change this to 'bar' if you prefer a bar chart
                data: {
                    labels: data.dates, // Assuming you have dates for the x-axis
                    datasets: [{
                        label: `Consommation totale pour ${energyType}`,
                        data: data.consumptionValues, // Consumption values for the selected energy type
                        backgroundColor: 'rgba(100, 212, 187, 0.5)',
                        borderColor: '#64d4bb',
                        borderWidth: 2,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Consommation (kWh)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error fetching consumption data:', error);
        });
}
    // Function to filter table based on search input
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#consumptionTable tbody tr');
        rows.forEach(row => {
            const userName = row.querySelector('td.text-gray-900').textContent.toLowerCase();
            row.style.display = userName.includes(searchValue) ? '' : 'none';
        });
    });

    function openModal(userId) {
        console.log('Opening modal for user ID:', userId); // Log userId
        fetch(`/consommation/${userId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data); // Log the fetched data
                const modalBody = document.getElementById('modalTableBody');
                modalBody.innerHTML = ''; // Clear previous content
                data.consumptions.forEach(consumption => {
                    modalBody.innerHTML += `
                    <tr>
                        <td>${consumption.consumption_date}</td>
                        <td>${consumption.energy_value}</td>
                        <td>${consumption.energy_type}</td>
                        <td>${consumption.carbonFootprint ? consumption.carbonFootprint.carbon_emission : 'N/A'}</td>
                    </tr>
                    `;
                });

                document.getElementById('consumptionModal').style.display = 'block';
                document.getElementById('modalOverlay').style.display = 'block';
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    }

    function closeModal() {
        document.getElementById('consumptionModal').style.display = 'none';
        document.getElementById('modalOverlay').style.display = 'none';
    }

    // Pagination function
    const itemsPerPage = 5; // Number of items to display per page
    const tableBody = document.querySelector('#consumptionTable tbody');
    const paginationControls = document.getElementById('paginationControls');

    function paginateTable() {
        const rows = Array.from(tableBody.querySelectorAll('tr'));
        const pageCount = Math.ceil(rows.length / itemsPerPage);
        let currentPage = 1;

        function displayPage(page) {
            rows.forEach((row, index) => {
                row.style.display = (Math.floor(index / itemsPerPage) === page - 1) ? '' : 'none';
            });
            updatePaginationButtons(page, pageCount);
        }

        function updatePaginationButtons(page, totalPages) {
            paginationControls.innerHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                const button = document.createElement('button');
                button.textContent = i;
                button.className = 'btn btn-light';
                button.style.margin = '0 5px';
                button.onclick = () => displayPage(i);
                if (i === page) button.disabled = true;
                paginationControls.appendChild(button);
            }
        }

        displayPage(currentPage);
    }

    paginateTable(); // Initial call to paginate the table

    document.getElementById('downloadPdfBtn').addEventListener('click', function () {
    const { jsPDF } = window.jspdf; // Ensure jsPDF is accessed
    const { autoTable } = window.jspdf; // Ensure autoTable is correctly accessed

    const doc = new jsPDF();
    const table = document.getElementById('consumptionTable');
    const rows = table.rows;

    let pdfTableData = [];
    for (let i = 0; i < rows.length; i++) {
        let rowData = [];
        for (let j = 0; j < rows[i].cells.length; j++) {
            rowData.push(rows[i].cells[j].innerText);
        }
        pdfTableData.push(rowData);
    }

    // Use autoTable here
    if (autoTable) {
        autoTable(doc, {
            head: [pdfTableData[0]], // Header
            body: pdfTableData.slice(1), // Body
        });

        // Save the PDF
        doc.save('consumption_report.pdf');
    } else {
        console.error("autoTable is not a function. Please check the jsPDF-AutoTable library.");
    }
});



</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.11/jspdf.plugin.autotable.min.js"></script>


<style>
    /* Table Styles */
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .custom-table th,
    .custom-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
        
    }

    .custom-table th {
        background-color: #64d4bb;
        color: white;
    }

    .custom-table tr:hover {
        background-color: #f1f1f1;
    }

    .text-gray {
        color: #6c757d;
    }

    /* Modal Styles */
    .modal-overlay {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .close {
        cursor: pointer;
        font-size: 24px;
        color: #999;
    }

    .close:hover {
        color: #e5d982;
    }
</style>
@endsection
