<?php

namespace Toast\Blocks;

use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;

class ImageTextBlock extends Block
{
    private static $table_name = 'Blocks_ImageTextBlock';

    private static $singular_name = 'Image & Text';

    private static $plural_name = 'Image & Text';

    private static $db = [
        'EnableParallax' => 'Boolean',
        'Content' => 'HTMLText',
        'Alignment' => 'Enum("standard,reversed", "standard")'
    ];

    private static $has_one = [
        'Image' => Image::class
    ];

    private static $owns = [
        'Image'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(['Image', 'EnableParallax', 'Alignment']);

        $fields->addFieldsToTab('Root.Main', [
            CheckboxField::create('EnableParallax', 'Enable Parallax'),
            DropdownField::create('Alignment', 'Alignment', [
                'reversed' => 'Text left, Image right',
                'standard' => 'Image left, Text right'
            ]),
            UploadField::create('Image', 'Image')->setFolderName('Uploads/Blocks')
        ]);

        return $fields;
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
        return new RequiredFields([Image::class, 'Content']);
    }
}
