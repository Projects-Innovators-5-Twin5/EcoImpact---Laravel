@extends('back.layout')

@section('title', 'Créer un Article')
<link rel="stylesheet" href="{{ asset('css/articles_commentaires.css') }}">

@section('content')
    <div class="bg-white py-2 card">
        <div class="card-header">
            Créer un Article
        </div>
        <div class="container card-body py-2">
            <form action="{{ route('back.articles.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="titre">Titre</label>
                        <input type="text" name="title" id="titre" class="form-control" value="{{ old('title') }}">
                        @if ($errors->has('title'))
                            <div class="text-danger">{{ $errors->first('title') }}</div>
                        @endif
                    </div>
        
                    <div class="form-group col-md-6">
                        <label for="content">content</label>
                        <textarea name="content" id="content" class="form-control">{{ old('content') }}</textarea>
                        @if ($errors->has('content'))
                            <div class="text-danger">{{ $errors->first('content') }}</div>
                        @endif
                    </div>
                </div>
        
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="image">Image</label>
                        <input type='file' name="image" id="image" class="form-control" value="{{ old('image') }}">
                        @if ($errors->has('image'))
                            <div class="text-danger">{{ $errors->first('image') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        <label for="categories">categories</label>
                        <select name="categories" id="categories" class="form-control">
                            <option value="solutions-ecologiques">Solutions Écologiques</option>
                            <option value="energie-solaire">Énergie Solaire</option>
                            <option value="energie-eolienne">Énergie Éolienne</option>
                            <option value="transition-energetique">Transition Énergétique</option>
                            <option value="conseils-economie-energie">Conseils d’Économie d’Énergie</option>
                            <option value="technologies-vertes">Technologies Vertes</option>
                            <option value="politiques-reglementations">Politiques et Réglementations</option>
                            <option value="stockage-energie">Stockage de l’Énergie</option>
                            <option value="projets-innovations">Projets et Innovations</option>
                            <option value="chauffage-climatisation-eco">Chauffage et Climatisation Éco-responsables</option>
                            <option value="batiments-energies-renouvelables">Bâtiments et Énergies Renouvelables</option>
                            <option value="mobilite-verte">Mobilité Verte</option>
                            <option value="impact-environnemental">Impact Environnemental</option>
                            <option value="financement-subventions">Financement et Subventions</option>
                        </select>
                        @if ($errors->has('categories'))
                            <div class="text-danger">{{ $errors->first('categories') }}</div>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-end mx-4 my-2">
                    <button type="submit" class="btn btn-primary">Ajouter l'Article</button>
                </div>
            </form>
        </div>
    </div>
@endsection
