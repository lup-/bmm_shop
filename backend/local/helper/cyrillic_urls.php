<?php

function transliterate($cyrillicText = null, $latinText = null) {
    $cyr = [
        'ё', 'ы', 'ж', 'х', 'ц', 'ч', 'щ', 'ш', 'ъ', 'э', 'ю', 'я', 'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'ь',
        'Ё', 'Ы', 'Ж', 'Х', 'Ц', 'Ч', 'Щ', 'Ш', 'Ъ', 'Э', 'Ю', 'Я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Ь'
    ];

    $lat = [
        'yo', 'yi', 'zh', 'kh', 'ts', 'ch', 'shh', 'sh', "''", 'eh', 'yu', 'ya', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', "'",
        'Yo', 'Yi', 'Zh', 'Kh', 'Ts', 'Ch', 'Shh', 'Sh', "''", 'Eh', 'Yu', 'Ya', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', "'"
    ];

    if ($cyrillicText) {
        return str_replace($cyr, $lat, $cyrillicText);
    }
    else if ($latinText) {
        return str_replace($lat, $cyr, $latinText);
    }
    else {
        return null;
    }
}

function encodePart($part, $useMargins = true) {
    $translit = transliterate($part);
    return $useMargins ? "ru_${translit}_" : $translit;
}

function decodePart($part, $detectEncode = true) {
    if ($detectEncode && !isEncoded($part)) {
        return $part;
    }

    $part = preg_replace('#^ru_#', '', $part);
    $part = preg_replace('#_$#', '', $part);

    return transliterate(null, $part);
}

function encodeCyrillicUrl($url, $useMargins = true) {
    $encodedUrl = $url;

    $hasMatches = preg_match_all('#[абвгдеёжзийклмнопрстуфхцчшщъыьэюя]+#iu', $url, $matches);
    if ($hasMatches) {
        foreach ($matches[0] as $srcText) {
            $encodedUrl = str_replace( $srcText, encodePart($srcText, $useMargins), $encodedUrl );
        }
    }

    return $encodedUrl;
}

function decodeCyrillicUrl($url) {
    $decodedUrl = $url;

    $hasMatches = preg_match_all('#ru_.*?_#iu', $url, $matches);
    if ($hasMatches) {
        foreach ($matches[0] as $srcText) {
            $decodedUrl = str_replace( $srcText, decodePart($srcText), $decodedUrl );
        }
    }

    return $decodedUrl;
}

function isEncoded($value) {
    return preg_match('#ru_.*?_#i', $value) === 1;
}

function decodeCyrillicArray($array, $keys = []) {
    if (empty($keys)) {
        $keys = array_keys($array);
    }

    $decodedArray = [];
    foreach ($keys as $key) {
        $value = $array[$key];
        $decodedArray[$key] = decodePart($value);
    }

    return $decodedArray;
}

function decodeCyrillicGlobals($requestParams = []) {
    $_COOKIE = decodeCyrillicArray($_COOKIE, $requestParams);
    $_REQUEST = decodeCyrillicArray($_REQUEST, $requestParams);
    $_GET = decodeCyrillicArray($_GET, $requestParams);
    $_POST = decodeCyrillicArray($_POST, $requestParams);
    $_SESSION = decodeCyrillicArray($_SESSION, $requestParams);
    $_ENV = decodeCyrillicArray($_ENV, $requestParams);
}

function decodeRequestParams($requestParams = []) {
    foreach ($requestParams as $key) {
        if (isset($_GET[$key])) {
            $_GET[$key] = decodePart($_GET[$key], false);
        }

        if (isset($_POST[$key])) {
            $_POST[$key] = decodePart($_POST[$key], false);
        }

        if (isset($_REQUEST[$key])) {
            $_REQUEST[$key] = decodePart($_REQUEST[$key], false);
        }
    }
}