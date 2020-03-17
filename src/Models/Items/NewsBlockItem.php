<?php

namespace Toast\Blocks\Items;

use Toast\Blocks\NewsBlock;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use Sheadawson\Linkable\Models\Link;
use SilverStripe\Forms\RequiredFields;
use Sheadawson\Linkable\Forms\LinkField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class NewsBlockItem extends BlockItem
{
    private static $table_name = 'Blocks_NewsBlockItem';

    private static $db = [
        'SortOrder' => 'Int',
        'Title' => 'Varchar(255)',
        'Content' => 'HTMLText',
    ];

    private static $has_one = [
        'Link' => Link::class,
        'Image' => Image::class,
        'Parent' => NewsBlock::class
    ];

    private static $summary_fields = [
        'Image.CMSThumbnail' => 'Thumbnail',
        'Title' => 'Title'
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
            HTMLEditorField::create('Content', 'Content')->setRows(5),
            UploadField::create('Image', 'Image')
                ->setDescription('Ideal size at least 510px * 510px')
                ->setFolderName('Uploads/Blocks')
        ]);


        return $fields;
    }

    public function getCMSValidator()
    {
        return new RequiredFields([
            'Title',
            'LinkID'
        ]);
    }

}