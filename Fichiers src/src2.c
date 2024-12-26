/**
 * \file src2.c
 * \brief Affiche les informations d'une adresse et d'une personne
 * 
 * Ce programme crée une structure de données représentant une personne avec un nom, un âge et une 
 * adresse, ainsi qu'une structure représentant une adresse avec une rue et un code postal. 
 * Deux variables globales sont créées avec des valeurs initiales, et deux fonctions sont définies 
 * pour afficher les informations d'une personne et d'une adresse. Enfin, le programme principal 
 * utilise ces fonctions pour afficher les informations des variables globales.
*/

#include <stdio.h>

#define MAX_CHAR 50
#define MAX_ADRESSES 100

/**
 * @brief Structure représentant une adresse.
 */
struct Adresse {
    char rue[MAX_CHAR];       /**< Rue de l'adresse. */
    int codePostal;     /**< Code postal de l'adresse. */
};

/**
 * @brief Structure représentant une personne avec un nom, un âge et une adresse.
 */
struct Personne {
    char nom[MAX_CHAR];       /**< Nom de la personne. */
    int age;            /**< Âge de la personne. */
    struct Adresse adresse; /**< Adresse de la personne. */
};

// Déclaration des typedefs
typedef struct Adresse TypeAdresse; /**< Type de données pour une adresse. */
typedef struct Personne TypePersonne; /**< Type de données pour une personne. */

// Déclaration des variables globales
int personnesTotal = 0; /**Nombre total de personnes*/
int adressesTotal = 0; /**Nombres total d'adresses*/


void afficherPersonne(TypePersonne personne);
void afficherAdresse(TypeAdresse adresse);

int main() {
    TypePersonne personne;
    TypeAdresse adresse;
    // Utilisation des fonctions pour afficher les informations
    afficherPersonne(personne);
    afficherAdresse(adresse);

    printf("Nombre total de personnes : %d\n", personnesTotal);
    printf("Nombre total d'adresses : %d\n", adressesTotal);
    return 0;
}

// Définition de la fonction afficherPersonne
/**
 * @brief Affiche les informations d'une personne.
 * @param personne La personne dont les informations seront affichées.
 */
void afficherPersonne(TypePersonne personne) {
    printf("Nom: %s\n", personne.nom);
    printf("Age: %d\n", personne.age);
    printf("Adresse: %s, %d\n", personne.adresse.rue, personne.adresse.codePostal);
    personnesTotal++;
}

// Définition de la fonction afficherAdresse
/**
 * @brief Affiche les informations d'une adresse.
 * @param adresse L'adresse dont les informations seront affichées.
 */
void afficherAdresse(TypeAdresse adresse) {
    printf("Adresse: %s, %d\n", adresse.rue, adresse.codePostal);
    adressesTotal++;
}