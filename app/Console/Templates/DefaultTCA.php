<?php
use Redkiwi\ExtensionName\Domain\Model\MODEL;

defined('TYPO3_MODE') or die ('Access denied.');

return call_user_func(function ($extension, $table) {
    $translation = 'LLL:EXT:' . $extension . '/Resources/Private/Language/Model/ModelName.xlf:' . $table;

    return [
        'ctrl' => [
            'title' => $translation . '.singular',
            'label' => 'name',
            'tstamp' => 'tstamp',
            'crdate' => 'crdate',
            'cruser_id' => 'cruser_id',
            'editlock' => 'editlock',
            'dividers2tabs' => true,
            'iconfile' => 'EXT:seh_template/Resources/Public/Icons/TCA/' . $table . '.png',
            'canNotCollapse' => true,
            'searchFields' => 'name'
        ],
        'interface' => [
            'showRecordFieldList' => 'name'
        ],
        'types' => [
            0 => [
                'showitem' => ''
            ]
        ],
        'palettes' => [
            ''
        ],
        'columns' => [
            // TCA fields
        ],
    ];
}, 'ext_key', MODEL::TABLE);
