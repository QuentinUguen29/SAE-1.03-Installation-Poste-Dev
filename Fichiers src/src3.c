/**
 * \file src3.c
 * \brief Cacule la pollution emise de deux carburants 
 * 
 * Ce programme calcule la quantité de pollution émise
 * par deux carburants en entrant la quantité en litres 
*/


#include <stdio.h>
#include <stdlib.h>

// Définition des structures
/**
 * @brief Structure du carburant1
 */
struct Carburant1 {
    float quantite;             /**< Quantité du carburant 1 */
    float pourcentagePollution; /**< Le pourcentage de pollution du carburant 1 */
};

/**
 * @brief Structure du carburant2
 */
struct Carburant2 {
    float quantite;             /**< Quantité du carburant 2 */
    float pourcentagePollution; /**< Le pourcentage de pollution du carburant 2 */
};

// Définition des variables globales

float pollutionCarburant1 = 2.3 ; /** Pourcentage de pollution par litre d'essence */
float pollutionCarburant2 =  2.67 ; /** Pourcentage de pollution par litre de diesel */ 

// Définition des constantes

#define MAX_QUANTITE_1 1000 /** Quantité maximale pour l'essence */ 
#define MAX_QUANTITE_2 800  /** Quantité maximale pour le diesel */ 


// Prototypes

float pourcentagePollutionCarburant1(float quantiteCarburant1);

float pourcentagePollutionCarburant2(float quantiteCarburant2);

/**
 * @brief Programme principal.
 * @details Demande d'entrer la consommation des deux carburants puis affiche le résultat.
 * @return EXIT_SUCCESS si le programme s'effectue correctement.
 */
int main() {
    // Utilisation des structures pour stocker les données
    struct Carburant1 essence;
    struct Carburant2 diesel;

    // Entrée des quantités de carburants
    printf("Quantite d'essence consommée (en litres) : ");
    scanf("%f", &essence.quantite);

    printf("Quantite de diesel consommé (en litres) : ");
    scanf("%f", &diesel.quantite);

    // Calcul et affichage du pourcentage de pollution pour chaque carburant
    float pourcentageEssence = pourcentagePollutionCarburant1(essence.quantite);
    float pourcentageDiesel = pourcentagePollutionCarburant2(diesel.quantite);

    printf("La quantité de pollution pour l'essence est de %.2f kilos de CO2 \n", pourcentageEssence);
    printf("La quantité de pollution pour le diesel est de %.2f kilos de CO2 \n", pourcentageDiesel);

    return EXIT_SUCCESS;
}

/**
 * @brief Calcul de la pollution de carburant 1.
 * @details Cette fonction calcule la pollution de l'essence, et retourne une valeur, en kg/CO2
 * @param quantiteCarburant1 Quantité du carburant 1 consommée.
 * @return Le pourcentage de pollution en kg/CO2.
 */
float pourcentagePollutionCarburant1(float quantiteCarburant1) {
    return (quantiteCarburant1 / MAX_QUANTITE_1) * pollutionCarburant1 * 100; 
}

/**
 * @brief Calcul de la pollution de carburant 2.
 * @details Cette fonction calcule la pollution du diesel, et retourne une valeur, en kg/CO2
 * @param quantiteCarburant2 Quantité du carburant 2 consommée.
 * @return Le pourcentage de pollution en kg/CO2.
 */
float pourcentagePollutionCarburant2(float quantiteCarburant2) {
    return (quantiteCarburant2 / MAX_QUANTITE_2) * pollutionCarburant2 * 100; 
}

