@extends('front.layout')
<link rel="stylesheet" href="{{ asset('css/articles_commentaires.css') }}">

@section('content')
<div class="bg-white p-4">
    <div class="p-4 row">
        <div class="card m-4 shadow-lg col-md-7" style="border:none !important;padding: 0;" >
            <img class="card-img-top"  src="{{ asset('storage/' . $articles[3]->image) }}" alt="{{ $articles[3]->titre }} style="max-height: 300px;">
            
            <div class="card-body">
              <p class="card-text">Energie Renouvelables</p>
              <a class="card-text" style="font-weight: bold; font-size:20px;">{{Str::limit($articles[3]->contenu, 100)}}</a>
            </div>
        </div>
        <div class="col-md-4 mt-4 ml-4 text-black">
            <h4><i class="fas fa-tags text-secondary"></i> Catégories </h4>
            <ul class="category-list">
                <li>
                    <span>Solutions Écologiques</span>
                    <a class="description">Des solutions respectueuses de l'environnement.</a>
                </li>
                <li>
                    <span>Énergie Solaire</span> 
                    <a class="description">Utilisation de l'énergie du soleil pour produire de l'électricité.</a>
                </li>
                <li>
                    <span>Énergie Éolienne</span>
                    <a class="description">Exploitation de l'énergie cinétique du vent.</a>
                </li>
                <li>
                    <a class="description">...</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row p-4">
        @foreach($articles as $index => $article)
        <a href="{{ route('front.articles.show', $article->id) }}" class="card m-2 col-12 col-md-perso smal-card " style="border:none !important;cursor: pointer; text-decoration: none;">
            <img class="card-img-top mt-4 rounded" style="max-height: 200px;" src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->titre }}" class="img-fluid rounded mb-3">
            <div class="card-body" style="padding-left: 0 !important;">
                <p class="card-text">{{$article->titre}}</p>
                <p class="card-text" style="font-weight: bold">{{ Str::limit($article->contenu, 100) }}</p>
            </div>
        </a>
        @endforeach
    </div>
    

    <div class="d-flex justify-content-center mt-4">
        {{ $articles->links('pagination::bootstrap-4') }}
    </div>
    
</div>
@endsection
