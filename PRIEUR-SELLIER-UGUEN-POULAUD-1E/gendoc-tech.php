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
        <?php
            class Comment{
                public $details;
                public $return;
                public $brief;
                public $params;
            }

            $configfile = fopen("config", "rw");
            if ($configfile)
            {
                while(($line = fgets($configfile)) !== false)
                {
                    if (preg_match('/CLIENT=(?<ClientName>.*)/', $line, $matches))
                    {
                        $clientname = $matches['ClientName'];
                    }
                    elseif (preg_match('/PRODUIT=(?<ProductName>.*)/', $line, $matches))
                    {
                        $productname = $matches['ProductName'];
                    }
                    elseif (preg_match('/VERSION=(?<Version>.*)/', $line, $matches))
                    {
                        $version = $matches['Version'];
                    }
                }
            }
        ?>
        <h1 class="head">Documentation Technique d'une <?php echo $productname; ?></h1>
        <h2 class="head">Bonjour <?php echo $clientname; ?></h2>
        <h3 class="head">Le produit est la version <?php echo $version; ?></h3>
    </header>
    <main>
        <?php
            $c_files = glob('*.c');
            foreach($c_files as $file)
            {
        ?>
        <section class="code-source">
            <?php
                $inComment = false;
                $inEntete = false;
                $currentStruct = NULL;
                $Comment = NULL;
                $entete = NULL;
                $macros = NULL;
                $references = NULL;
                $macros = NULL;
                $fonctions = NULL;
                $varGlob = NULL;
                $structs = NULL;

                $c_file = fopen($file, "r");
                if ($c_file)
                {
                    while(($line = fgets($c_file)) !== false)
                    {
                        $line = rtrim($line);
                        if ($line == "/**" && is_null($entete))
                        {
                            $inEntete = true;
                        }
                        elseif ($inEntete) {
                            if (substr($line, -2) == "*/") {
                                $inEntete = false;
                            }
                            else if (substr($line,3,1) != "@" && substr($line,3,1) != "\\") {
                                $entete = $entete . ' ' . substr($line,3); 
                            }
                        }
                        elseif (preg_match('/(?<ReferenceName>#include .*)/', $line, $matches)) {
                            $references[] = $matches['ReferenceName'];
                        }
                        elseif (preg_match('/(?<MacroName>#define [^\/\n]*)( *\/\*\**(?<MacroComment>.*)\*\/)*/', $line, $matches)) {
                            if (array_key_exists('MacroComment', $matches)) {
                                $macros[$matches['MacroName']] = $matches['MacroComment'];
                            }
                            else
                            {
                                $macros[$matches['MacroName']] = '';
                            }
                        }
                        elseif ($line == "/**" && is_null($Comment))
                        {
                            $inComment = true;
                        }
                        elseif ($inComment) {
                            if (is_null($Comment)) {
                                $Comment = new Comment();
                            }
                            if (substr($line, -2) == "*/") {
                                $inComment = false;
                            }
                            else if (preg_match('/[@\\\]brief (?<Brief>.*)/', $line, $matches)) {
                                $Comment->brief = $matches['Brief'];
                            }
                            else if (preg_match('/[@\\\]return (?<Return>.*)/', $line, $matches)) {
                                $Comment->return = $matches['Return'];
                            }
                            else if (preg_match('/[@\\\]details (?<Details>.*)/', $line, $matches)) {
                                $Comment->details = $matches['Details'];
                            }
                            else if (preg_match('/[@\\\]param (?<ParamName>[^\s]*) *(?<ParamComment>.*)/', $line, $matches)) {
                                $Comment->params[$matches['ParamName']] = $matches['ParamComment'];
                            }
                        }
                        elseif (preg_match('/(?<Fonction>.* .*\([^\)]*\))/', $line, $matches) &&
                                !is_null($Comment)) {
                            $fonctions[$matches['Fonction']] = $Comment;
                            $Comment = NULL;
                        }
                        elseif (preg_match('/(?<VarGlobDef>[^\s]* [^\s]* *= *[^\s]*) *;[\s]*\/\*+(?<VarGlobComment>[^\*]*)\*\//', $line, $matches)) {
                            $varGlob[$matches['VarGlobDef']] = $matches['VarGlobComment'];
                        }
                        elseif (preg_match('/struct +(?<StructName>[^\s]*)/', $line, $matches) && !is_null($Comment))
                        {
                            $currentStruct = $matches['StructName'];
                            $structs[$matches['StructName']] = $Comment;
                            $Comment = NULL;
                        }
                        elseif ($currentStruct != "") {
                            if (trim($line) == "};") {
                                $currentStruct = "";
                            }
                            else if (preg_match('/(?<Field>[^\n\/]*?); *\/\*+< *(?<FieldComment>[^\*]*)\*\//', $line, $matches)) {
                                $structs[$currentStruct]->params[$matches['Field']] = $matches['FieldComment'];  
                            }
                        }
                    }
                }
                if ($entete == "")
                {
                    continue;
                }
            ?>
            <h3>Documentation du fichier <?php echo $file; ?> </h3>
            <hr>
            <h2>Programme</h2>
            <p> <?php echo $entete; ?> </p>

            <section>
                <h4>Référence</h4>
                <?php
                    foreach ($references as $reference) {
                        echo '<p>' . htmlentities($reference) . '</p>';
                    }   
                ?>
            </section>

            <?php
                if (!is_null($macros)) {
                    echo '<h4>Macro</h4>';

                    foreach (array_keys($macros) as $macro) {
                        echo '<p>' . $macro . '</p>';
                    }
                }
            ?>

            <h4>Fonctions</h4>
            <?php
                foreach ($fonctions as $fonctionName => $fonctionComment) {
                    echo '<h5>' . $fonctionName . '</h5>';
                    if (!is_null($fonctionComment->details)) {
                        echo '<p class="commentaire">' . $fonctionComment->details . '</p>';
                    }
                    else {
                        echo '<p class="commentaire">' . $fonctionComment->brief . '</p>';
                    }                    
                }
                
            ?>
        
            <section class="variable">
                <h4>Variables Globales</h4>
                <article>
                    <?php
                        foreach ($varGlob as $varGlobDef => $varGlobComment) {
                            echo '<h5>' . $varGlobDef . '</h5>';
                            echo '<div class="commentaire">' . $varGlobComment . '</div>';
                        }                      
                    ?>
                </article>
            </section>
            <section class="structure">
                
                <?php
                    if (!is_null($structs)) {
                        echo '<h4>Structures</h4>';
                        echo '<article>';
                
                        foreach ($structs as $structName => $structComment) {
                            echo '<h5>Structure ' . $structName . '</h5>';
                            echo '<div class="commentaire">' . $structComment->brief . '</div>';
                            echo '<table>
                                <thead>
                                    <tr>
                                        <th>Champ(s)</th>
                                        <th>Rôle</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                foreach ($structComment->params as $param => $comment) {
                                    echo '<tr>
                                            <td>' . $param . '</td>
                                            <td>' . $comment . '</td>
                                        </tr>';
                                }
                            echo '</tbody>
                            </table> <br>';
                        }

                        echo '</article>';
                    }
                ?>
            </section>  
            <hr>
            
            <?php
                if (!is_null($macros)) {
                    echo '<h3>Description détaillée</h3>';
                    echo '<h4>Documentation des Macros</h4>';

                    foreach (array_keys($macros) as $macro) {
                        echo '<h5>' . $macro . '</h5>';
                        if ($macros[$macro]) {
                            echo '<div class="commentaire">' . $macros[$macro] . '</div>';
                        }
                    }
                }
            ?>
            <h4>Documentation des fonctions</h4>
            <article>
                <?php
                    foreach ($fonctions as $fonctionName => $fonctionComment) {
                        echo '<h5>' . $fonctionName . '</h5>';
                        if (!is_null($fonctionComment->details)) {
                            echo '<p class="commentaire">' . $fonctionComment->details . '</p>';
                        }
                        else {
                            echo '<p class="commentaire">' . $fonctionComment->brief . '</p>';
                        }
                        if (!is_null($fonctionComment->params)) {
                            echo '<h6>Paramètres</h6>';
                            echo '<table>
                                <thead>
                                    <tr>
                                        <th>Paramètre(s)</th>
                                        <th>Rôle</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                foreach ($fonctionComment->params as $param => $comment) {
                                    echo '<tr>
                                            <td>' . $param . '</td>
                                            <td>' . $comment . '</td>
                                        </tr>';
                                }
                            echo '</tbody>
                            </table> <br>';
                        } 
                        if (!is_null($fonctionComment->return)){
                            echo '<h6>Renvoie</h6>
                            <p class="renvoie">' . $fonctionComment->return .'</p> <br>';
                        } 
                    }
                ?>
            </article>
        </section>
        <?php
                }
        ?>
    </main>
</body>
</html>