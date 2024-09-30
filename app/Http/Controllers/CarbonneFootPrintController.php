<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarbonFootprint;
use Carbon\Carbon;
use App\Models\EnergyConsumption;

class CarbonneFootPrintController extends Controller
{
    //
    public function carbonneDetails()
    {
        return view("Front.ModuleSuiviDeConsommation.CarbonFootprint.ListeDeCarbonneConsommées");
    }
    public function showEnergyConsumption()
    {
        // Récupérer les données pertinentes
        $footprintsWithConsumption = CarbonFootprint::with('consumptionData')->get();
    
        // Calculez les émissions de carbone pour chaque type d'énergie
        $electricityCarbonEmission = $footprintsWithConsumption->sum('Électricité_carbon_emission');
        $gasCarbonEmission = $footprintsWithConsumption->sum('gas_carbon_emission');
        $solarCarbonEmission = $footprintsWithConsumption->sum('Solaire_carbon_emission');
        $windCarbonEmission = $footprintsWithConsumption->sum('Éolienne_carbon_emission');
        $biomassCarbonEmission = $footprintsWithConsumption->sum('Biomasse_carbon_emission');
        $geothermalCarbonEmission = $footprintsWithConsumption->sum('Géothermique_carbon_emission');
        $coalCarbonEmission = $footprintsWithConsumption->sum('Charbon_carbon_emission');
        $oilCarbonEmission = $footprintsWithConsumption->sum('Pétrole_carbon_emission');
        $nuclearCarbonEmission = $footprintsWithConsumption->sum('Nucléaire_carbon_emission');
        $dieselCarbonEmission = $footprintsWithConsumption->sum('Diesel_carbon_emission');
    
        // Calculez l'émission totale
        $totalEmission= $electricityCarbonEmission + $gasCarbonEmission + $solarCarbonEmission +
                         $windCarbonEmission + $biomassCarbonEmission + $geothermalCarbonEmission +
                         $coalCarbonEmission + $oilCarbonEmission + $nuclearCarbonEmission + 
                         $dieselCarbonEmission;
    
        return view('Front.ModuleSuiviDeConsommation.CarbonFootprint.ListeDeCarbonneConsommées', 
                    compact('footprintsWithConsumption', 'electricityCarbonEmission', 'gasCarbonEmission', 
                            'solarCarbonEmission', 'windCarbonEmission', 'biomassCarbonEmission', 
                            'geothermalCarbonEmission', 'coalCarbonEmission', 'oilCarbonEmission', 
                            'nuclearCarbonEmission', 'dieselCarbonEmission', 'totalEmission'));
    }
    
    
    public function listCarbonFootprintsWithConsumption()
    {
        // Récupérer toutes les empreintes carbone avec la consommation d'énergie liée
        $carbonFootprints = CarbonFootprint::with('energyConsumption')->get();
    
        // Regrouper les empreintes carbone par type d'énergie
        $electricityCarbonEmission = $carbonFootprints->where('energyConsumption.energy_type', 'Électricité')->sum('carbon_emission');
        $gasCarbonEmission = $carbonFootprints->where('energyConsumption.energy_type', 'gas')->sum('carbon_emission');
        $solarCarbonEmission = $carbonFootprints->where('energyConsumption.energy_type', 'Solaire')->sum('carbon_emission');
        $windCarbonEmission = $carbonFootprints->where('energyConsumption.energy_type', 'Éolienne')->sum('carbon_emission');
        $biomassCarbonEmission = $carbonFootprints->where('energyConsumption.energy_type', 'Biomasse')->sum('carbon_emission');
        $geothermalCarbonEmission = $carbonFootprints->where('energyConsumption.energy_type', 'Géothermique')->sum('carbon_emission');
        $coalCarbonEmission = $carbonFootprints->where('energyConsumption.energy_type', 'Charbon')->sum('carbon_emission');
        $oilCarbonEmission = $carbonFootprints->where('energyConsumption.energy_type', 'Pétrole')->sum('carbon_emission');
        $nuclearCarbonEmission = $carbonFootprints->where('energyConsumption.energy_type', 'Nucléaire')->sum('carbon_emission');
        $dieselCarbonEmission = $carbonFootprints->where('energyConsumption.energy_type', 'Diesel')->sum('carbon_emission');
        $totalEmission= $electricityCarbonEmission + $gasCarbonEmission + $solarCarbonEmission +
        $windCarbonEmission + $biomassCarbonEmission + $geothermalCarbonEmission +
        $coalCarbonEmission + $oilCarbonEmission + $nuclearCarbonEmission + 
        $dieselCarbonEmission;

        // Retourner les valeurs à la vue
        return view('Front.ModuleSuiviDeConsommation.CarbonFootprint.ListeDeCarbonneConsommées', compact(
            'electricityCarbonEmission', 
            'gasCarbonEmission', 
            'solarCarbonEmission', 
            'windCarbonEmission', 
            'biomassCarbonEmission', 
            'geothermalCarbonEmission', 
            'coalCarbonEmission', 
            'oilCarbonEmission', 
            'nuclearCarbonEmission', 
            'dieselCarbonEmission',
            'totalEmission'
        ));
    }
    
    
    //ListeDeCarbonneConsommées

    public function addCarbonFootprintWithConsumption(Request $request, $userId)
    {
        // Validation des données d'entrée
        $validatedData = $request->validate([
            'energy_type' => 'required|string|max:255',
            'carbon_emission' => 'nullable|numeric',  // Facultatif, car calculé automatiquement
        ]);
    
        // Récupérer la consommation d'énergie la plus récente de l'utilisateur
        $energyConsumption = EnergyConsumption::where('user_id', $userId)
            ->where('energy_type', $validatedData['energy_type'])
            ->orderBy('consumption_date', 'desc')
            ->first();
    
        if (!$energyConsumption) {
            return response()->json(['message' => 'Aucune consommation trouvée pour ce type d\'énergie.'], 404);
        }
    
        // Calcul de l'empreinte carbone en fonction du type d'énergie
        $carbonEmissionFactor = 0; // Par défaut, 0 si le type n'est pas reconnu
    
        switch ($energyConsumption->energy_type) {
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
    
        // Calculer l'empreinte carbone
        $carbonEmission = $energyConsumption->consumption_value * $carbonEmissionFactor;
    
        // Créer un nouvel enregistrement pour CarbonFootprint
        $carbonFootprint = new CarbonFootprint();
        $carbonFootprint->user_id = $userId;
        $carbonFootprint->energy_consumption_id = $energyConsumption->id;
        $carbonFootprint->carbon_emission = $carbonEmission;
        $carbonFootprint->calculation_date = $energyConsumption->consumption_date;
    
        $carbonFootprint->save();
    
        return response()->json(['message' => 'Empreinte carbone ajoutée avec succès !']);
    }
    
 

   
    
}
