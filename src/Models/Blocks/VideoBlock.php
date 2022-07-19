<?php

namespace Toast\Blocks;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use UncleCheese\Forms\ImageOptionsetField;
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
        'Width' => 'Enum("standard,wide,narrow,thin", "standard")'
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

            $fields->removeByName(['Caption', 'Video', 'Thumbnail', 'Width']);

            $fields->addFieldsToTab('Root.Main', [
                TextField::create('Caption', 'Caption'),
                VideoLinkField::create('Video')
                    ->showPreview(500),
                UploadField::create('Thumbnail', 'Override default Thumbnail')
                    ->setFolderName('Uploads/Blocks')
                    ->setDescription('Will automatically use YouTube thumbnail if this image is not uploaded. Ideal size: 960x540'),
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
