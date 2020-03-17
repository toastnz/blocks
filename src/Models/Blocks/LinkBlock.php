<?php

namespace Toast\Blocks;

use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use Toast\Blocks\Items\LinkBlockItem;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;

class LinkBlock extends Block
{
    private static $table_name = 'Blocks_LinkBlock';

    private static $singular_name = 'Link';

    private static $plural_name = 'Links';

    private static $db = [
        'Heading' => 'Varchar(255)',
        'Content' => 'HTMLText',
        'Columns' => 'Enum("2, 3, 4", "2")'
    ];

    private static $has_many = [
        'Items' => LinkBlockItem::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab('Root.Main', [
            TextField::create('Heading', 'Heading'),
            HTMLEditorField::create('Content', 'Content')
                ->setRows(15),
            DropdownField::create('Columns', 'Columns', singleton('Toast\Blocks\LinkBlock')->dbObject('Columns')->enumValues()),
        ]);

        if ($this->ID) {
            $linkConfig = GridFieldConfig_RelationEditor::create(10);
            $linkConfig->addComponent(GridFieldOrderableRows::create('SortOrder'))
                ->removeComponentsByType(GridFieldDeleteAction::class)
                ->addComponent(new GridFieldDeleteAction(false))
                ->removeComponentsByType('GridFieldAddExistingAutoCompleter');
    
            $linkBlockGridField = GridField::create(
                'Items',
                'Link Block Items',
                $this->owner->Items(),
                $linkConfig
            );    
            $fields->addFieldToTab('Root.Items', $linkBlockGridField);
        }

        return $fields;
    }
}