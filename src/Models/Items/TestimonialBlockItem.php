<?php

namespace Toast\Blocks\Items;

use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use Toast\Blocks\TestimonialBlock;
use SilverStripe\Security\Permission;
use SilverStripe\Forms\RequiredFields;

class TestimonialBlockItem extends BlockItem
{
    private static $table_name = 'Blocks_TestimonialBlockItem';

    private static $singular_name = 'Testimonial';

    private static $plural_name = 'Testimonials';

    private static $default_sort = 'SortOrder';

    private static $db = [
        'Testimonial' => 'Text',
        'Author' => 'Varchar(255)',
        'Description' => 'Varchar(512)',
        'SortOrder' => 'Int'
    ];

    private static $has_one = [
        'Parent' => TestimonialBlock::class
    ];

    private static $summary_fields = [
        'Testimonial' => 'Testimonial',
        'Author' => 'Author',
        'Description' => 'Description',
    ];


    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            $fields->addFieldsToTab('Root.Main', [
                TextareaField::create('Testimonial', 'Testimonial'),
                TextField::create('Author', 'Author'),
                TextField::create('Description', 'Description')
            ]);
        });

        return parent::getCMSFields();
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        if (!$this->SortOrder) {
            $max = (int)self::get()->filter(['ParentID' => $this->ParentID])->max('SortOrder');
            $this->setField('SortOrder', $max + 1);
        }
    }

    public function getCMSValidator()
    {
        $required = new RequiredFields(['Testimonial']);
        $this->extend('updateCMSValidator', $required);
        return $required;
    }

    public function canView($member = null)
    {
        if ($this->Parent()) {
            return $this->Parent()->canView($member);
        }
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canEdit($member = null)
    {
        if ($this->Parent()) {
            return $this->Parent()->canEdit($member);
        }
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canDelete($member = null)
    {
        if ($this->Parent()) {
            return $this->Parent()->canDelete($member);
        }
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canCreate($member = null, $context = [])
    {
        if ($this->Parent()) {
            return $this->Parent()->canCreate($member, $context);
        }
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }
}
