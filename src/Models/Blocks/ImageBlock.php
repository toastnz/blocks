<?php

namespace Toast\Blocks;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use UncleCheese\Forms\ImageOptionsetField;
use SilverStripe\AssetAdmin\Forms\UploadField;

class ImageBlock extends Block
{
    private static $table_name = 'Blocks_ImageBlock';

    private static $singular_name = 'Image';

    private static $plural_name = 'Images';

    private static $db = [
        'Caption' => 'Text',
        'Width' => 'Enum("standard,wide,narrow,very-narrow", "standard")'
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
                TextField::create('Caption', 'Caption')
                    ->setDescription('Optional caption for this image'),
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
        $content = '';

        if ($this->Image() && $this->Image()->exists()) {
            $content = $this->Image()->Fit(300, 150)->forTemplate();
        }
        return DBField::create_field(DBHTMLText::class, $content);
    }

    public function getCMSValidator()
    {
        $required = new RequiredFields([Image::class]);
        $this->extend('updateCMSValidator', $required);
        return $required;
    }
}
