<?php

namespace Toast\Blocks;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\GridField\GridField;
use Toast\Blocks\Items\TestimonialBlockItem;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;

class TestimonialBlock extends Block
{
    private static $table_name = 'Blocks_TestimonialBlock';
    
    private static $singular_name = 'Testimonial';

    private static $plural_name = 'Testimonials';

    private static $db = [
        'ShowNameAndLocation' => 'Boolean'
    ];

    private static $has_many = [
        'Testimonials' => TestimonialBlockItem::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab('Root.Main', [
            CheckboxField::create('ShowNameAndLocation', 'Show attribution name and location')
        ]);

        if ($this->ID) {
            $itemConfig = GridFieldConfig_RelationEditor::create(10);
            $itemConfig->addComponent(GridFieldOrderableRows::create('SortOrder'))
                ->removeComponentsByType(GridFieldDeleteAction::class)
                ->addComponent(new GridFieldDeleteAction(false))
                ->removeComponentsByType('GridFieldAddExistingAutoCompleter');

            $gridField = GridField::create('Testimonials', 'Testimonials', $this->owner->Testimonials(), $itemConfig);
            $fields->addFieldToTab('Root.Testimonials', $gridField);
        }

        return $fields;
    }

    public function getContentSummary()
    {
        return DBField::create_field('HTMLText', $this->Testimonial);
    }

    public function getCMSValidator()
    {
        return new RequiredFields(['Testimonial']);
    }
}