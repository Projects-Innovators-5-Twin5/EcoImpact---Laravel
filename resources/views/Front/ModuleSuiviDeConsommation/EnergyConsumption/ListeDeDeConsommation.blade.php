@extends('front.layout')

@section('content')
<title>EcoImpact - Landing page</title>
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container">
    <!-- Container content can be added here if needed -->
</div>

<div class="aboutus bg-white shadow">
    <div class="about-contact">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <h3>La consommation énergétique</h3>
            <p class="mt-4"> La consommation énergétique est un enjeu majeur dans la gestion durable de nos ressources.
                Nous proposons ici un suivi détaillé de votre consommation afin de vous aider à mieux comprendre et optimiser vos usages énergétiques au quotidien.
            </p>

            <!-- Bouton vert -->
            <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                <button onclick="openModal()" style="background-color: #82caef; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px;">
                    Ajouter une consommation
                </button>
                <button onclick="window.location.href='/carbon-footprints'" style="background-color: #64d4bb; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                    émissions de carbone
                </button>

            </div>

        </div>

        <div id="consommationModal" style="display:none; position:fixed; top:55%; left:50%; transform:translate(-50%, -50%); width:80%; height:80%; background-color:white; box-shadow:0 5px 15px rgba(0,0,0,0.3); z-index:1000; padding:20px; border-radius:10px;">
            <span onclick="closeModal()" style="cursor:pointer; font-size:20px; float:right;">&times;</span>
            <iframe src="/Consommation" style="width:100%; height:499px; border:none;"></iframe>
        </div>

        <!-- Overlay pour l'arrière-plan -->
        <div id="modalOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:999;"></div>

        <img src="/assets/img/ImagesModule1/lame.gif" alt="Consommation d'énergie" style="width: 250px; height:250px; margin-top: 20px;">
    </div>
</div>

<div class="services" style="margin: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
    <h3 style="text-align: center; color: #333; margin-bottom: 20px;">Historique de Consommation d'Énergie</h3>
    <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
        <thead>
            <tr>
                <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd; background-color: #4CAF50; color: white;">Date</th>
                <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd; background-color: #4CAF50; color: white;">Type d'énergie</th>
                <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd; background-color: #f1b77b; color: white;">Consommation (kWh)</th>
                <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd; background-color: #f1b77b; color: white;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userConsumptions as $consumption)
            <tr>
                <td style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">{{ $consumption->consumption_date }}</td>
                <td style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">{{ ucfirst($consumption->energy_type) }}</td>
                <td style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">{{ $consumption->energy_value }} kWh</td>
                <td style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">
                    <!-- Icon for Edit -->
                    <a href="{{ route('editConsumption', ['id' => $consumption->id]) }}" style="color: blue; margin-right: 10px;">
                        <i class="fas fa-pen"></i>
                    </a>

                    <!-- Form for Delete -->
                    <form action="{{ route('consumptions.delete', ['id' => $consumption->id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette consommation ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color: red; background: none; border: none; cursor: pointer;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination" style="text-align: center; margin-top: 20px;">
        {{ $userConsumptions->links() }}
    </div>
</div>


<div class="contactus bg-white shadow-top" style="padding: 40px; border-radius: 8px; margin: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
    <div class="content-contact" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
        <div class="col-sm-12 col-md-6 col-lg-6" style="padding: 20px;">
            <h3 style="font-size: 28px; color: #333; margin-bottom: 10px;">Analyse de la consommation énergétique</h3>
            <p class="mt-4" style="font-size: 16px; color: #555;">
                <?php
                if (count($consumptionValues) > 0) {
                    $averageConsumption = array_sum($consumptionValues) / count($consumptionValues);
                    $maxConsumption = max($consumptionValues);
                    $minConsumption = min($consumptionValues);

                    echo "Votre consommation énergétique moyenne est de <strong>" . number_format($averageConsumption, 2) . " kWh</strong>.<br>";
                    echo "Le pic de consommation a été observé à <strong>" . $maxConsumption . " kWh</strong>, tandis que le minimum enregistré est de <strong>" . $minConsumption . " kWh</strong>.<br>";

                    if ($averageConsumption > 100) {
                        echo "Cela indique un usage intensif, suggérant qu'une optimisation de vos appareils serait bénéfique.";
                    } else {
                        echo "Votre consommation semble raisonnable.";
                    }

                    if ($maxConsumption > 150) {
                        echo " Attention, le pic de consommation de " . $maxConsumption . " kWh pourrait indiquer une utilisation exceptionnelle.";
                    }
                } else {
                    echo "Aucune donnée de consommation disponible pour le moment.";
                }
                ?>
            </p>

            <!-- Energy type buttons -->
            <div class="energy-buttons" style="margin-top: 20px;">
                <button onclick="updateChart('Électricité')" style="padding: 10px 15px; font-size: 16px; margin-right: 10px; background-color: #d4c164; color: white; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">
                    Électricité
                </button>
                <button onclick="updateChart('gas')" style="padding: 10px 15px; font-size: 16px; margin-right: 10px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">
                    Gaz
                </button>
                <button onclick="updateChart('Eau')" style="padding: 10px 15px; font-size: 16px; background-color: #82caef; color: white; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">
                    Eau
                </button>
                <button onclick="updateChart('wind')" style="padding: 10px 15px; font-size: 16px; background-color: #64d4bb; color: white; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">
                    wint
                </button>
            </div>

        </div>

        <div class="col-sm-12 col-md-12 col-lg-6" style="padding: 20px;">
            <div class="chart-row" style="display: flex; flex-direction: column; gap: 10px;">
                <div class="chart-container" style="flex: 1; background-color: #ffffff; border-radius: 8px; padding: 20px;">
                    <canvas id="consumptionChart" style="max-height: 300px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Nouvelle section pour la consommation des ressources -->
