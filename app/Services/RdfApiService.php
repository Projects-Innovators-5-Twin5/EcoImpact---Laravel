<?php
namespace App\Services;

use GuzzleHttp\Client;


class RdfApiService
{
    protected $client;
    protected $baseUri;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUri = env('RDF_API_URL');
    }

    public function getAllEnergyConsumptions()
    {
        try {
            $response = $this->client->request('GET', $this->baseUri);
            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody()->getContents(), true);
            }
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            return null;
        }

        return null;
    }

    public function createEnergyConsumption($data)
    {
        try {
            // Envoyer les données à l'API externe pour sauvegarde
            $response = $this->client->request('POST', $this->baseUri, [
                'json' => $data,
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode == 201) {  // Code 201 si l'API confirme la création
                return json_decode($response->getBody()->getContents(), true);
            } elseif ($statusCode == 302) { // Redirection si l'API renvoie un code 302
                return ['redirect' => $response->getHeaderLine('Location')];
            } else {
                // Gestion d'autres codes d'état inattendus
                return ['error' => 'Unexpected response code: ' . $statusCode];
            }
        } catch (\Exception $e) {
            // Gestion des erreurs et retour du message d'erreur
            return ['error' => $e->getMessage()];
        }
    }
    public function createCarbonFootprint($carbonEmission, $consumptionDate)
{
    // Préparez vos données pour l'API ou la base de données
    $data = [
        'carbonEmission' => $carbonEmission,
        'calculationDate' => $consumptionDate,
    ];

    // Ici, vous devriez avoir la logique pour ajouter l'empreinte carbone à votre modèle RDF
    // Par exemple, en appelant une API ou en l'ajoutant à un modèle de base de données

    return true; // Changez cela en fonction de votre logique d'enregistrement
}

    public function calculateCarbonFootprint($energyType, $energyValue)
{
    // Définir les facteurs d'émission pour chaque type d'énergie
    $emissionFactors = [
        'Charbon' => 0.9,
        'Pétrole' => 0.7,
        'Gaz Naturel' => 0.4,
        'Solaire' => 0.035,
        'Éolien' => 0.015,
        'Hydroélectrique' => 0.040,
        'Nucléaire' => 0.015,
        'Biomasse' => 0.160,
    ];

    // Vérifiez si le type d'énergie existe dans le tableau
    if (!array_key_exists($energyType, $emissionFactors)) {
        throw new \InvalidArgumentException("Unknown energy type: " . $energyType);
    }

    // Calculez les émissions de carbone en kg
    return $energyValue * $emissionFactors[$energyType];
}

}
