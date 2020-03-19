<?php
/**
 *  Nettoyage d'une chaîne de caractère
 * @param string $str : chaîne de caractère à nettoyer
 * @return string $str : chaîne de caractère nettoyée
 */
function cleaner($str)
{
    // Passe en minuscule et Supprime tous les tags
    $str = strtolower(strip_tags($str));

    // Définie les caractères à remplacer avec leur équialent dans un tableau
    $needles = [
        'à' => 'a',
        'á' => 'a',
        'â' => 'a',
        'ä' => 'a',
        'è' => 'e',
        'é' => 'e',
        'ê' => 'e',
        'ë' => 'e',
        'ì' => 'i',
        'í' => 'i',
        'î' => 'i',
        'ï' => 'i',
        'ò' => 'o',
        'ó' => 'o',
        'ô' => 'o',
        'ö' => 'o',
        'ù' => 'u',
        'ú' => 'u',
        'û' => 'u',
        'ü' => 'u',
        'µ' => 'u',
        'ç' => 'c',
        'ñ' => 'n',
        'œ' => 'oe',
    ];

    // On remplace ces caractères
    $str = strtr($str, $needles);

    // On remplace tous les caractères non alpha-numérique (espace, _, !, ?, etc.) par des "-"
    $str = preg_replace('#[^A-Za-z0-9]+#', '-', $str);

    // Supprime les "-" en début et fin de chaîne
    $str = trim($str, '-');

    return $str;
}

/**
 *  Suppression de certaines balises HTML
 * @param string $str      : chaîne de caractère à nettoyer
 * @param string $charlist : balises supplémentaires à conserver
 * @param bool   $replace  : Si true remplace les balises sinon on les concatène avec les autres
 * @return string : Chaîne de caractère nettoyée
 */
function simplify($str, $charlist = '', $replace = false)
{
    // Si la variable vaut 'none', on autorise aucune balise
    if ($charlist !== 'none') :
        if ($replace) :
            $allowableTags = (!empty($charlist)) ? $charlist : '';
        else :
            $allowableTags = '<br>, <strong>, <em>, <sup>, <sub>, <span>';
            $allowableTags .= (!empty($charlist)) ? ' ' . $charlist : '';
        endif;
    else :
        $allowableTags = '';
    endif;

    return trim(strip_tags($str, $allowableTags));
}

/**
 * Coupe une chaîne de caractère
 * @param string $str : chaîne de caractère à couper
 * @param int    $max : nombre de caractères à conserver
 * @param string $end : marqueur de chaîne coupée
 * @return string : Chaîne de caractère coupée
 */
function truncate($str, $max = 25, $end = '(...)')
{
    if (strlen($str) >= $max) :
        // Met la portion de chaine dans $str
        $str = substr($str, 0, $max);

        // Cherche la position du dernier espace
        $space = strrpos($str, ' ');

        // Coupe de nouveau la chaine au niveau de l'espace s'il existe
        $str = ($space) ? substr($str, 0, $space) : $str;

        // Indique que la chaîne a été coupée
        $str .= ' ' . $end;
    endif;

    return $str;
}
