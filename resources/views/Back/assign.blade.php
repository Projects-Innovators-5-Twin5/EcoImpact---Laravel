@extends('back.layout')

@section('content')
<title>EcoImpact - Affecter Produits à {{ $categorie->nom }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Breadcrumb navigation -->
<div class="d-block mb-4 mb-md-0 mt-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="#">EcoImpact</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Liste des Catégories</a></li>
            <li class="breadcrumb-item active" aria-current="page">Affecter Produits à {{ $categorie->nom }}</li>
        </ol>
    </nav>
    <h2 class="h4">Affecter Produits à {{ $categorie->nom }}</h2>
</div>

<br>

<!-- Form for assigning products -->
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('categories.storeAssignedProducts', $categorie->id) }}" method="POST">
            @csrf
            <h4>Produits non affectés</h4>
            <select name="produits[]" class="form-control" multiple>
                @foreach ($produits as $produit)
                    <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                @endforeach
            </select>
            <br>
            <button type="submit" class="btn btn-primary">Affecter</button>
        </form>

        <h4 class="mt-4">Produits déjà affectés</h4>
        <ul class="list-group">
            @foreach ($assignedProducts as $assignedProduct)
                <li class="list-group-item">
                    {{ $assignedProduct->nom }}
                    <form action="{{ route('categories.removeAssignedProduct', [$categorie->id, $assignedProduct->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm float-end">Retirer</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
