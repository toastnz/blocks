<?php

namespace Toast\Blocks;

use SilverStripe\Forms\TextField;
use SilverStripe\Blog\Model\BlogPost;
use Toast\Blocks\Items\NewsBlockItem;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;

class NewsBlock extends Block
{
    private static $table_name = 'Blocks_NewsBlock';
    
    private static $singular_name = 'News';
    
    private static $plural_name = 'News';

    private static $db = [
        'Content' => 'HTMLText'
    ];

    private static $has_many = [
        'Items' => NewsBlockItem::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab('Root.Main', [
            HTMLEditorField::create('Content', 'Content')
        ]);

        if ($this->ID) {
            $itemConfig = GridFieldConfig_RelationEditor::create(10);
            $itemConfig->addComponent(GridFieldOrderableRows::create('SortOrder'))
                ->removeComponentsByType(GridFieldDeleteAction::class)
                ->addComponent(new GridFieldDeleteAction(false))
                ->removeComponentsByType('GridFieldAddExistingAutoCompleter');
    
            $gridField = GridField::create('Items', 'News Items', $this->owner->Items(), $itemConfig);

            $fields->addFieldToTab('Root.Items', $gridField);
        }

        return $fields;
    }


}