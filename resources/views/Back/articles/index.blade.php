@extends('back.layout')

@section('content')


<div class="d-block mb-4 mb-md-0 mt-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#">EcoImpact</a></li>
                <li class="breadcrumb-item active" aria-current="page">Articles</li>
            </ol>
        </nav>
        
    </div>


   



<div class="container">
    <div class="card mt-4 border-0 shadow mb-4">
        <div class="card-header d-flex justify-content-between">
           <span> All Articles</span>
     
            <div class="d-flex justify-content-end">
                <div class="input-group me-2 me-lg-3 fmxw-400">
                    <span class="input-group-text">
                        <svg class="icon icon-xs" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </span>
                   
                    <input type="text" class="form-control" id="searchInput" placeholder="Search articles">
                </div>
                <a href="{{ route('back.articles.create') }}" class="btn btn-primary">Create Article</a>
            </div>

                
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0">Title</th>
                            <th class="border-0">Author</th>
                            <th class="border-0">Creation date</th>
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
                <form method="POST" action="{{ route('back.articles.destroy',  ['id' => '-1']) }}">
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
                console.log(articleId);
                var deleteForm = document.querySelector('.modal-footer form');
                deleteForm.action = "{{ route('back.articles.destroy', '') }}" + '/' + articleId; 

});
    
</script>
    
@endsection
