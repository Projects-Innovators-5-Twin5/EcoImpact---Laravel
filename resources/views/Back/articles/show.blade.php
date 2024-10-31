@extends('back.layout')

@section('content')
<div class="container card my-4">
    <div class="card-header">
        <h1 class="mb-4">{{ $article['titleArticle'] ?? 'No Title Available' }}</h1>
        <p class="text-muted mb-4">
            <small>Publié le {{ \Carbon\Carbon::parse($article['created_at'] ?? now())->format('d M Y') }}</small>
        </p>
    </div>

    @if($article['imageArticle'])
        <div class="mb-4 mt-2 d-flex justify-content-center border-bottom border-light">
            <img style="max-width: 825px; height: auto;" src="{{ asset('storage/' . $article['imageArticle']) }}" alt="{{ $article['titleArticle'] }}" class="img-fluid rounded mb-3">
        </div>
    @endif

    <div class="mb-4">
        <p class="lead">{{ $article['contentArticle'] }}</p>
    </div>

    <h3 class="mt-5 mb-4">Commentaires</h3>
    @if(empty($article['comments']))
        <p>Aucun commentaire pour cet article.</p>
    @else
        @foreach($article['comments'] as $comment)
            <div class="card mb-2">
                <div class="card-body">
                    <p>{{ $comment['content'] }}</p>
                  
                </div>
            </div>
        @endforeach
    @endif

    <h4 class="mt-5">Ajouter un commentaire</h4>
    <form action="{{ route('commentaires.store', $article['idArticle']) }}" method="POST" class="mb-4">
        @csrf
        <div class="form-group">
            <label for="contentArticle" class="form-label">Votre commentaire</label>
            <textarea name="contentArticle" class="form-control" rows="2" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary my-2">Publier</button>
    </form>
</div>
@endsection
