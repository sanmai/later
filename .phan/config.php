<?php

use Phan\Issue;

return [
    'target_php_version' => '7.4',
    'backward_compatibility_checks' => false,
    'exclude_analysis_directory_list' => [
        'vendor/',
    ],
    'plugins' => [
        'AlwaysReturnPlugin',
        'DollarDollarPlugin',
        'DuplicateArrayKeyPlugin',
        'PregRegexCheckerPlugin',
        'PrintfCheckerPlugin',
        'UnreachableCodePlugin',
    ],
    'directory_list' => [
        'src/',
    ],
];
