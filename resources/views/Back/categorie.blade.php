    @extends('back.layout')

    @section('content')
    <title>EcoImpact - Liste des Catégories</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <!-- Breadcrumb navigation -->
    <div class="d-block mb-4 mb-md-0 mt-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item"><a href="#">EcoImpact</a></li>
                <li class="breadcrumb-item active" aria-current="page">Liste des Catégories</li>
            </ol>
        </nav>
        <h2 class="h4">Toutes les Catégories</h2>
    </div>

    <br>

    <!-- Categories Table -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h5 class="card-title">Liste des Catégories</h5>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Ajouter une Catégorie
                </a>
            </div>
            <br>

            <div class="table-responsive">
                <table id="categoriesTable" class="table table-hover table-centered table-striped rounded w-100">
                    <thead class="thead-light">
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Produits</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $categorie)
                            <tr>
                                <td>{{ $categorie->nom }}</td>
                                <td>{{ Str::limit($categorie->description, 20) }}</td>
                                <td>{{ $categorie->produits->count() }} Produits</td>
                                <td>
                                    <!-- Edit Button -->
        <a href="{{ route('categories.edit', $categorie->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i>
        </a>

                                    <!-- Delete Button -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $categorie->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Assign Products Button -->
                                    <a href="{{ route('categories.assignProducts', $categorie->id) }}" class="btn btn-info">
                                        <i class="fas fa-box"></i> Affecter Produits
                                    </a>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $categorie->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $categorie->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $categorie->id }}">Confirmation de suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer la catégorie "<strong>{{ $categorie->nom }}</strong>" ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('categories.destroy', $categorie->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#categoriesTable').DataTable({
                "language": {
                    "search": "Rechercher:",
                    "lengthMenu": "Afficher _MENU_ catégories par page",
                    "zeroRecords": "Aucune catégorie trouvée",
                    "info": "Affichage de _START_ à _END_ sur _TOTAL_ catégories",
                    "infoEmpty": "Aucune catégorie disponible",
                    "infoFiltered": "(filtré à partir de _MAX_ catégories)",
                    "paginate": {
                        "first": "Première",
                        "last": "Dernière",
                        "next": "Suivant",
                        "previous": "Précédent"
                    }
                }
            });
        });
    </script>

    @endsection
