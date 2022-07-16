<?php

namespace Toast\Blocks;

use Toast\Blocks\Block;
use SilverStripe\Forms\DropdownField;
use Toast\Blocks\Items\LinkBlockItem;
use UncleCheese\Forms\ImageOptionsetField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;

class LinkBlock extends Block
{
    private static $table_name = 'Blocks_LinkBlock';

    private static $singular_name = 'Link';

    private static $plural_name = 'Links';

    private static $db = [
        'Columns' => 'Enum("2, 3, 4", "3")',
        'Width' => 'Enum("standard,wide,narrow,very-narrow", "standard")',
    ];

    private static $has_many = [
        'Items' => LinkBlockItem::class
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            $fields->removeByName('Items');

            $fields->addFieldsToTab('Root.Main', [
                DropdownField::create('Columns', 'How many columns across', singleton('Toast\Blocks\LinkBlock')->dbObject('Columns')->enumValues()),
                ImageOptionsetField::create('Width', 'Select a Width')
                    ->setSource([
                        'wide' => '/app/src/images/widths/wide.svg',
                        'standard' => '/app/src/images/widths/standard.svg',
                        'narrow' => '/app/src/images/widths/narrow.svg',
                        'very-narrow' => '/app/src/images/widths/very-narrow.svg'
                    ])->setImageWidth(100)->setImageHeight(100)
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
                $fields->addFieldToTab('Root.Main', $linkBlockGridField);
            }
        });

        return parent::getCMSFields();
    }
}
