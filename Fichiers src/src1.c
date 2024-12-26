/**
 * @file src1.c
 * @brief Gestion des étudiants et des cours
 *
 * Ce programme en C illustre la gestion de données liées aux étudiants et aux cours.
 * Il utilise des structures pour représenter un étudiant et un cours, avec des fonctions
 * pour afficher les détails de chaque entité. Deux variables globales suivent le nombre
 * total d'étudiants et de cours, tandis que des constantes définissent les tailles maximales
 * des tableaux. Les détails des étudiants et des cours sont ensuite affichés dans la fonction principale.
 */

#include <stdio.h>

// Définition des structures


#define MAX_STUDENTS 100 /**Nombre maximal d'étudiants*/
#define MAX_COURSES 50   /**Nombre maximal de cours*/

/**
 * @brief Structure d'un étudiant
 */
struct Student {
    char name[50]; /**< Nom de l'étudiant*/
    int age;       /**< Âge de l'étudiant*/
};

/**
 * @brief Structure d'un cours
 */
struct Course {
    char courseName[50]; /**< Nom du cours*/
    int heure;           /**< Nombre dheure du cours*/
};

// Définition des variables globales

int totalStudents = 0; /**Nombre total d'étudiants*/
int totalCourses = 0;  /**Nombre total de cours*/

// Définition des constantes

// Prototypes
void displayStudent(struct Student s);
void displayCourse(struct Course c);

/**
 * @brief Programme principal
 * @return 0 si le programme s'exécute avec succès
 */
int main() {
    // Initialisation des étudiants
    struct Student students[MAX_STUDENTS] = {
        {"John Doe", 20},
        {"Jane Smith", 22}
        // Ajoutez d'autres étudiants ici...
    };

    // Initialisation des cours
    struct Course courses[MAX_COURSES] = {
        {"Introduction to Programming", 3},
        {"Data Structures", 4}
    };

    // Affichage des détails des étudiants
    for (int i = 0; i < totalStudents; ++i) {
        displayStudent(students[i]);
    }

    // Affichage des détails des cours
    for (int i = 0; i < totalCourses; ++i) {
        displayCourse(courses[i]);
    }

    return 0;
}

// Définition de la fonction d'affichage des détails d'un étudiant
/**
 * @brief Affiche les détails d'un étudiant
 * @details Affiche le nom de l'étudiant et son âge avec retour à la ligne après chaque info
 * @param s Structure représentant un étudiant
 */
void displayStudent(struct Student s) {
    printf("Student Name: %s\n", s.name);
    printf("Age: %d\n", s.age);
    printf("\n");
}

// Définition de la fonction d'affichage des détails d'un cours

/**
 * @brief Affiche les détails d'un cours
 * @details Affiche le nom du cours et le nombre d'heure correspondant, avec un retour à la ligne après chaque info
 * @param c Structure représentant un cours
 */
void displayCourse(struct Course c) {
    printf("Course Name: %s\n", c.courseName);
    printf("Credits: %d\n", c.heure);
    printf("\n");
}