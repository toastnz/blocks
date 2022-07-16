<?php

namespace Toast\Blocks;

use SilverStripe\Forms\LiteralField;
use UncleCheese\Forms\ImageOptionsetField;
use SilverStripe\Forms\GridField\GridField;
use Toast\Blocks\Items\ContentTabBlockItem;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class TabbedContentBlock extends Block
{
    private static $table_name = 'Blocks_TabbedContentBlock';

    private static $singular_name = 'Tabbed Content';

    private static $plural_name = 'Tabbed Content';

    private static $db = [
        'Width' => 'Enum("standard,wide,narrow,very-narrow", "standard")',
    ];

    private static $has_many = [
        'Tabs' => ContentTabBlockItem::class
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            if ($this->exists()) {
                $config = GridFieldConfig_RelationEditor::create(50);
                $config->addComponent(GridFieldOrderableRows::create('SortOrder'))
                    ->removeComponentsByType(GridFieldDeleteAction::class)
                    ->addComponent(new GridFieldDeleteAction())
                    ->removeComponentsByType(GridFieldAddExistingAutoCompleter::class);
                $gridField = GridField::create('Tabs', 'Tabs', $this->Tabs(), $config);

                $fields->addFieldsToTab('Root.Main', [
                    $gridField,
                    ImageOptionsetField::create('Width', 'Select a Width')
                        ->setSource([
                            'wide' => '/app/src/images/widths/wide.svg',
                            'standard' => '/app/src/images/widths/standard.svg',
                            'narrow' => '/app/src/images/widths/narrow.svg',
                            'very-narrow' => '/app/src/images/widths/very-narrow.svg'
                        ])->setImageWidth(100)->setImageHeight(100)
                ]);
            } else {
                $fields->addFieldToTab(
                    'Root.Main',
                    LiteralField::create('Notice', '<div class="message notice">Save this block to see more options.</div>')
                );
            }
        });

        return parent::getCMSFields();
    }
}
