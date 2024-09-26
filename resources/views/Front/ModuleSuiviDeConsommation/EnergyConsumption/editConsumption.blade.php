@extends('front.layout')

@section('content')
<title>Modifier la Consommation Énergétique</title>
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container">

    <div class="aboutus bg-white shadow p-4 rounded">
        <div class="about-contact">
            <div class="col-sm-12 col-md-8 mx-auto">
                <h2 class="text-center mb-4">Modifier la Consommation Énergétique</h2>

                <form action="{{ route('consumptions.update', ['id' => $consumption->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="energy_type">Type d'énergie:</label>
                        <select name="energy_type" id="energy_type" class="form-control" required>
                            <option value="electricity" {{ $consumption->energy_type == 'electricity' ? 'selected' : '' }}>Électricité</option>
                            <option value="gas" {{ $consumption->energy_type == 'gas' ? 'selected' : '' }}>Gaz</option>
                            <option value="water" {{ $consumption->energy_type == 'water' ? 'selected' : '' }}>Eau</option>
                            <option value="wind" {{ $consumption->energy_type == 'wind' ? 'selected' : '' }}>Éolienne</option>
                            <!-- Ajoutez d'autres types d'énergie si nécessaire -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="energy_value">Consommation (kWh):</label>
                        <input type="number" name="energy_value" id="energy_value" class="form-control" value="{{ $consumption->energy_value }}" required>
                    </div>

                    <div class="form-group">
                        <label for="consumption_date">Date de consommation:</label>
                        <input type="date" name="consumption_date" id="consumption_date" class="form-control" value="{{ $consumption->consumption_date }}" required>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary" style="background-color: #82caef; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                            Mettre à jour
                        </button>
                        <a href="/liste-consommations" class="btn btn-link" style="margin-left: 10px;">Retour à l'historique</a>
                    </div>
                </form>
            </div>

            <div class="text-center mt-4">
                <img src="/assets/img/ImagesModule1/robinet.gif" alt="Consommation d'énergie" style="width: 250px; height: 250px;">
            </div>
        </div>
    </div>

</div>

@endsection
