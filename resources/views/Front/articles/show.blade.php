@extends('front.layout')
<link rel="stylesheet" href="{{ asset('css/articles_commentaires.css') }}">

@section('content')
<div class="bg-white">
     <!-- Section de l'annonce -->
     <div class="annonce-header mb-4 p-3 bg-primary text-white text-center animated-header" style="    margin-bottom: -3rem !important;">
        <h2 class="mb-0"><i class="fas fa-bullhorn"></i> Nouveauté : Découvrez nos dernières solutions énergétiques !</h2>
    </div>

   <div class="container">

   
    <div class="content-front card" style="border: none; text-align:left;">
        <div class="card-header text-center" style="border-bottom: none;margin-bottom:-4rem;">
            <h1 class="mb-4">{{ $article->titre }}</h1>
            <p class="text-muted mb-4">
                <small class="text-secondary">
                    <i class="fas fa-user "></i> Publié par: {{ $article->user->name }} 
                </small>
                <small class="mx-2 text-primary"> 
                    <i class="fas fa-calendar-alt"></i> le {{ $article->created_at->format('d M Y') }}
                </small>
            </p>
        </div>

        @if($article->image) <!-- Check if there is an image -->
            <div class="mb-4 mt-2 d-flex py-4 justify-content-center border-bottom border-light ">
                <img class="shadow-lg rounded" style="    width: 695px;max-height: 375px;" src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->titre }}" class="img-fluid rounded mb-3">
            </div>
        @endif

        <div class="mb-4">
            <p class="lead text-black" style="font-weight: 400;">{{ $article->contenu }}</p>
        </div>

      <div class="shadow-lg px-4 mb-4 rounded">
        <h3 class="mt-5 mb-4"><i class="fas fa-comments"></i> Commentaires</h3>
        @if($article->commentaires->isEmpty())
            <p><i class="fas fa-info-circle"></i> Aucun commentaire pour cet article.</p>
        @else
            @foreach($article->commentaires as $commentaire)
                <div class="card mb-2 bg-gray-50" style="border:none;">
                    <div class="card-body">
                        <p>{{ $commentaire->contenu }}</p>
                        <p class="text-muted">
                            <small class="text-primary">
                                <i class="fas fa-user"></i> Par: {{ $commentaire->user->name }}
                            </small>
                            <small class="text-secondary mx-2">
                                <i class="fas fa-calendar-alt"></i> {{ $commentaire->created_at->format('d M Y') }}
                            </small>
                        </p>

                        <!-- Like and Dislike section -->
                        <div class="d-flex justify-content-start align-items-center">
                            <button class="btn btn-link p-0 me-2" style="color: #28a745;">
                                <i class="fas fa-thumbs-up"></i> <span class="ms-1">J'aime</span>
                            </button>
                            <button class="btn btn-link p-0" style="color: #dc3545;">
                                <i class="fas fa-thumbs-down"></i> <span class="ms-1">Je n'aime pas</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        <h4 class="mt-5"><i class="fas fa-plus-circle"></i> Ajouter un commentaire</h4>
        <form action="{{ route('commentaires.store', $article->id) }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
               <div class="col-md-9">
                   <div class="form-group">
                       <label for="contenu" class="form-label">Votre commentaire</label>
                       <textarea name="contenu" class="form-control" rows="2" required></textarea>
                   </div>
               </div>
               <div class="col-md-3 mt-4">    
                   <button type="submit" class="btn btn-primary my-2 py-3">
                       <i class="fas fa-paper-plane"></i> Publier
                   </button>
               </div>
            </div>
         </form>
      </div>
    </div>
   </div>
</div>
@endsection
