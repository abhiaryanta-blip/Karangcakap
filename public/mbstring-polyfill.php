<?php

// Workaround untuk mbstring yang tidak tersedia
if (!function_exists('mb_split')) {
    function mb_split($pattern, $string, $limit = -1) {
        // Convert regex pattern to preg_split pattern
        $pattern = '#' . str_replace('#', '\#', $pattern) . '#';
        return preg_split($pattern, $string, $limit);
    }
}

if (!function_exists('mb_strlen')) {
    function mb_strlen($string) {
        return strlen($string);
    }
}

if (!function_exists('mb_substr')) {
    function mb_substr($string, $start, $length = null) {
        return substr($string, $start, $length);
    }
}

if (!function_exists('mb_strtolower')) {
    function mb_strtolower($string) {
        return strtolower($string);
    }
}

if (!function_exists('mb_strtoupper')) {
    function mb_strtoupper($string) {
        return strtoupper($string);
    }
}

if (!function_exists('mb_convert_case')) {
    define('MB_CASE_UPPER', 0);
    define('MB_CASE_LOWER', 1);
    define('MB_CASE_TITLE', 2);
    
    function mb_convert_case($string, $mode) {
        switch($mode) {
            case MB_CASE_UPPER: return strtoupper($string);
            case MB_CASE_LOWER: return strtolower($string);
            case MB_CASE_TITLE: return ucwords(strtolower($string));
            default: return $string;
        }
    }
}

