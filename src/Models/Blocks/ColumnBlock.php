<?php

namespace Toast\Blocks;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use Toast\Model\ColumnBlockItem;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class ColumnBlock extends Block
{
    private static $table_name = 'Blocks_ColumnBlock';

    private static $singular_name = 'Column';

    private static $plural_name = 'Columns';

    private static $db = [
        'Heading' => 'Varchar(255)',
        'ContentLeft' => 'HTMLText',
        'ContentMiddle' => 'HTMLText',
        'ContentRight' => 'HTMLText'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab('Root.Main', [
            TextField::create('Heading', 'Heading'),
            HTMLEditorField::create('ContentLeft', 'Content Left')
                ->setRows(15),
            HTMLEditorField::create('ContentMiddle', 'Content Middle')
                ->setRows(15),
            HTMLEditorField::create('ContentRight', 'Content Right')
                ->setRows(15)
        ]);

        return $fields;
    }

    public function getColumns()
    {
        $columns = 0;
        
        if ($this->ContentLeft !== '') {
            $columns++;
        };
        if ($this->ContentMiddle !== '') {
            $columns++;
        };
        if ($this->ContentRight !== '') {
            $columns++;
        };
        return $columns;
    }

}