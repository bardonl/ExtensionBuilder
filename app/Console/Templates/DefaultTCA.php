<?php
use Redkiwi\ExtensionName\Domain\Model\TestModel;

defined('TYPO3_MODE') or die ('Access denied.');

return call_user_func(function ($extension, $table) {
    $translation = 'LLL:EXT:' . $extension . '/Resources/Private/Language/Model/TestModel.xlf:' . $table;

    return [
        'ctrl' => [
            'title' => $translation . '.singular',
            'label' => 'name',
            'tstamp' => 'tstamp',
            'crdate' => 'crdate',
            'cruser_id' => 'cruser_id',
            'editlock' => 'editlock',
            'dividers2tabs' => true,
            'iconfile' => 'EXT:ExtensionName/Resources/Public/Icons/TCA/' . $table . '.png',
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
}, 'ext_key', TestModel::TABLE);
