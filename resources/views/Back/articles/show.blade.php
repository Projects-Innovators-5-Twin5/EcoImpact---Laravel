@extends('back.layout')

@section('content')
<div class="container card my-4">
    <div class="card-header">
        <h1 class="mb-4" >{{ $article->titre }}</h1>
    <p class="text-muted mb-4">
        <small>Publié par: {{ $article->user->name }} le {{ $article->created_at->format('d M Y') }}</small>
    </p>
    </div>
    @if($article->image) 
        <div class="mb-4 mt-2 d-flex justify-content-center border-bottom border-light">
            <img style="max-width: 825px; height: auto;" src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->titre }}" class="img-fluid rounded mb-3">
        </div>
    @endif

    <div class="mb-4">
        <p class="lead">{{ $article->contenu }}</p>
    </div>

    <h3 class="mt-5 mb-4">Commentaires</h3>
    @if($article->commentaires->isEmpty())
        <p>Aucun commentaire pour cet article.</p>
    @else
        @foreach($article->commentaires as $commentaire)
            <div class="card mb-2">
                <div class="card-body">
                    <p>{{ $commentaire->contenu }}</p>
                    <p class="text-muted">
                        <small>Par: {{ $commentaire->user->name }} - {{ $commentaire->created_at->format('d M Y') }}</small>
                    </p>
                </div>
            </div>
        @endforeach
    @endif

    <h4 class="mt-5">Ajouter un commentaire</h4>
    <form action="{{ route('commentaires.store', $article->id) }}" method="POST" class="mb-4">
        @csrf
        <div class="form-group">
            <label for="contenu" class="form-label">Votre commentaire</label>
            <textarea name="contenu" class="form-control" rows="2" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary my-2">Publier</button>
    </form>
</div>
@endsection
