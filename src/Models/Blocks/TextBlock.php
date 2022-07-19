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
        'BackgroundColour' => 'Enum("white,off-white,primary", "white")',
        'Width' => 'Enum("standard,wide,narrow,thin", "standard")'
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            $fields->removeByName(['Content', 'BackgroundColour', 'Width']);

            $fields->addFieldsToTab('Root.Main', [
                HTMLEditorField::create('Content', 'Content'),
                DropdownField::create('BackgroundColour', 'Background Colour', singleton(self::class)->dbObject('BackgroundColour')->enumValues()),
                ImageOptionsetField::create('Width', 'Select a Width')
                    ->setSource([
                        'wide' => '/app/src/images/widths/wide.svg',
                        'standard' => '/app/src/images/widths/standard.svg',
                        'narrow' => '/app/src/images/widths/narrow.svg',
                        'thin' => '/app/src/images/widths/thin.svg'
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
