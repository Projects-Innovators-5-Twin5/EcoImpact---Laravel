@extends('back.layout')

@section('content')
<div class="container">
    <div class="card mt-4 border-0 shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Liste des articles</span>
            <!-- Add "Add Article" button here -->
            <a href="{{ route('back.articles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter un Article
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0">Titre</th>
                            <th class="border-0">Auteur</th>
                            <th class="border-0">Categorie</th>
                            <th class="border-0 rounded-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $index => $article)
                        <tr>
                            <td>{{ Str::limit($article['title'], 50) }}</td>
                            <td>Admin</td>
                            <td>{{$article['categories']}}</td>

                            <td>
                                <a href="{{ route('back.articles.show', $article['id']) }}" class="btn btn-primary" title="Voir l'article">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('back.articles.edit', $article['id']) }}" class="btn btn-warning" title="Modifier l'article">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                    data-id="{{ $article['id'] }}" data-title="{{ $article['title'] }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer l'article "<span id="articleTitle"></span>" ?</p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('back.articles.destroy', ['id' => '-1']) }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
var deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    const articleId = button.getAttribute('data-id');
    const articleTitle = button.getAttribute('data-title');

    document.getElementById('articleTitle').textContent = articleTitle;
    var deleteForm = document.querySelector('.modal-footer form');
    deleteForm.action = "{{ route('back.articles.destroy', '') }}" + '/' + articleId; 
});
</script>
@endsection
