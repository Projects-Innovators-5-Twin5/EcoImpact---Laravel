<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnergyConsumption;
use App\Models\User;
use Carbon\Carbon;
use App\Models\CarbonFootprint;
class ConsommationController extends Controller
{
    // Form view
    public function Consommation()
    {
        return view("Front.ModuleSuiviDeConsommation.EnergyConsumption.formulaireDeConsommation");
    }

    public function store(Request $request)
    {
        // Validation des données d'entrée
        $validatedData = $request->validate([
            'energy_type' => 'required|string|max:255',
            'energy_value' => 'required|numeric',
            'consumption_date' => 'required|date',
        ]);
    
        // 1. Ajouter l'enregistrement de consommation d'énergie
        $energyConsumption = new EnergyConsumption();
        $energyConsumption->user_id = 1;  // Remplacer par auth()->user()->id pour un utilisateur connecté
        $energyConsumption->energy_type = $validatedData['energy_type'];
        $energyConsumption->energy_value = $validatedData['energy_value'];
        $energyConsumption->consumption_date = $validatedData['consumption_date'];
    
        $energyConsumption->save();
    
        // 2. Calculer l'empreinte carbone
        $carbonEmissionFactor = 0; // Par défaut
    
       // Définir les facteurs d'émission pour chaque type d'énergie
switch ($validatedData['energy_type']) {
    case 'Électricité':
        $carbonEmissionFactor = 0.475; // kg CO2 par kWh (moyenne mondiale)
        break;
    case 'gas':
        $carbonEmissionFactor = 0.185; // kg CO2 par kWh
        break;
    case 'Solaire':
        $carbonEmissionFactor = 0.05; // kg CO2 par kWh (cycle de vie)
        break;
    case 'Éolienne':
        $carbonEmissionFactor = 0.02; // kg CO2 par kWh (cycle de vie)
        break;
    case 'Biomasse':
        $carbonEmissionFactor = 0.1; // kg CO2 par kWh (selon le type de biomasse)
        break;
    case 'Géothermique':
        $carbonEmissionFactor = 0.05; // kg CO2 par kWh
        break;
    case 'Charbon':
        $carbonEmissionFactor = 1.2; // kg CO2 par kWh (charbon)
        break;
    case 'Pétrole':
        $carbonEmissionFactor = 0.249; // kg CO2 par kWh (pétrole)
        break;
    case 'Nucléaire':
        $carbonEmissionFactor = 0.012; // kg CO2 par kWh (cycle de vie)
        break;
    case 'Diesel':
        $carbonEmissionFactor = 0.267; // kg CO2 par kWh (diesel)
        break;
    default:
        $carbonEmissionFactor = 0; // Facteur d'émission par défaut si inconnu
        break;
}

    
        // Calculer l'empreinte carbone (en kg CO2)
        $carbonEmission = $validatedData['energy_value'] * $carbonEmissionFactor;
    
        // 3. Ajouter l'enregistrement d'empreinte carbone
        $carbonFootprint = new CarbonFootprint();
        $carbonFootprint->user_id = 1;  // Remplacer par auth()->user()->id pour un utilisateur connecté
        $carbonFootprint->energy_consumption_id = $energyConsumption->id;  // Lier la consommation d'énergie
        $carbonFootprint->carbon_emission = $carbonEmission;
        $carbonFootprint->calculation_date = $validatedData['consumption_date']; // Utiliser la même date que la consommation
    
        $carbonFootprint->save();
    
        // Retourner une réponse ou rediriger avec un message de succès
        return redirect()->back()->with('success', 'Données enregistrées avec succès, et empreinte carbone calculée !');
    }
    
  
 public function listConsumptions()
 {
    
     $userConsumptions = EnergyConsumption::where('user_id', 1)->paginate(10);
     $userConsumptionTotal = $userConsumptions->sum('energy_value');
 
   
     $globalConsumptions = EnergyConsumption::all();
     $globalConsumptionTotal = $globalConsumptions->sum('energy_value');
 
  
     $consumptionDates = $userConsumptions->pluck('consumption_date')->toArray();
     $consumptionValues = $userConsumptions->pluck('energy_value')->toArray();
 
 
     $globalConsumptionDates = $globalConsumptions->pluck('consumption_date')->map(function ($date) {
         return Carbon::parse($date)->format('Y-m-d'); 
     })->toArray();
     $globalConsumptionValues = $globalConsumptions->pluck('energy_value')->toArray();
 
   
     return view('Front.ModuleSuiviDeConsommation.EnergyConsumption.ListeDeDeConsommation', compact(
         'userConsumptions', 'userConsumptionTotal', 'globalConsumptionTotal', 
         'consumptionDates', 'consumptionValues', 
         'globalConsumptionValues', 'globalConsumptionDates'
     ));
 }

 public function listConsumptionsBack()
 {
     // Récupérer tous les utilisateurs avec leurs consommations
     $users = User::with('consumptions.carbonFootprint')->get();
 
     // Récupérer toutes les consommations d'énergie avec leurs empreintes carbone
     $energyConsumptions = EnergyConsumption::with('carbonFootprint')->get();
 
     // Calculer la consommation totale d'énergie
     $globalConsumptionTotal = $energyConsumptions->sum('energy_value');
 
     // Optionnel : Calculer la valeur totale de carbone
     $globalCarbonTotal = $energyConsumptions->sum(function ($consumption) {
         return optional($consumption->carbonFootprint)->carbon_emission; // Assurez-vous d'adapter le champ ici
     });
 
     return view('Back.ModuleSuiviDeConsommationBackModule1.ListeDeConsommationEnergitiqueETCarbonique', compact(
         'users', 'energyConsumptions', 'globalConsumptionTotal', 'globalCarbonTotal'
     ));
 }

