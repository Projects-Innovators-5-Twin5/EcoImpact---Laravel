@extends('back.layout')

@section('content')
<div class="container mt-4">
   
    <div class="card shadow-sm">
        
        <div class="card-body">
        <h3 class="mb-4 text-center" style="font-size: 1.5rem; font-weight: bold; color: #343a40; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 30px;">
    Détails de la consommation énergétique
</h3>

            <div class="table-responsive">
                <table class="custom-table align-items-center table-flush">
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
                                <button onclick="openModal({{ $user->id }})" class="btn btn-primary" style=" color:#343a40; padding: 10px 20px; border-radius: 5px; cursor: pointer; background-color:#e5d982">
                                    Voir les consommations
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
    function openModal(userId) {
        fetch(`/consommation/${userId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
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
</script>

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
