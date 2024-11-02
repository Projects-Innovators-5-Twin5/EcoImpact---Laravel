@extends('front.layout')
<link rel="stylesheet" href="{{ asset('css/articles_commentaires.css') }}">

@section('content')
<div class="bg-white">
    <div class="annonce-header mb-4 p-3 bg-primary text-white text-center animated-header" style="margin-bottom: -3rem !important;">
        <h2 class="mb-0"><i class="fas fa-bullhorn"></i> Nouveauté : Découvrez nos dernières solutions énergétiques !</h2>
    </div>

    <div class="container">
        <div class="content-front card" style="border: none; text-align:left;">
            <div class="card-header text-center" style="border-bottom: none; margin-bottom: -4rem;">
                <h1 class="mb-4">{{ $article['titleArticle'] }}</h1>
                <p class="text-muted mb-4">
                    <small class="text-secondary">
                        <i class="fas fa-user "></i> Publié par: Robert Iplekci
                    </small>
                    <small class="mx-2 text-primary"> 
                    </small>
                </p>
            </div>

            @if($article['imageArticle']) 
                <div class="mb-4 mt-2 d-flex py-4 justify-content-center border-bottom border-light">
                    <img class="shadow-lg rounded" style="width: 695px; max-height: 375px;" src="{{ asset('storage/' . $article['imageArticle']) }}" alt="{{ $article['titleArticle'] }}" class="img-fluid rounded mb-3">
                </div>
            @endif

            <div class="mb-4">
                <p class="lead text-black" style="font-weight: 400;">{{ $article['contentArticle'] }}</p>
            </div>

            <div class="shadow-lg px-4 mb-4 rounded">
                <h3 class="mt-5 mb-4"><i class="fas fa-comments"></i> Commentaires</h3>
                @if(empty($article['comments']))
                    <p><i class="fas fa-info-circle"></i> Aucun commentaire pour cet article.</p>
                @else
                    @foreach($article['comments'] as $commentaire)
                        <div class="card mb-2 bg-gray-50" style="border:none;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <p id="comment-content-{{ $commentaire['id'] }}">{{ $commentaire['content'] }}</p>

                                    <form action="{{ route('front.commentaires.update', $commentaire['id']) }}" method="POST" style="width:90%;" id="edit-form-{{ $commentaire['id'] }}" class="d-none" novalidate>
                                        @csrf
                                        @method('PUT')
                                        <textarea name="content" class="form-control mb-2">{{ $commentaire['content'] }}</textarea>
                                        <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
                                        <button type="button" class="btn btn-secondary btn-sm" onclick="cancelEdit({{ $commentaire['id'] }})">Annuler</button>
                                    </form>

                                    <div class="dropdown">
                                        <button class="btn btn-link p-0 text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="#" onclick="editComment({{ $commentaire['id'] }})">Modifier</a></li>
                                            <li>
                                                <button type="button" class="dropdown-item btn-danger" data-id="{{ $commentaire['id'] }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                    Supprimer
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <p class="text-muted">
                                    <small class="text-primary">
                                        <i class="fas fa-user"></i> Par: user1
                                    </small>
                                    <small class="text-secondary mx-2">
                                        <i class="fas fa-calendar-alt"></i> 
                                    </small>
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif

                <h4 class="mt-5"><i class="fas fa-plus-circle"></i> Ajouter un commentaire</h4>
                <form action="{{ route('commentaires.store', $article['idArticle']) }}" method="POST" class="mb-4" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="contenu" class="form-label">Votre commentaire</label>
                                <textarea name="contentArticle" class="form-control" rows="2" required></textarea>
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

@include('front.articles.modal_delete')

<script>
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var commentId = button.getAttribute('data-id');
        var form = document.getElementById('deleteForm');
        form.action = "{{ route('commentaires.destroy', '') }}" + '/' + commentId; // Update the form action
    });

    function editComment(commentId) {
        document.getElementById('comment-content-' + commentId).classList.add('d-none');
        document.getElementById('edit-form-' + commentId).classList.remove('d-none');
    }
    
    function cancelEdit(commentId) {
        document.getElementById('comment-content-' + commentId).classList.remove('d-none');
        document.getElementById('edit-form-' + commentId).classList.add('d-none');
    }
</script>
@endsection