 public function edit($id)
 {
     $consumption = EnergyConsumption::findOrFail($id);
     return view('Front.ModuleSuiviDeConsommation.EnergyConsumption.editConsumption', compact('consumption'));
 }
 
 public function update(Request $request, $id)
 {
     $request->validate([
         'energy_type' => 'required|string',
         'energy_value' => 'required|numeric',
         'consumption_date' => 'required|date',
     ]);
 
     $consumption = EnergyConsumption::findOrFail($id);
     $consumption->update([
         'energy_type' => $request->energy_type,
         'energy_value' => $request->energy_value,
         'consumption_date' => $request->consumption_date,
     ]);
 
     return redirect()->route('consommation.list')->with('success', 'Consommation mise à jour avec succès.');
 }
 

public function destroy($id)
{
    // Récupérer la consommation d'énergie par ID
    $consumption = EnergyConsumption::findOrFail($id);

    // Supprimer l'enregistrement
    $consumption->delete();

    // Redirection avec message de succès
    return redirect()->route('consommation.list')->with('success', 'Consommation supprimée avec succès.');
}

public function destroyback($id)
{
    // Trouver l'utilisateur par son ID
    $user = User::find($id);

    // Vérifier si l'utilisateur existe
    if (!$user) {
        return redirect()->back()->with('error', 'Utilisateur non trouvé.');
    }

    // Supprimer les consommations associées à cet utilisateur
    $user->consumptions()->delete();

    // Supprimer l'utilisateur
    $user->delete();

    // Rediriger avec un message de succès
    return redirect()->route('consommationBack.list')->with('success', 'Consommation supprimée avec succès.');
}
public function editback($id)
{
    // Trouver l'utilisateur par son ID
    $user = User::find($id);

    // Vérifier si l'utilisateur existe
    if (!$user) {
        return redirect()->back()->with('error', 'Utilisateur non trouvé.');
    }

    // Récupérer les données des consommations de l'utilisateur
    $consumptions = $user->consumptions;

    // Retourner la vue avec les données de l'utilisateur et de ses consommations
    return view('back.ModuleSuiviDeConsommationBackModule1.editConsumptionback', compact('user', 'consumptions'));
}
public function updateback(Request $request, $id)
{
    // Valider les données du formulaire
    $request->validate([
        'name' => 'required|string|max:255',
        'consumptions.*.energy_value' => 'required|numeric', // Validation pour les valeurs de consommation
        // Tu peux ajouter d'autres règles de validation si nécessaire
    ]);

    // Trouver l'utilisateur par son ID
    $user = User::find($id);

    // Vérifier si l'utilisateur existe
    if (!$user) {
        return redirect()->back()->with('error', 'Utilisateur non trouvé.');
    }

    // Mettre à jour les informations de l'utilisateur
    $user->name = $request->input('name');
    $user->save();

    // Mettre à jour les consommations de l'utilisateur
    foreach ($request->input('consumptions') as $consumptionData) {
        if (!empty($consumptionData['id'])) {
            $consumption = EnergyConsumption::find($consumptionData['id']);
            if ($consumption) {
                $consumption->energy_value = $consumptionData['energy_value'];
                $consumption->save();
            }
        } else {
            // Logique pour gérer les nouvelles consommations, si nécessaire
        }
    }

    // Rediriger avec un message de succès
    return redirect()->route('consommationBack.list')->with('success', 'Consommation mise à jour avec succès.');
}


 
 
 public function getConsumptionDetails($userId)
 {
     $consumptions = EnergyConsumption::with('carbonFootprint')
         ->where('user_id', $userId)
         ->get();
 
     return response()->json(['consumptions' => $consumptions]);
 }
 

 
public function getUserConsumptions($id)
{
    $user = User::with('consumptions')->findOrFail($id);
    return response()->json(['consumptions' => $user->consumptions]);
}

 


    public function getConsumptionDataByType(Request $request)
    {
        
        $request->validate([
            'energy_type' => 'required|string|max:255',
        ]);
    
      
        $energyType = $request->input('energy_type');
    
        $consumptions = EnergyConsumption::where('energy_type', $energyType)
            ->where('user_id', 1) 
            ->get();
    
      
        $data = [
            'labels' => $consumptions->pluck('consumption_date')->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d'); 
            })->toArray(),
            'values' => $consumptions->pluck('energy_value')->toArray(),
        ];
    
      
        return response()->json($data);
    }
    
    public function show($id)
{
    $consumptions = EnergyConsumption::where('user_id', $id)->get();

    return response()->json(['consumptions' => $consumptions]);
}
public function getGlobalConsumptionData()
{
    $globalConsumptions = EnergyConsumption::all();
    $consumptionData = $globalConsumptions->groupBy('energy_type');

    $result = [];
    foreach ($consumptionData as $energyType => $consumptions) {
        $result[$energyType] = [
            'labels' => $consumptions->pluck('consumption_date')->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d'); 
            })->toArray(),
            'values' => $consumptions->pluck('energy_value')->toArray(),
        ];
    }

    return response()->json($result);
}

  
}
