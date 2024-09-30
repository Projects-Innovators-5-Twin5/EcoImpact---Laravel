@extends('back.layout')

@section('content')
<div class="container">
    <div class="card mt-4 border-0 shadow mb-4">
        <div class="card-header">
            Liste des articles
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0">Titre</th>
                            <th class="border-0">Auteur</th>
                            <th class="border-0">Date de création</th>
                            <th class="border-0 rounded-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $index => $article)
                        <tr>
                            <td>{{ Str::limit($article->titre, 50) }}</td>
                            <td>{{ $article->user->name }}</td>
                            <td>{{ $article->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('back.articles.show', $article->id) }}" class="btn btn-primary" title="Voir l'article">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('back.articles.edit', $article->id) }}" class="btn btn-warning" title="Modifier l'article">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Updated trigger button for Bootstrap 5 -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                data-id="{{ $article->id }}" data-title="{{ $article->titre }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $articles->links('pagination::bootstrap-4') }}
        </div>
    </div>
   
</div>

<!-- Delete Confirmation Modal --
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                - Updated close button for Bootstrap 5 --
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer l'article "<span id="articleTitle"></span>" ?</p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
                
            </div>
        </div>
    </div>
</div>-->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Code à exécuter lorsque le document est complètement chargé
        console.log("Document is ready");
        
        const deleteButtons = document.querySelectorAll('.btn-danger');
    
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const articleId = this.getAttribute('data-id');
                const articleTitle = this.getAttribute('data-title');
    
                document.getElementById('articleTitle').textContent = articleTitle;
    
                const deleteForm = document.querySelector('.modal-footer form');
            });
        });
    });
    </script>
    
@endsection
