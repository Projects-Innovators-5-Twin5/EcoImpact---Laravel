<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnergyConsumption;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Services\RdfApiService;
use App\Models\CarbonFootprint;
class ConsommationController extends Controller
{
    protected $rdfApiService;

    public function __construct(RdfApiService $rdfApiService)
    {
        $this->rdfApiService = $rdfApiService;
    }
    // Form view
    public function Consommation()
    {
        return view("Front.ModuleSuiviDeConsommation.EnergyConsumption.formulaireDeConsommation");
    }


public function listConsumptions()
{
    // Récupérer toutes les consommations d'énergie via l'API
    $energyConsumptions = collect($this->rdfApiService->getAllEnergyConsumptions());

    // Remplir les valeurs de consommation
    $consumptionValues = $energyConsumptions->pluck('energyValue')->toArray(); // Remplacez 'energyValue' par le bon champ

return view('Front.ModuleSuiviDeConsommation.EnergyConsumption.ListeDeDeConsommation', [
        'energyConsumptions' => $energyConsumptions,
        'consumptionValues' => $consumptionValues, // Assurez-vous d'envoyer cette variable
    ]);
}

public function storeEnergie(Request $request)
{
    // Valider les données entrantes
    $request->validate([
        'energyType' => 'required|string',
        'energyValue' => 'required|numeric',
        'consumptionDate' => 'required|string',
    ]);

    // Préparer les données pour l'API
    $data = [
        'energyType' => $request->energyType,
        'energyValue' => $request->energyValue,
        'consumptionDate' => $request->consumptionDate,
    ];

    // Appel à l'API pour créer une consommation d'énergie
    $response = Http::post('http://localhost:1064/api/energy/energy-consumption', $data);

    // Vérification de la réponse de l'API
    if ($response->successful()) {
        // Si l'API a réussi, retourner une réponse ou redirection appropriée
        return response()->json(['message' => 'Consommation d\'énergie créée avec succès!'], 201);
    } else {
        // Gérer les erreurs en cas d'échec de l'API
        return response()->json(['message' => 'Erreur lors de la création de la consommation d\'énergie.'], $response->status());
    }
}

public function updateEnergie(Request $request, $id)
{
    // Valider les données entrantes
    $request->validate([
        'energyType' => 'required|string',
        'energyValue' => 'required|numeric',
        'consumptionDate' => 'required|string',
    ]);

    // Préparer les données pour l'API
    $data = [
        'energyType' => $request->energyType,
        'energyValue' => $request->energyValue,
        'consumptionDate' => $request->consumptionDate,
    ];

    // Appel à l'API pour mettre à jour la consommation d'énergie existante
    $response = Http::put("http://localhost:1064/api/energy/energy-consumption/update/{$id}", $data);

    // Vérification de la réponse de l'API
    if ($response->successful()) {
        // Si l'API a réussi, retourner une réponse ou redirection appropriée
        return response()->json(['message' => 'Consommation d\'énergie mise à jour avec succès!'], 200);
    } else {
        // Gérer les erreurs en cas d'échec de l'API
        return response()->json(['message' => 'Erreur lors de la mise à jour de la consommation d\'énergie.'], $response->status());
    }
}


 public function delete($id)
    {
        // URL de l'API pour supprimer la consommation d'énergie
        $url = 'http://localhost:1064/api/energy/energy-consumption/delete/' . $id;

        // Appel à l'API pour supprimer la consommation d'énergie
        $response = Http::delete($url);

        // Vérifiez le statut de la réponse
        if ($response->failed()) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression de la consommation d\'énergie.');
        }

        return redirect()->route('listConsumptions')->with('success', 'Consommation d\'énergie supprimée avec succès.');
    }


}
