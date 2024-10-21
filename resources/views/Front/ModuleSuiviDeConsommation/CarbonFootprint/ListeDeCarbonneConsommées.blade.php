@extends('front.layout')

@section('content')
<title>EcoImpact - Analyse de la consommation énergétique</title>
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
<div class="aboutus bg-white shadow ">
    <div class="about-contact ">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <h3>La consommation énergétique</h3>
            <p style="font-size: 16px; margin-top: 20px; color: #28a745;">
    <strong>Suggestions pour réduire vos émissions :</strong>
</p>
<ul style="margin-left: 25px; color: #28a745; font-size: 15px;">
    <li>Adoptez les énergies renouvelables telles que le <strong>solaire</strong> ou l'<strong>éolienne</strong> pour remplacer les combustibles fossiles.</li>
    <li>Réduisez votre consommation d'<strong>électricité</strong> en optant pour des appareils plus économes en énergie.</li>
    <li>Réduisez la consommation de <strong>charbon</strong> et de <strong>pétrole</strong> en modernisant vos équipements.</li>
    <li>Investissez dans des technologies <strong>propres</strong> pour des solutions durables à long terme.</li>
</ul>



            <!-- Bouton vert -->
        </div>

        <div id="consommationModal" style="display:none; position:fixed; top:55%; left:50%; transform:translate(-50%, -50%); width:80%; height:80%; background-color:white; box-shadow:0 5px 15px rgba(0,0,0,0.3); z-index:1000; padding:20px; border-radius:10px;">
            <span onclick="closeModal()" style="cursor:pointer; font-size:20px; float:right;">&times;</span>
            <iframe src="/Consommation" style="width:100%; height:499px; border:none;"></iframe>
        </div>

        <!-- Overlay pour l'arrière-plan -->
        <div id="modalOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:999;"></div>

        <img src="/assets/img/ImagesModule1/robinet.gif" alt="Consommation d'énergie" style="width: 250px; height:250px; margin-top: 20px;">
    </div>
</div>




<div class="container">
    <!-- Contenu du container si nécessaire -->
</div>

<div class="contactus bg-white shadow-top" style="padding: 40px; border-radius: 8px; margin: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
    <div class="content-contact" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
        <div class="col-sm-12 col-md-6 col-lg-6" style="padding: 20px;">
           

            <p class="mt-4" style="font-size: 16px; color: #555;">
             

<strong style="font-size: 18px; color: #333;">Analyse détaillée de vos émissions de carbone :</strong><br>
<p style="font-size: 16px; color: #555; margin-top: 10px;">
    L'émission totale de carbone enregistrée est de <strong style="color: #d9534f;">{{ $totalEmission}} kg CO2</strong>. Les contributions par source d'énergie sont les suivantes :
</p>


<ul style="margin-top: 15px; list-style-type: disc; padding-left: 20px; color: #666; font-size: 16px;">
    <li><strong>Électricité :</strong> {{ $electricityCarbonEmission }} kg CO2</li>
    <li><strong>Gaz :</strong> {{ $gasCarbonEmission }} kg CO2</li>
    <li><strong>Solaire :</strong> {{ $solarCarbonEmission }} kg CO2 (aucune émission directe)</li>
    <li><strong>Éolienne :</strong> {{ $windCarbonEmission }} kg CO2 (aucune émission directe)</li>
    <li><strong>Biomasse :</strong> {{ $biomassCarbonEmission }} kg CO2</li>
    <li><strong>Géothermique :</strong> {{ $geothermalCarbonEmission }} kg CO2</li>
    <li><strong>Charbon :</strong> {{ $coalCarbonEmission }} kg CO2</li>
    <li><strong>Pétrole :</strong> {{ $oilCarbonEmission }} kg CO2</li>
    <li><strong>Nucléaire :</strong> {{ $nuclearCarbonEmission }} kg CO2</li>
    <li><strong>Diesel :</strong> {{ $dieselCarbonEmission }} kg CO2</li>
</ul>







            <!-- Boutons de types d'énergie -->
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




















<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const data = {
    labels: ['Électricité', 'Gaz', 'Solaire', 'Éolienne', 'Biomasse', 'Géothermique', 'Charbon', 'Pétrole', 'Nucléaire', 'Diesel'],
    datasets: [{
        label: 'Émissions de carbone (kg CO2)',
        data: [
            {{ $electricityCarbonEmission }},
            {{ $gasCarbonEmission }},
            {{ $solarCarbonEmission }},
            {{ $windCarbonEmission }},
            {{ $biomassCarbonEmission }},
            {{ $geothermalCarbonEmission }},
            {{ $coalCarbonEmission }},
            {{ $oilCarbonEmission }},
            {{ $nuclearCarbonEmission }},
            {{ $dieselCarbonEmission }}
        ],
        backgroundColor: [
            'rgba(255, 99, 132, 0.2)',  // Électricité
            'rgba(54, 162, 235, 0.2)',  // Gaz
            'rgba(255, 206, 86, 0.2)',  // Solaire
            'rgba(75, 192, 192, 0.2)',  // Éolienne
            'rgba(153, 102, 255, 0.2)', // Biomasse
            'rgba(255, 159, 64, 0.2)',  // Géothermique
            'rgba(255, 99, 71, 0.2)',   // Charbon
            'rgba(139, 69, 19, 0.2)',   // Pétrole
            'rgba(123, 104, 238, 0.2)', // Nucléaire
            'rgba(47, 79, 79, 0.2)'     // Diesel
        ],
        borderColor: [
            'rgba(255, 99, 132, 1)',  // Électricité
            'rgba(54, 162, 235, 1)',  // Gaz
            'rgba(255, 206, 86, 1)',  // Solaire
            'rgba(75, 192, 192, 1)',  // Éolienne
            'rgba(153, 102, 255, 1)', // Biomasse
            'rgba(255, 159, 64, 1)',  // Géothermique
            'rgba(255, 99, 71, 1)',   // Charbon
            'rgba(139, 69, 19, 1)',   // Pétrole
            'rgba(123, 104, 238, 1)', // Nucléaire
            'rgba(47, 79, 79, 1)'     // Diesel
        ],
        borderWidth: 1
    }]
};

const ctx = document.getElementById('consumptionChart').getContext('2d');
let myChart = new Chart(ctx, {
    type: 'bar',  // Passer à un diagramme en barres
    data: data,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
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
