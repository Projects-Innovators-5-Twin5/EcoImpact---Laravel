@extends('back.layout')

@section('content')
<title>EcoImpact - Liste des Produits</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<!-- Breadcrumb navigation -->
<div class="d-block mb-4 mb-md-0 mt-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="#">EcoImpact</a></li>
            <li class="breadcrumb-item active" aria-current="page">Liste des Produits</li>
        </ol>
    </nav>
    <h2 class="h4">Tous les Produits</h2>
</div>

<br>

<!-- Products Table -->
<div class=" border-0 shadow mb-4">
    <div class="">
        <div class="d-flex justify-content-between">
            <h5 class="">Liste des Produits</h5>
            <a href="{{ route('produits.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Ajouter un Produit
            </a>
        </div>
        <br>

        <div class="table-responsive">
            <table id="produitsTable" class="table table-hover table-centered table-striped rounded w-100">
                <thead class="thead-light">
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produits as $produit)
                        <tr>
                            <td>{{ $produit->nom }}</td>
                            <td>{{ Str::limit($produit->description, 20) }}</td>
                            <td>{{ $produit->prix }} DT</td>
                            <td>{{ $produit->quantite }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $produit->image) }}" alt="Image du produit" class="img-fluid" style="max-width: 100px; max-height: 100px;">
                            </td>
                            <td>
                                <!-- View Button -->
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $produit->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <!-- Edit Button -->
                                <a href="{{ route('produits.edit', $produit->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $produit->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $produit->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $produit->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $produit->id }}">Confirmation de suppression</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Êtes-vous sûr de vouloir supprimer le produit "<strong>{{ $produit->nom }}</strong>" ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <form action="{{ route('produits.destroy', $produit->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- View Modal -->
                                <div class="modal fade" id="viewModal{{ $produit->id }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $produit->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewModalLabel{{ $produit->id }}">Détails du Produit</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="image-framecard">
                                                    <img src="{{ asset('storage/' . $produit->image) }}" alt="Image du produit" class="img-fluid product-image" />
                                                </div>
                                                <strong>Nom:</strong> {{ $produit->nom }}<br>
                                                <strong>Description:</strong> {{ $produit->description }}<br>
                                                <strong>Prix:</strong> {{ $produit->prix }} DT<br>
                                                <strong>Quantité:</strong> {{ $produit->quantite }}<br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
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
        $('#produitsTable').DataTable({
            "language": {
                "search": "Rechercher:",
                "lengthMenu": "Afficher _MENU_ produits par page",
                "zeroRecords": "Aucun produit trouvé",
                "info": "Affichage de _START_ à _END_ sur _TOTAL_ produits",
                "infoEmpty": "Aucun produit disponible",
                "infoFiltered": "(filtré à partir de _MAX_ produits)",
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

