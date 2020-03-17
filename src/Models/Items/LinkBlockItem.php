<?php

namespace Toast\Blocks\Items;

use Sheadawson\Linkable\Forms\LinkField;
use Sheadawson\Linkable\Models\Link;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use Toast\Blocks\LinkBlock;

class LinkBlockItem extends BlockItem
{
    private static $table_name = 'Blocks_LinkBlockItem';

    private static $db = [
        'SortOrder' => 'Int',
        'Title' => 'Varchar(255)',
    ];

    private static $has_one = [
        'Link' => Link::class,
        'Image' => Image::class,
        'Parent' => LinkBlock::class
    ];

    private static $summary_fields = [
        'Image.CMSThumbnail' => 'Thumbnail',
        'Title' => 'Title',
    ];
    private static $owns = [
        'Image'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab('Root.Main', [
            TextField::create('Title', 'Title'),
            LinkField::create('LinkID', 'Link'),
            UploadField::create('Image', 'Image')
                ->setDescription('Ideal size at least 510px * 510px')
                ->setFolderName('Uploads/Blocks')
        ]);

        return $fields;
    }

}