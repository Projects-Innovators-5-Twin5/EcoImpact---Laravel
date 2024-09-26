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
    case 'electricity':
        $carbonEmissionFactor = 0.475; // kg CO2 par kWh (moyenne mondiale)
        break;
    case 'gas':
        $carbonEmissionFactor = 0.185; // kg CO2 par kWh
        break;
    case 'solar':
        $carbonEmissionFactor = 0.05; // kg CO2 par kWh (cycle de vie)
        break;
    case 'wind':
        $carbonEmissionFactor = 0.02; // kg CO2 par kWh (cycle de vie)
        break;
    case 'biomass':
        $carbonEmissionFactor = 0.1; // kg CO2 par kWh (selon le type de biomasse)
        break;
    case 'geothermal':
        $carbonEmissionFactor = 0.05; // kg CO2 par kWh
        break;
    case 'coal':
        $carbonEmissionFactor = 1.2; // kg CO2 par kWh (charbon)
        break;
    case 'oil':
        $carbonEmissionFactor = 0.249; // kg CO2 par kWh (pétrole)
        break;
    case 'nuclear':
        $carbonEmissionFactor = 0.012; // kg CO2 par kWh (cycle de vie)
        break;
    case 'diesel':
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
    

  
}
