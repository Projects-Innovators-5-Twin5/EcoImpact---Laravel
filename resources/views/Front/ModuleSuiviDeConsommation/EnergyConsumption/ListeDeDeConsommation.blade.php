@extends('front.layout')

@section('content')
<title>EcoImpact - Landing page</title>
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container">
    <!-- Ajouter le contenu du container si nécessaire -->
</div>

<div class="aboutus bg-white shadow">
    <div class="about-contact">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <h3>La consommation énergétique</h3>
            <p class="mt-4">
                La consommation énergétique est un enjeu majeur dans la gestion durable de nos ressources. Nous proposons ici un suivi détaillé de votre consommation afin de vous aider à mieux comprendre et optimiser vos usages énergétiques au quotidien.
            </p>

            <div class="buttons" style="display: flex; gap: 10px; margin-top: 20px;">
                <button onclick="openModal()" class="btn btn-success">Ajouter une consommation d'énergie</button>
                <button onclick="window.location.href='/carbon-footprints'" class="btn btn-secondary">Émissions de carbone</button>
            </div>
        </div>

        <!-- Modal for energy consumption -->
        <div id="consommationModal" class="modal" style="display:none;">
            <span onclick="closeModal()" class="close-btn">&times;</span>
            <div class="modal-content">
                <h3>Ajouter une consommation d'énergie</h3>
                <form id="energyConsumptionForm" method="POST" action="{{ route('energy.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="energyType">Type d'énergie:</label>
                        <select id="energyType" name="energy_type" required>
                            <option value="Charbon">Charbon</option>
                            <option value="Pétrole">Pétrole</option>
                            <option value="Gaz Naturel">Gaz Naturel</option>
                            <option value="Solaire">Solaire</option>
                            <option value="Éolien">Éolien</option>
                            <option value="Hydroélectrique">Hydroélectrique</option>
                            <option value="Nucléaire">Nucléaire</option>
                            <option value="Biomasse">Biomasse</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="energyValue">Consommation (kWh):</label>
                        <input type="number" id="energyValue" name="energy_value" required>
                    </div>
                    <div class="form-group">
                        <label for="consumptionDate">Date de consommation:</label>
                        <input type="date" id="consumptionDate" name="consumption_date" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>

                <div id="carbonFootprintResult" style="margin-top: 20px;"></div>
            </div>
        </div>

        <div id="modalOverlay" class="overlay" style="display:none;"></div>

        <img src="/assets/img/ImagesModule1/lame.gif" alt="Consommation d'énergie" class="img-responsive" style="margin-top: 20px;">
    </div>
</div>

<div class="services card shadow">
    <h3 class="text-center">Historique de Consommation d'Énergie</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Type d'énergie</th>
                <th>Consommation (kWh)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($energyConsumptions as $consumption)
                <tr>
                    <td>{{ $consumption['consumptionDate'] }}</td>
                    <td>{{ ucfirst($consumption['energyType']) }}</td>
                    <td>{{ $consumption['energyValue'] }} kWh</td>
                    <td>
                    <button onclick="openEditModal('{{ $consumption['id'] }}', '{{ $consumption['energyType'] }}', {{ $consumption['energyValue'] }}, '{{ $consumption['consumptionDate'] }}')" class="btn btn-warning btn-icon">
    <i class="fas fa-pencil-alt"></i>
</button>

                        <form action="{{ route('consumptions.delete', ['id' => $consumption['id']]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette consommation ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-icon" ><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Modal for editing energy consumption -->
<div id="editConsommationModal" class="modal" style="display:none;">
    <span onclick="closeEditModal()" class="close-btn">&times;</span>
    <div class="modal-content">
        <h3>Modifier la consommation d'énergie</h3>
        <form id="editEnergyConsumptionForm" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="editEnergyType">Type d'énergie:</label>
        <select id="editEnergyType" name="energy_type" required>
            <option value="Charbon">Charbon</option>
            <option value="Pétrole">Pétrole</option>
            <option value="Gaz Naturel">Gaz Naturel</option>
            <option value="Solaire">Solaire</option>
            <option value="Éolien">Éolien</option>
            <option value="Hydroélectrique">Hydroélectrique</option>
            <option value="Nucléaire">Nucléaire</option>
            <option value="Biomasse">Biomasse</option>
        </select>
    </div>
    <div class="form-group">
        <label for="editEnergyValue">Consommation (kWh):</label>
        <input type="number" id="editEnergyValue" name="energy_value" required>
    </div>
    <div class="form-group">
        <label for="editConsumptionDate">Date de consommation:</label>
        <input type="date" id="editConsumptionDate" name="consumption_date" required>
    </div>
    <button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>

    </div>