<div class="contactus bg-white shadow-top" style="padding: 40px; border-radius: 8px; margin: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
    <div class="content-contact" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
        <div class="col-sm-12 col-md-6 col-lg-6" style="padding: 20px;">
            <h3 style="font-size: 28px; color: #333; margin-bottom: 10px;">Consommation moyenne des ressources énergétiques</h3>
            <p class="mt-4" style="font-size: 16px; color: #555;">
                <strong>Pour atteindre vos objectifs de consommation :</strong><br>
                <?php
                // Exemple de logique pour une analyse dynamique
                $resources = [
                    'Électricité' => 100,
                    'Gaz' => 75,
                    'Solaire' => 50,
                    'Éolienne' => 40,
                    'Biomasse' => 30,
                    'Géothermique' => 20,
                    'Charbon' => 10,
                    'Pétrole' => 5,
                    'Nucléaire' => 90,
                ];
                foreach ($resources as $resource => $consumption) {
                    echo "$resource : <strong>" . $consumption . " kWh</strong><br>";
                }
                ?>
            </p>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-6" style="padding: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="chart-row" style="display: flex; flex-direction: column; gap: 10px;">
                <img src="/assets/img/ImagesModule1/ressource.png" alt="Consommation d'énergie" style="width: 400px; height: auto;">
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Assuming these variables are defined in the view with the passed data from the controller
    const defaultEnergyType = 'global'; // Set this to the default type
    const initialLabels = @json($globalConsumptionDates); // From the controller
    const initialValues = @json($globalConsumptionValues); // From the controller

    // Create the initial chart with the default data
    const ctx = document.getElementById('consumptionChart').getContext('2d');
    let myChart;

    function createChart(data) {
        if (myChart) {
            myChart.destroy(); // Destroy the previous chart instance
        }

        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Consommation (kWh)',
                    data: data.values,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function updateChart(energyType) {
        fetch(`/consumption-data?energy_type=${energyType}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                createChart(data);
            })
            .catch(error => {
                console.error('Error fetching consumption data:', error);
                // Handle the error appropriately
                createChart({
                    labels: [],
                    values: []
                }); // Clear the chart on error
            });
    }

    // Initialize the chart with the total energy consumption data
    createChart({
        labels: initialLabels,
        values: initialValues
    });

    // Optionally, set up event listeners for your buttons to update the chart
    document.querySelectorAll('.energy-type-button').forEach(button => {
        button.addEventListener('click', () => {
            const energyType = button.getAttribute('data-energy-type');
            updateChart(energyType);
        });
    });

    function openModal() {
        document.getElementById('consommationModal').style.display = 'block';
        document.getElementById('modalOverlay').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('consommationModal').style.display = 'none';
        document.getElementById('modalOverlay').style.display = 'none';
    }

    function openEditModal(url) {
        document.getElementById('editConsumptionFrame').src = url; // Set the src of the iframe to the edit page URL
        document.getElementById('editConsumptionModal').style.display = 'block'; // Show the modal
        document.getElementById('modalOverlay').style.display = 'block'; // Show the overlay
    }

    function closeEditModal() {
        document.getElementById('editConsumptionModal').style.display = 'none';
        document.getElementById('modalOverlay').style.display = 'none';
        document.getElementById('editConsumptionFrame').src = ''; // Clear the iframe src
    }
</script>
<script>
    window.addEventListener('scroll', function() {
        var navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>

@endsection