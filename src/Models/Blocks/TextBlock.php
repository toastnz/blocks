<?php

namespace Toast\Blocks;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class TextBlock extends Block
{
    private static $table_name = 'Blocks_TextBlock';

    private static $singular_name = 'Text';

    private static $plural_name = 'Text';

    private static $db = [
        'Content' => 'HTMLText',
        'Width' => 'Enum("standard,wide,narrow,very-narrow", "standard")',
        'BackgroundColour' => 'Enum("white,off-white,primary", "white")'
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            $fields->addFieldsToTab('Root.Main', [
                HTMLEditorField::create('Content', 'Content'),
                DropdownField::create('Width', 'Width', singleton(self::class)->dbObject('Width')->enumValues()),
                DropdownField::create('BackgroundColour', 'Background Colour', singleton(self::class)->dbObject('BackgroundColour')->enumValues())
            ]);
        });

        return parent::getCMSFields();
    }

    public function getContentSummary()
    {
        return $this->dbObject('Content')->LimitCharacters(250);
    }

    public function getCMSValidator()
    {
        $required = new RequiredFields(['Content']);

        $this->extend('updateCMSValidator', $required);

        return $required;
    }
}
