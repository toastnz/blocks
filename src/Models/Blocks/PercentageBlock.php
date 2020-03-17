<?php

namespace Toast\Blocks;

use SilverStripe\Assets\Image;
use SilverStripe\View\ArrayData;
use SilverStripe\Forms\TextField;
use Sheadawson\Linkable\Models\Link;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\ORM\FieldType\DBField;
use Sheadawson\Linkable\Forms\LinkField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class PercentageBlock extends Block
{
    private static $table_name = 'Blocks_PercentageBlock';
    
    private static $singular_name = 'Percentage';

    private static $plural_name = 'Percentages';
    
    private static $db = [
        'Size' => 'Enum("33/66,50/50,66/33","50/50")',
        'LeftContent'  => 'HTMLText',
        'RightContent' => 'HTMLText',
        'FullWidth' => 'Boolean'
    ];

    private static $has_one = [
        'LeftImage' => Image::class,
        'RightImage' => Image::class,
        'DefaultImage' => Image::class,
        'LeftLink' => Link::class,
        'RightLink' => Link::class
    ];

    private static $owns = [
        'LeftImage',
        'RightImage',
        'DefaultImage'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab('Root.Main', [
            OptionsetField::create('Size', 'Size', [
                '33/66' => '33/66',
                '50/50' => '50/50',
                '66/33' => '66/33'
            ]),
            CheckboxField::create('FullWidth', 'Extend to use full width'),
            UploadField::create('DefaultImage', 'Default Background Image')
                ->setFolderName('Uploads/Blocks')
        ]);

        $fields->addFieldsToTab('Root.Left', [
            HTMLEditorField::create('LeftContent', 'Content'),
            UploadField::create('LeftImage', 'Background Image')
                ->setFolderName('Uploads/Blocks'),
            LinkField::create('LeftLinkID', 'Link')
        ]);

        $fields->addFieldsToTab('Root.Right', [
            HTMLEditorField::create('RightContent', 'Content'),
            UploadField::create('RightImage', 'Background Image')
                ->setFolderName('Uploads/Blocks'),
            LinkField::create('RightLinkID', 'Link')
        ]);

        return $fields;
    }

    public function getWidth($side)
    {
        switch ($this->Size) {
            case '50/50':
            default:
                $left = '6';
                $right = '6';
                break;
            case '33/66':
                $left = '4';
                $right = '8';
                break;
            case '66/33':
                $left = '8';
                $right = '4';
                break;
        }

        if ($side == 'left') {
            return $left;
        } else {
            return $right;
        }
    }

    public function getRightBackgroundImageURL()
    {
        if ($this->RightImage()->exists()) {
            return $this->RightImage()->URL;
        }
        return false;
    }

    public function getLeftBackgroundImageURL()
    {
        if ($this->LeftImage()->exists()) {
            return $this->LeftImage()->URL;
        }
        return false;
    }

    public function getLeft()
    {
        return ArrayData::create([
            'Content' => DBField::create_field(DBHTMLText::class, $this->LeftContent),
            'Image' => $this->LeftImage,
            'Size' => $this->getWidth('left'),
            'Link' => $this->LeftLink
        ]);
    }

    public function getRight()
    {
        return ArrayData::create    ([
            'Content' => DBField::create_field(DBHTMLText::class, $this->RightContent),
            'Image' => $this->RightImage,
            'Size' => $this->getWidth('right'),
            'Link' => $this->RightLink
        ]);
    }
}