</div>

<div class="contactus bg-white shadow-top card">
    <div class="content-contact d-flex flex-wrap justify-content-between">
        <div class="col-lg-6 mb-4">
            <h3>Analyse de la consommation énergétique</h3>
            <p class="mt-4">
                @if(isset($consumptionValues) && count($consumptionValues) > 0)
                    @php
                        $averageConsumption = array_sum($consumptionValues) / count($consumptionValues);
                        $maxConsumption = max($consumptionValues);
                        $minConsumption = min($consumptionValues);
                    @endphp
                    Votre consommation énergétique moyenne est de <strong>{{ number_format($averageConsumption, 2) }} kWh</strong>. Le pic de consommation a été observé à <strong>{{ $maxConsumption }} kWh</strong>, tandis que le minimum est de <strong>{{ $minConsumption }} kWh</strong>.
                    @if ($averageConsumption > 100)
                        Cela indique un usage intensif, suggérant qu'une optimisation de vos appareils serait bénéfique.
                    @else
                        Votre consommation semble raisonnable.
                    @endif
                    @if ($maxConsumption > 150)
                        Attention, le pic de consommation de {{ $maxConsumption }} kWh pourrait indiquer une utilisation exceptionnelle.
                    @endif
                @else
                    Aucune donnée de consommation disponible pour le moment.
                @endif
            </p>

            <div class="energy-buttons mt-4">
                <button onclick="updateChart('Électricité')" class="btn btn-electricity">Électricité</button>
                <button onclick="updateChart('Gaz')" class="btn btn-gas">Gaz</button>
                <button onclick="updateChart('Eau')" class="btn btn-water">Eau</button>
                <button onclick="updateChart('Vent')" class="btn btn-wind">Vent</button>
            </div>
        </div>

        <div class="col-lg-6 d-flex justify-content-center align-items-center">
            <div class="chart-container">
                <canvas id="consumptionChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="contactus bg-white shadow-top card">
    <div class="content-contact d-flex flex-wrap justify-content-between">
        <div class="col-lg-6 mb-4">
            <h3>Consommation moyenne des ressources énergétiques</h3>
        </div>
        <div class="col-lg-6 d-flex justify-content-center align-items-center">
            <img src="/assets/img/ImagesModule1/ressource.png" alt="Consommation d'énergie" class="img-fluid" style="width: 400px;">
        </div>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('consommationModal').style.display = 'block';
    document.getElementById('modalOverlay').style.display = 'block'; // Afficher l'overlay
}

function closeModal() {
    document.getElementById('consommationModal').style.display = 'none';
    document.getElementById('modalOverlay').style.display = 'none'; // Masquer l'overlay
}
</script>

<script>
const emissionFactors = {
    "Charbon": 0.9,
    "Pétrole": 0.7,
    "Gaz Naturel": 0.4,
    "Solaire": 0.035,
    "Éolien": 0.015,
    "Hydroélectrique": 0.040,
    "Nucléaire": 0.015,
    "Biomasse": 0.160
};

document.getElementById('energyConsumptionForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(this); // Récupérer les données du formulaire
    const data = {
        energyType: formData.get('energy_type'),
        energyValue: formData.get('energy_value'),
        consumptionDate: formData.get('consumption_date')
    };

    fetch(this.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data) // Convertir les données en JSON
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            document.getElementById('carbonFootprintResult').innerText = `Émissions de carbone calculées: ${result.carbonFootprint} kg CO2`;
            closeModal();
            location.reload(); // Recharger la page pour mettre à jour la liste
        } else {
            document.getElementById('carbonFootprintResult').innerText = `Erreur: ${result.message}`;
        }
    })
    .catch(error => {
        document.getElementById('carbonFootprintResult').innerText = 'Erreur lors de l\'ajout: ' + error.message;
    });
});

function openEditModal(id, energyType, energyValue, consumptionDate) {
    // Mettre à jour l'action du formulaire avec l'ID
    document.getElementById('editEnergyConsumptionForm').action = `/consumptions/${id}`;

    // Remplir les champs du formulaire avec les données fournies
    document.getElementById('editEnergyType').value = energyType;
    document.getElementById('editEnergyValue').value = energyValue;
    document.getElementById('editConsumptionDate').value = consumptionDate;

    // Afficher le modal d'édition
    document.getElementById('editConsommationModal').style.display = 'block';
}

function closeEditModal() {
    // Masquer le modal d'édition
    document.getElementById('editConsommationModal').style.display = 'none';
}



</script>

@endsection
