@extends('back.layout')

@section('content')
    <div class="py-4">
        <h1 class="h4">Créer une Nouvelle Catégorie</h1>
        <p class="mb-0">Remplissez les détails ci-dessous pour créer une nouvelle catégorie.</p>
    </div>
    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row">
                    <div class=" mb-3">
                        <label for="nom" class="form-label">Nom de la Catégorie</label>
                        <input type="text" name="nom" id="nom" class="form-control" placeholder="Entrez le nom de la catégorie" required minlength="3" maxlength="100" value="{{ old('nom') }}">
                        <div class="invalid-feedback">
                            Veuillez fournir un nom valide (3-100 caractères).
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description de la Catégorie</label>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Décrivez la catégorie..." required minlength="10" maxlength="500">{{ old('description') }}</textarea>
                    <div class="invalid-feedback">
                        Veuillez fournir une description (10-500 caractères).
                    </div>
                </div>

                <!-- Section pour affecter des produits -->
                <div class="mb-3">
                    <label for="produits" class="form-label">Affecter des Produits</label>
                    <select name="produits[]" id="produits" class="form-control" multiple>
                        @foreach ($produits as $produit)
                            <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Vous pouvez sélectionner plusieurs produits (optionnel).</small>
                </div>

                <button type="submit" class="btn btn-primary">Créer Catégorie</button>
            </div>
        </div>
    </form>
@endsection
