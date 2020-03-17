<?php
namespace Toast\Blocks\Items;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
use Toast\Blocks\TestimonialBlock;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\FieldType\DBField;

class TestimonialBlockItem extends BlockItem
{
    private static $table_name = 'Blocks_TestimonialBlockItem';

    private static $db = [
        'SortOrder' => 'Text',
        'Title' => 'Varchar(255)',
        'Location' => 'Varchar(100)',
        'Testimonial' => 'Text'
    ];

    private static $has_one = [
        'Parent' => TestimonialBlock::class
    ];

    private static $summary_fields = [
        'Title' => 'Name',
        'ContentSummary' => 'Testimonial',
        'Location' => 'Location'
    ];

    public function getCMSFields()
    {        
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab('Root.Main', [
            TextField::create('Title', 'Name'),
            TextField::create('Location', 'Location'),
            TextareaField::create('Testimonial', 'Testimonial')
        ]);

        return $fields;
    }

    public function getContentSummary()
    {
        return $this->dbObject('Testimonial')->LimitCharacters(100);
    }

}
