<?php

namespace Toast\Blocks;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use Axllent\FormFields\FieldType\VideoLink;
use Axllent\FormFields\Forms\VideoLinkField;
use SilverStripe\AssetAdmin\Forms\UploadField;

class VideoBlock extends Block
{
    private static $table_name = 'Blocks_VideoBlock';

    private static $singular_name = 'Video';

    private static $plural_name = 'Videos';

    private static $db = [
        'Caption' => 'Varchar(255)',
        'Video' => VideoLink::class,
        'Width' => 'Enum("standard,wide,narrow,very-narrow", "standard")'
    ];

    private static $has_one = [
        'Thumbnail' => Image::class
    ];

    private static $owns = [
        'Thumbnail'
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            $fields->addFieldsToTab('Root.Main', [
                TextField::create('Caption', 'Caption'),
                VideoLinkField::create('Video')
                    ->showPreview(500),
                UploadField::create('Thumbnail', 'Override default Thumbnail')
                    ->setFolderName('Uploads/Blocks')
                    ->setDescription('Will automatically use YouTube thumbnail if this image is not uploaded. Ideal size: 960x540'),
                DropdownField::create('Width', 'Width', singleton(self::class)->dbObject('Width')->enumValues()),
            ]);
        });

        return parent::getCMSFields();
    }

    public function getCMSValidator()
    {
        $required = new RequiredFields(['Video']);

        $this->extend('updateCMSValidator', $required);

        return $required;
    }

    public function getContentSummary()
    {
        return DBField::create_field(DBHTMLText::class, $this->Video);
    }
}
