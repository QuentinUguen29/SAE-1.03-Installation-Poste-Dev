<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Md2HTML</title>
    <link rel="stylesheet" href="DOC_USER.css">
</head>
<body>
<main>

<?php
    function valideFermetureBalise(&$inList, &$inListItem, &$inPara, &$inTable){
        if ($inListItem) {
            echo '</li>';
            $inListItem = false;
        }
        if ($inList) {
            echo '</ul>';
            $inList = false;
        }
        elseif ($inTable) {
            echo '</tbody> </table>';
            $inTable = false;
        }
        elseif ($inPara) {
            echo '</p>';
            $inPara = false;
        }
    }
    
    $md_files = glob('*.md');
    foreach($md_files as $file)
    {
        $inList = false;
        $inListItem = false;
        $inTable = false;
        $inCode = false;
        $noCheck = false;
        $md_file = fopen($file, "r");
        if ($md_file)
        {
            while(($untrimmedLine = fgets($md_file)) !== false)
            {
                $line = trim($untrimmedLine);
                $line = preg_replace('/\<\/?(?<tag>(?!(?:b\>)|(?:i\>)|(?:em\>)|(?:\/em\>)|(?:\/i\>)|(?:\/b\>))[^\>]*)\>/', "", $line);
                $line = preg_replace('/\b(?<Email>[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,})\b/', '<address><a href="mailto:$1">$1</a></address>', $line);
                $line = preg_replace('/\[(?<TexteLien>[^]]*)\]\((?<URL>(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s|)]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s|)]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s|)]{2,}|www\.[a-zA-Z0-9]+\.[^\s|)]{2,}))\)/','<a href="$2">$1</a>', $line);
                if (strlen($line) == 0) {
                    valideFermetureBalise($inList, $inListItem, $inPara, $inTable);
                    if(!$inList && !$inTable && !$inPara) {
                        echo '<br>';
                    }
                }
                elseif (preg_match('/(?<HashTags>#+) *(?<Title>.*)/', $line, $matches)) {
                    $nb_hashtag = strlen($matches['HashTags']);
                    valideFermetureBalise($inList, $inListItem, $inPara, $inTable);                                
                    echo '<h' . $nb_hashtag . '>' . htmlentities($matches['Title']) . '</h' . $nb_hashtag . '>';
                }
                elseif (preg_match('/(?<InList>- ) *(?<Text>.*)/', $line, $matches)) {
                    valideFermetureBalise($noCheck, $inListItem, $inPara, $inTable);
                    if (!$inList) {
                        echo '<ul>';
                    }
                    $inList = true;
                    if (!$inListItem) {
                        echo '<li>';
                    }
                    $inListItem = true;                   
                    echo $matches['Text'];
                }
                elseif ($inListItem) {
                    echo ' ' . $line;
                }
                elseif ($inTable && preg_match('/^(?>\|:?\-:?)+\|$/', $line, $matches)) {
                    //Ne rien faire pour cette ligne
                } 
                elseif (preg_match('/^\|.*\|$/', $line, $matches)) {
                    valideFermetureBalise($inList, $inListItem, $inPara, $noCheck);
                    $cellType = 'td';
                    if (!$inTable) {
                        echo '<table> <thead>';
                        $cellType = 'th';
                    }
                    echo '<tr>';
                    $cells = explode("|", substr($line,1,strlen($line)-2));
                    foreach (array_values($cells) as $cell) {
                        echo '<' . $cellType . '>' . $cell . '</' . $cellType . '>';
                    }
                    echo '</tr>';
                    if (!$inTable) {
                        echo '</thead> <tbody>';
                    }
                    $inTable = true;
                }
                elseif (preg_match('/^`{3}$/', $line)) {
                    valideFermetureBalise($inList, $inListItem, $inPara, $inTable);
                    if (!$inCode) {
                        echo '<pre><code>';
                        $inCode = true;
                    }
                    else {
                        echo '</code> </pre>';
                        $inCode = false;
                    }
                }
                elseif ($inCode) {
                    echo substr($untrimmedLine, 0, strlen($untrimmedLine)-1);
                }
                elseif (!$inPara) {
                    valideFermetureBalise($inList, $inListItem, $noCheck, $inTable);
                    echo '<p>' . $line;
                    $inPara = true;
                }
                else {
                    echo $line;
                }
                echo "\n";
            } // Fin de la lecture des lignes d'un fichier md

            //Pour finir, on s'assure que toutes les balises soient fermées
            valideFermetureBalise($inList, $inListItem, $inPara, $inTable);
        }
?>
<?php
    }
?> 

</main>
</body>
</html>




