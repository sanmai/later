<?php

use Phan\Issue;

return [
    'target_php_version' => '8.2',
    'backward_compatibility_checks' => false,
    'read_mixin_annotations' => false,
    'exclude_analysis_directory_list' => [
        'vendor/',
    ],
    'suppress_issue_types' => [
        'PhanCompatibleOverrideAttribute',
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
