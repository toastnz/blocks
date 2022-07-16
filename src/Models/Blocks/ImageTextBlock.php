<?php

namespace Toast\Blocks;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use UncleCheese\Forms\ImageOptionsetField;
use SilverStripe\AssetAdmin\Forms\UploadField;

class ImageTextBlock extends Block
{
    private static $table_name = 'Blocks_ImageTextBlock';

    private static $singular_name = 'Image & Text';

    private static $plural_name = 'Image & Text';

    private static $db = [
        'Content' => 'HTMLText',
        'Alignment' => 'Enum("standard,reversed", "standard")',
        'Width' => 'Enum("standard,wide,narrow,very-narrow", "standard")',
    ];

    private static $has_one = [
        'Image' => Image::class
    ];

    private static $owns = [
        'Image'
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            $fields->addFieldsToTab('Root.Main', [
                UploadField::create('Image', 'Image')
                    ->setFolderName('Uploads/Blocks'),
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
        return DBField::create_field(DBHTMLText::class, $this->Content)->Summary();
    }

    public function getCMSValidator()
    {
        $required = new RequiredFields([Image::class, 'Content']);
        $this->extend('updateCMSValidator', $required);
        return $required;
    }
}
