<?php
namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    // Afficher toutes les catégories
    public function index()
    {
        $categories = Categorie::with('produits')->get();
        return view('back.categorie', compact('categories'));
    }

    // Afficher le formulaire de création de catégorie
    public function create()
    {
        $produits = Produit::whereNull('categorie_id')->get(); // Récupérer tous les produits non affectés
        return view('back.createCategorie', compact('produits'));
    }

    // Enregistrer une nouvelle catégorie
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|min:3|max:100',
            'description' => 'required|min:10|max:500',
            'produits' => 'array|nullable',
            'produits.*' => 'exists:produits,id',
        ]);

        try {
            // Création de la catégorie
            $categorie = Categorie::create([
                'nom' => $request->nom,
                'description' => $request->description,
            ]);

            // Affectation des produits à la catégorie si fournis
            if ($request->filled('produits')) {
                // Mettre à jour le champ categorie_id des produits
                Produit::whereIn('id', $request->produits)->update(['categorie_id' => $categorie->id]);
            }

            // Redirection avec message de succès
            return redirect()->route('categories.index')->with('success', 'Catégorie créée avec succès!');
        } catch (\Exception $e) {
            // En cas d'erreur, retour avec message d'erreur
            return back()->withErrors(['message' => 'Erreur lors de la création de la catégorie: ' . $e->getMessage()])->withInput();
        }
    }

    // Afficher une catégorie spécifique
    public function show($id)
    {
        $categorie = Categorie::with('produits')->findOrFail($id);
        return view('back.categorie', compact('categorie'));
    }

    // Afficher le formulaire d'édition d'une catégorie
    public function edit($id)
    {
        $categorie = Categorie::with('produits')->findOrFail($id);
        $produits = Produit::all(); // Récupérer tous les produits
        return view('back.editCategorie', compact('categorie', 'produits'));
    }

    // Mettre à jour une catégorie existante
    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:500', // La description est facultative
            'produits' => 'array|nullable',
            'produits.*' => 'exists:produits,id', // Vérification que chaque produit existe
        ]);

        try {
            // Récupérer la catégorie à modifier
            $categorie = Categorie::findOrFail($id);

            // Mettre à jour les informations de la catégorie
            $categorie->update($request->only('nom', 'description'));

            // Optionnel: Mettre à jour les produits associés
            if ($request->filled('produits')) {
                // Mettre à jour le champ categorie_id des produits
                Produit::whereIn('id', $request->produits)->update(['categorie_id' => $categorie->id]);
            }

            // Redirection avec message de succès
            return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour avec succès');
        } catch (\Exception $e) {
            // En cas d'erreur, retour avec message d'erreur
            return back()->withErrors(['message' => 'Erreur lors de la mise à jour de la catégorie: ' . $e->getMessage()])->withInput();
        }
    }

    // Supprimer une catégorie
    public function destroy($id)
    {
        try {
            $categorie = Categorie::findOrFail($id);
            $categorie->produits()->update(['categorie_id' => null]); // Supprimer l'affectation des produits
            $categorie->delete();

            return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Erreur lors de la suppression de la catégorie: ' . $e->getMessage()]);
        }
    }

    // Afficher le formulaire d'affectation de produits à une catégorie
    public function assignProducts($id)
    {
        $categorie = Categorie::findOrFail($id);
        $produits = Produit::whereNull('categorie_id')->get(); // Produits non affectés
        $assignedProducts = $categorie->produits; // Produits déjà assignés à la catégorie
        return view('back.assign', compact('categorie', 'produits', 'assignedProducts'));
    }

    // Affecter des produits à une catégorie
    public function storeAssignedProducts(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'produits' => 'required|array',
            'produits.*' => 'exists:produits,id', // Validation que chaque produit existe
        ]);

        try {
            $categorie = Categorie::findOrFail($id);
            Produit::whereIn('id', $request->produits)->update(['categorie_id' => $categorie->id]);

            return redirect()->route('categories.index')->with('success', 'Produits assignés à la catégorie avec succès');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Erreur lors de l\'affectation des produits: ' . $e->getMessage()]);
        }
    }

    // Retirer des produits d'une catégorie
    public function removeProducts(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'produits' => 'required|array',
            'produits.*' => 'exists:produits,id', // Validation que chaque produit existe
        ]);

        try {
            $categorie = Categorie::findOrFail($id);
            Produit::whereIn('id', $request->produits)->update(['categorie_id' => null]); // Retirer l'affectation

            return redirect()->route('categories.index')->with('success', 'Produits retirés de la catégorie avec succès');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Erreur lors du retrait des produits: ' . $e->getMessage()]);
        }
    }

    // Retirer un produit spécifique d'une catégorie
    public function removeAssignedProduct($categoryId, $productId)
    {
        try {
            $categorie = Categorie::findOrFail($categoryId);
            $produit = Produit::findOrFail($productId);

            // Retirer l'affectation du produit
            $produit->categorie_id = null;
            $produit->save();

            return redirect()->route('categories.assignProducts', $categoryId)->with('success', 'Produit retiré de la catégorie avec succès');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Erreur lors du retrait du produit: ' . $e->getMessage()]);
        }
    }
}
