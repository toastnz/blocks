<?php

namespace Toast\Blocks;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\RequiredFields;
use UncleCheese\Forms\ImageOptionsetField;
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
                DropdownField::create('BackgroundColour', 'Background Colour', singleton(self::class)->dbObject('BackgroundColour')->enumValues()),
                ImageOptionsetField::create('Width', 'Select a Width')
                    ->setSource([
                        'wide' => '/app/src/images/widths/wide.svg',
                        'standard' => '/app/src/images/widths/standard.svg',
                        'narrow' => '/app/src/images/widths/narrow.svg',
                        'very-narrow' => '/app/src/images/widths/very-narrow.svg'
                    ])->setImageWidth(100)->setImageHeight(100)
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
