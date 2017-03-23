<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'ExtensionName',
    'description' => '',
    'category' => 'template',
    'author' => 'Redkiwi',
    'author_email' => '',
    'state' => 'stable',
    'uploadFolder' => false,
    'clearCacheOnLoad' => true,
    'author_company' => 'Redkiwi',
    'version' => '7.6.0',
    'constraints' => [
        'depends' => [
            'typo3' => '6.2.0-7.99.99',
            'extbase' => '6.2.0-7.99.99',
        ],
        'conflicts' => [],
        'suggests' => []
    ],
    'autoload' => [
        'psr-4' => [
            'Redkiwi\\ExtensionName\\' => 'Classes',
        ],
    ],
];