@extends('back.layout')

@section('content')
    <title>EcoImpact - Liste des Commandes</title>
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
                <li class="breadcrumb-item active" aria-current="page">Liste des Commandes</li>
            </ol>
        </nav>
        <h2 class="h4">Toutes les Commandes</h2>
    </div>

    <br>

    <!-- Commandes Table -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h5 class="card-title">Liste des Commandes</h5>
            </div>
            <br>

            <div class="table-responsive">
                <table id="commandesTable" class="table table-hover table-centered table-striped rounded w-100">
                    <thead class="thead-light">
                        <tr>
                            <th>Client Nom</th>
                            <th>Email</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($commandes as $commande)
                            <tr>
                                <td>{{ $commande->client_nom }}</td>
                                <td>{{ $commande->client_email }}</td>
                                <td>{{ number_format($commande->total, 2) }} DT</td>
                                <td>{{ $commande->statut }}</td>

                                <td>
                                    <!-- View Button -->
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $commande->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $commande->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $commande->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $commande->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $commande->id }}">Confirmation de suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer la commande de "<strong>{{ $commande->client_nom }}</strong>" ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('commandes.destroy', $commande->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- View Modal -->
                                    <div class="modal fade" id="viewModal{{ $commande->id }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $commande->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewModalLabel{{ $commande->id }}">Détails de la Commande</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <strong>Nom du Client:</strong> {{ $commande->client_nom }}<br>
                                                    <strong>Email:</strong> {{ $commande->client_email }}<br>
                                                    <strong>Total:</strong> {{ number_format($commande->total, 2) }} DT<br>
                                                    <strong>Statut:</strong> {{ $commande->statut }}<br>
                                                    <strong>Produits:</strong>
                                                    <ul>
                                                        @foreach ($commande->produits as $produit)
                                                        <li>produit: {{ $produit->id }} _ Quantite {{ $produit->quantite }}</li>
                                                        @endforeach
                                                    </ul>
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
            $('#commandesTable').DataTable({
                "language": {
                    "search": "Rechercher:",
                    "lengthMenu": "Afficher _MENU_ commandes par page",
                    "zeroRecords": "Aucune commande trouvée",
                    "info": "Affichage de _START_ à _END_ sur _TOTAL_ commandes",
                    "infoEmpty": "Aucune commande disponible",
                    "infoFiltered": "(filtré à partir de _MAX_ commandes)",
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
