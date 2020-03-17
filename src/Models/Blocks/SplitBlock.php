<?php

namespace Toast\Blocks;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HeaderField;
use Sheadawson\Linkable\Models\Link;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\FieldType\DBField;
use Sheadawson\Linkable\Forms\LinkField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class SplitBlock extends Block
{
    private static $table_name = 'Blocks_SplitBlock';

    private static $singular_name = 'Split Block';

    private static $plural_name = 'Split Blocks';

    private static $db = [
        'LeftContent'  => 'HTMLText',
        'RightContent' => 'HTMLText',
        'LeftHeading'  => 'Varchar(255)',
        'RightHeading' => 'Varchar(255)'
    ];

    private static $has_one = [
        'LeftImage'  => Image::class,
        'RightImage' => Image::class,
        'LeftLink' => Link::class,
        'RightLink' => Link::class
    ];

    private static $owns = [
        'LeftImage',
        'RightImage'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab('Root.Left', [ 
            HeaderField::create('', 'Left Block'),
            TextField::create('LeftHeading', 'Heading'),
            HTMLEditorField::create('LeftContent', 'Content'),
            LinkField::create('LeftLinkID', 'Link'),
            UploadField::create('LeftImage', 'Image')
                ->setFolderName('Uploads/Blocks')
                ->setDescription('Ideal size: 400x400')
        ]);

        $fields->addFieldsToTab('Root.Right', [
            HeaderField::create('', 'Right Block'),
            TextField::create('RightHeading', 'Heading'),
            HTMLEditorField::create('RightContent', 'Content'),
            LinkField::create('RightLinkID', 'Link'),
            UploadField::create('RightImage', 'Image')
                ->setFolderName('Uploads/Blocks')
                ->setDescription('Ideal size: 400x400')
        ]);

        return $fields;
    }

    public function getContentSummary()
    {
        return DBField::create_field(DBHTMLText::class, $this->LeftContent . ' ' . $this->RightContent);
    }

    public function getCMSValidator()
    {
        return new RequiredFields(['LeftContent', 'RightContent']);
    }
}