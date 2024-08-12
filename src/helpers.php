<?php

namespace PageTemplateManager;

if (!function_exists('str_ends_with')) {
    function str_ends_with(string $haystack, string $needle): bool
    {
        return strlen($needle) === 0 || substr($haystack, -strlen($needle)) === $needle;
    }
}