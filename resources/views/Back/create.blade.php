@extends('back.layout')

@section('content')
    <div class="py-4">
        <h1 class="h4">Créer un Nouveau Produit</h1>
        <p class="mb-0">Remplissez les détails ci-dessous pour créer un nouveau produit.</p>
    </div>
    <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" id="nom" class="form-control" placeholder="Entrez le nom du produit" required minlength="3" maxlength="100">
                        <div class="invalid-feedback">
                            Veuillez fournir un nom valide (3-100 caractères).
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="prix" class="form-label">Prix</label>
                        <input type="number" name="prix" id="prix" class="form-control" placeholder="Entrez le prix" required min="0.01" step="0.01">
                        <div class="invalid-feedback">
                            Veuillez entrer un prix valide.
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Décrivez le produit..." required minlength="10" maxlength="500"></textarea>
                    <div class="invalid-feedback">
                        Veuillez fournir une description (10-500 caractères).
                    </div>
                </div>
                <div class="mb-3">
                    <label for="quantite" class="form-label">Quantité</label>
                    <input type="number" name="quantite" id="quantite" class="form-control" required min="1">
                    <div class="invalid-feedback">
                        Veuillez entrer une quantité valide.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image du Produit</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    <div class="invalid-feedback">
                        Veuillez télécharger une image.
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Créer Produit</button>
            </div>
        </div>
    </form>
@endsection
