<?php

namespace Toast\Blocks;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use UncleCheese\Forms\ImageOptionsetField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Core\Manifest\ModuleResourceLoader;

class ImageTextBlock extends Block
{
    private static $table_name = 'Blocks_ImageTextBlock';

    private static $singular_name = 'Image & Text';

    private static $plural_name = 'Image & Text';

    private static $db = [
        'Content' => 'HTMLText',
        'Alignment' => 'Enum("standard,reversed", "standard")',
        'Width' => 'Enum("standard,wide,narrow,thin", "standard")',
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

            $fields->removeByName(['Image', 'Alignment', 'Width']);

            $fields->addFieldsToTab('Root.Main', [
                UploadField::create('Image', 'Image')
                    ->setFolderName('Uploads/Blocks'),
                DropdownField::create('Alignment', 'Alignment', singleton(self::class)->dbObject('Alignment')->enumValues()),
                ImageOptionsetField::create('Width', 'Select a Width')
                    ->setSource([
                        'wide' => ModuleResourceLoader::resourceURL('toastnz/blocks:images/widths/wide.svg'),
                        'standard' => ModuleResourceLoader::resourceURL('toastnz/blocks:images/widths/standard.svg'),
                        'narrow' => ModuleResourceLoader::resourceURL('toastnz/blocks:images/widths/narrow.svg'),
                        'thin' => ModuleResourceLoader::resourceURL('toastnz/blocks:images/widths/thin.svg')
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
