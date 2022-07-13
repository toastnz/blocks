<?php

namespace Toast\Blocks\Items;

use Toast\Blocks\LinkBlock;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;


class LinkBlockItem extends BlockItem
{
    private static $table_name = 'Blocks_LinkBlockItem';

    private static $db = [
        'SortOrder' => 'Int',
        'Title' => 'Varchar(255)',
        'Summary' => 'Text',
    ];

    private static $has_one = [
        'Link'   => Link::class,
        'Image'  => Image::class,
        'Icon'   => File::class,
        'Parent' => LinkBlock::class
    ];

    private static $summary_fields = [
        'Title' => 'Title',
    ];
    private static $owns = [
        'Icon',
        'Image',
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            $fields->addFieldsToTab('Root.Main', [
                UploadField::create('Icon', 'SVG Icon')
                    ->setAllowedExtensions(['svg'])
                    ->setFolderName('Uploads/Blocks'),
                UploadField::create('Image', 'Thumbnail')
                    ->setFolderName('Uploads/Blocks'),
                TextField::create('Title', 'Title'),
                TextareaField::create('Summary', 'Summary'),
                LinkField::create('Link', 'Link', $this),
            ]);

        });

        return parent::getCMSFields();
    }
}
