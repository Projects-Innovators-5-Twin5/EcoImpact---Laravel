@extends('back.layout')

@section('title', 'Modifier Article')
<link rel="stylesheet" href="{{ asset('css/articles_commentaires.css') }}">

@section('content')
    <div class="bg-white py-2 card">
        <div class="card-header">
            Modifier Article
        </div>
        <div class="container card-body py-2">
            <form action="{{ route('back.articles.update', $article['id']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="title">Titre</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $article['title']) }}">
                        @if ($errors->has('title'))
                            <div class="text-danger">{{ $errors->first('title') }}</div>
                        @endif
                    </div>
        
                    <div class="form-group col-md-6">
                        <label for="content">Contenu</label>
                        <textarea name="content" id="content" class="form-control">{{ old('content', $article['content']) }}</textarea>
                        @if ($errors->has('content'))
                            <div class="text-danger">{{ $errors->first('content') }}</div>
                        @endif
                    </div>
                </div>
        
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="image">Image</label>
                        <input type='file' name="image" id="image" class="form-control">
                        @if ($errors->has('image'))
                            <div class="text-danger">{{ $errors->first('image') }}</div>
                        @endif
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="categories">Categories</label>
                        <select name="categories" id="categories" class="form-control">
                            <option value="solutions-ecologiques" {{ old('categories', $article['categories']) == 'solutions-ecologiques' ? 'selected' : '' }}>Solutions Écologiques</option>
                            <option value="energie-solaire" {{ old('categories', $article['categories']) == 'energie-solaire' ? 'selected' : '' }}>Énergie Solaire</option>
                            <option value="energie-eolienne" {{ old('categories', $article['categories']) == 'energie-eolienne' ? 'selected' : '' }}>Énergie Éolienne</option>
                            <option value="transition-energetique" {{ old('categories', $article['categories']) == 'transition-energetique' ? 'selected' : '' }}>Transition Énergétique</option>
                            <option value="conseils-economie-energie" {{ old('categories', $article['categories']) == 'conseils-economie-energie' ? 'selected' : '' }}>Conseils d’Économie d’Énergie</option>
                            <option value="technologies-vertes" {{ old('categories', $article['categories']) == 'technologies-vertes' ? 'selected' : '' }}>Technologies Vertes</option>
                            <option value="politiques-reglementations" {{ old('categories', $article['categories']) == 'politiques-reglementations' ? 'selected' : '' }}>Politiques et Réglementations</option>
                            <option value="stockage-energie" {{ old('categories', $article['categories']) == 'stockage-energie' ? 'selected' : '' }}>Stockage de l’Énergie</option>
                            <option value="projets-innovations" {{ old('categories', $article['categories']) == 'projets-innovations' ? 'selected' : '' }}>Projets et Innovations</option>
                            <option value="chauffage-climatisation-eco" {{ old('categories', $article['categories']) == 'chauffage-climatisation-eco' ? 'selected' : '' }}>Chauffage et Climatisation Éco-responsables</option>
                            <option value="batiments-energies-renouvelables" {{ old('categories', $article['categories']) == 'batiments-energies-renouvelables' ? 'selected' : '' }}>Bâtiments et Énergies Renouvelables</option>
                            <option value="mobilite-verte" {{ old('categories', $article['categories']) == 'mobilite-verte' ? 'selected' : '' }}>Mobilité Verte</option>
                            <option value="impact-environnemental" {{ old('categories', $article['categories']) == 'impact-environnemental' ? 'selected' : '' }}>Impact Environnemental</option>
                            <option value="financement-subventions" {{ old('categories', $article['categories']) == 'financement-subventions' ? 'selected' : '' }}>Financement et Subventions</option>
                        </select>
                        
                        @if ($errors->has('categories'))
                            <div class="text-danger">{{ $errors->first('categories') }}</div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-center">
                        @if (!empty($article['image']))
                            <div class="mt-2">
                                <p>Image actuelle :</p>
                                <img src="{{ asset('storage/' . $article['image']) }}" alt="Image de l'article" class="img-fluid" style="max-width:450px;">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-end mx-4 my-2">
                    <button type="submit" class="btn btn-primary">Mettre à jour l'Article</button>
                </div>
            </form>
        </div>
    </div>
@endsection
