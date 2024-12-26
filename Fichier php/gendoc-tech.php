<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="DOC_TECHNIQUE.css">
    <title>Document Technique</title>
</head>
<body>
    <header>
        <h1 class="head">Documentation Technique d'une Machine à courber les bananes</h1>
        <h2 class="head">Bonjour Les Génies du Ponant</h2>
        <h3 class="head">Le produit est la version 2.7.4</h3>
    </header>
    <main>
        <?php
            $c_files = glob('*');
            foreach($c_files as $file)
            {
                echo $file . "\n";
            }
        ?>
        <section class="code-source">
            
            <h3>Documentation du fichier</h3>
            <hr>
            <h2>Programme</h2>
            <p>Ce programme en C illustre la gestion de données liées aux étudiants et aux cours. Il utilise des structures pour représenter un étudiant et un cours, avec des fonctions pour afficher les détails de chaque entité. Deux variables globales suivent le nombre total d'étudiants et de cours, tandis que des constantes définissent les tailles maximales des tableaux. Les détails des étudiants et des cours sont ensuite affichés dans la fonction principale.</p>

            <section>
                <h4>Référence du fichier src1.c</h4>
                <p>#include &lt;stdio.h&gt;</p>
            </section>

            <h4>Macro</h4>
            <p>#define MAX_STUDENTS 100</p>

            <h4>Fonctions</h4>
            <h5>displayStudent(struct Student s)</h5>
                <p class="commentaire">Affiche le nom de l'étudiant et son âge avec retour à la ligne après chaque info</p>
        
            <section class="variable">
                <h4>Variables Globales</h4>
                <article>
                    <h6>int totalStudents = 0;</h6>
                    <div class="commentaire">Nombre total d'étudiants</div>
                </article>
            </section>
            <section class="structure">
                <h4>Structures</h4>
                <article>
                    <h5>struct Student</h5>
                    <div><p>structure Student {<br>
                        char name[50];  <span class="commentaire">Nom de l'étudiant</span><br>
                        int age;        <span class="commentaire">Âge de l'étudiant</span><br>
                    };</p>
                </div>
                </article>
            </section>  
            <hr>
            <h3>Descriptions détaillée</h3>
            <h4>Documentation des Macros</h4>
            <h5>#define MAX_STUDENTS 100</h5>
                <div class="commentaire">Nombre maximal d'étudiants</div>


            <h4>Documentation des fonctions</h4>
            <article>
                <h5>void displayStudent(struct Student s)</h5>
                    <p class="commentaire">Affiche le nom de l'étudiant et son âge avec retour à la ligne après chaque info</p>
                <h4>Paramètres</h4>            
                <table>
                    <thead>
                        <tr>
                            <th>Paramètre(s)</th>
                            <th>Rôle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>s</td>
                            <td>Structure représentant un étudiant</td>
                        </tr>
                    </tbody>
                </table>
            </article>

            <article>
                <h5>int main()</h5>
                <p class="commentaire">Programme principal</p>
                <h6>Renvoie</h6>
                <p>0 si le programme s'exécute avec succès</p>
            </article>
        </section>
    </main>
</body>
</html>