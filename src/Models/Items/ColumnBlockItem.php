<?php

namespace Toast\Blocks\Items;

use SilverStripe\Forms\FieldList;
use Toast\Blocks\ColumnBlock;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class ColumnBlockItem extends BlockItem
{
    private static $table_name = 'Blocks_ColumnBlockItem';

    private static $db = [
        'SortOrder' => 'Int',
        'Content' => 'HTMLText'
    ];

    private static $has_one = [
        'Parent' => ColumnBlock::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab('Root.Main', [
            HTMLEditorField::create('Content', 'Content')
                ->setRows(5)
        ]);

        return $fields;
    }

}