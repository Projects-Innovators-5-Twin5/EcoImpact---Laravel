<title>EcoImpact - Consommation d'énergie</title>

<style>
    body {
        background-color: #f0f4f8;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .contactus {
        display: flex;
        justify-content: space-between;
        align-items: stretch;
        padding: 40px;
        max-width: 1200px;
        margin: auto;
    }

    img {
        flex: 1;
        width: 45%;
        height: auto;
        border-radius: 10px;
    }

    .form-container {
        flex: 2;
        padding: 30px;
    }

    h3 {
        margin-bottom: 20px;
        color: #333;
        text-align: center;
        font-size: 1.8rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        font-weight: bold;
        color: #555;
    }

    .btn-primary {
        background-color: #28a745;
        border-color: #28a745;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        color: white;
        font-weight: bold;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 10px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
    }

    .alert {
        margin-bottom: 1rem;
        text-align: center;
        background-color: #d4edda;
        color: #155724;
        padding: 10px;
        border-radius: 5px;
    }

    @media (max-width: 768px) {
        .contactus {
            flex-direction: column;
            padding: 20px;
        }

        img {
            max-width: 100%;
            margin-bottom: 20px;
        }

        .form-container {
            padding: 20px;
        }
    }
</style>

<div class="contactus">
    <img src="/assets/img/ImagesModule1/eau.jpg" alt="Consommation d'énergie">
    
    <div class="form-container">
        @if (session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h3>Ajouter une Consommation d'Énergie</h3>

        <form action="{{ url('/consommation-energie') }}" method="POST" class="energy-form">
            @csrf

            <div class="form-group mb-3">
                <label class="mb-2">Type d'énergie :</label>
                <div class="d-flex flex-wrap">
                    @foreach(['Électricité' => 'Électricité', 'gas' => 'Gaz', 'Solaire' => 'Solaire', 
                              'Éolienne' => 'Éolienne', 'Biomasse' => 'Biomasse', 'Géothermique' => 'Géothermique', 
                              'Charbon' => 'Charbon', 'Pétrole' => 'Pétrole', 'Nucléaire' => 'Nucléaire', 
                              'Diesel' => 'Diesel'] as $value => $label)
                        <div class="form-check me-3">
                            <input type="radio" id="energy_type_{{ $value }}" name="energy_type" value="{{ $value }}" class="form-check-input" required>
                            <label for="energy_type_{{ $value }}" class="form-check-label">{{ $label }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="energy_value">Valeur de consommation (kWh) :</label>
                <input type="number" name="energy_value" id="energy_value" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="consumption_date">Date de consommation :</label>
                <input type="date" name="consumption_date" id="consumption_date" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary mt-1" style=" width: auto;">Enregistrer</button>


        </form>
    </div>
</div>

<script>
    window.onload = function() {
        var successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 2000);
        }
    };
</script>
