<?php

namespace Toast\Blocks;

use Toast\Blocks\Block;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\TextField;
use Toast\Blocks\Items\TestimonialBlockItem;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class TestimonialBlock extends Block
{
    private static $table_name = 'Blocks_TestimonialBlock';

    private static $singular_name = 'Testimonial';

    private static $plural_name = 'Testimonials';

    private static $db = [
        'Heading' => 'Varchar(255)'
    ];

    private static $has_many = [
        'Items' => TestimonialBlockItem::class
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            $fields->removeByName('Items');

            $fields->addFieldsToTab('Root.Main', [
                TextField::create('Heading', 'Heading')
            ]);

            if ($this->exists()) {                
                $linkConfig = GridFieldConfig_RelationEditor::create(10);
                $linkConfig->addComponent(GridFieldOrderableRows::create('SortOrder'))
                    ->removeComponentsByType(GridFieldDeleteAction::class)
                    ->addComponent(new GridFieldDeleteAction(false))
                    ->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
                
                $fields->addFieldsToTab('Root.Main', [
                    GridField::create('Items', 'Testimonials', $this->Items(), $linkConfig)
                ]);
            }
        });

        return parent::getCMSFields();
    }
}
