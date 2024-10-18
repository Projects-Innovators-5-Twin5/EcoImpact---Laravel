<?php

namespace App\Enums;

class CategorieEnum
{
    const SOLUTIONS_ECOLOGIQUES = 'solutions-ecologiques';
    const ENERGIE_SOLAIRE = 'energie-solaire';
    const ENERGIE_EOLIENNE = 'energie-eolienne';
    const TRANSITION_ENERGETIQUE = 'transition-energetique';
    const CONSEILS_ECONOMIE_ENERGIE = 'conseils-economie-energie';
    const TECHNOLOGIES_VERTES = 'technologies-vertes';
    const POLITIQUES_REGLEMENTATIONS = 'politiques-reglementations';
    const STOCKAGE_ENERGIE = 'stockage-energie';
    const PROJETS_INNOVATIONS = 'projets-innovations';
    const CHAUFFAGE_CLIMATISATION_ECO = 'chauffage-climatisation-eco';
    const BATIMENTS_ENERGIES_RENOUVELABLES = 'batiments-energies-renouvelables';
    const MOBILITE_VERTE = 'mobilite-verte';
    const IMPACT_ENVIRONNEMENTAL = 'impact-environnemental';
    const FINANCEMENT_SUBVENTIONS = 'financement-subventions';

    public static function getValues()
    {
        return [
            self::SOLUTIONS_ECOLOGIQUES,
            self::ENERGIE_SOLAIRE,
            self::ENERGIE_EOLIENNE,
            self::TRANSITION_ENERGETIQUE,
            self::CONSEILS_ECONOMIE_ENERGIE,
            self::TECHNOLOGIES_VERTES,
            self::POLITIQUES_REGLEMENTATIONS,
            self::STOCKAGE_ENERGIE,
            self::PROJETS_INNOVATIONS,
            self::CHAUFFAGE_CLIMATISATION_ECO,
            self::BATIMENTS_ENERGIES_RENOUVELABLES,
            self::MOBILITE_VERTE,
            self::IMPACT_ENVIRONNEMENTAL,
            self::FINANCEMENT_SUBVENTIONS
        ];
    }
}
