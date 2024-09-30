@extends('back.layout')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Modifier les consommations de {{ $user->name }}</h1>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('consumptionsback.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nom de l'utilisateur</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <h3>Consommations</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Type d'énergie</th>
                            <th>Valeur de consommation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consumptions as $consumption)
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="consumptions[{{ $loop->index }}][type]" value="{{ $consumption->energy_type }}" readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="consumptions[{{ $loop->index }}][energy_value]" value="{{ old('consumptions.' . $loop->index . '.energy_value', $consumption->energy_value) }}" required>
                                </td>
                                <td>
                                    <input type="hidden" name="consumptions[{{ $loop->index }}][id]" value="{{ $consumption->id }}">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Supprimer</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="button" class="btn btn-secondary mb-2" onclick="addRow()">Ajouter une consommation</button>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>

<script>
    function addRow() {
        const tbody = document.querySelector('table tbody');
        const rowCount = tbody.rows.length;
        const newRow = `
            <tr>
                <td><input type="text" class="form-control" name="consumptions[${rowCount}][type]" required></td>
                <td><input type="number" class="form-control" name="consumptions[${rowCount}][energy_value]" required></td>
                <td>
                    <input type="hidden" name="consumptions[${rowCount}][id]" value="">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Supprimer</button>
                </td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', newRow);
    }

    function removeRow(button) {
        const row = button.closest('tr');
        row.parentNode.removeChild(row);
    }
</script>
@endsection
