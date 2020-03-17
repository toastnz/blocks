<?php

namespace Toast\Blocks\Items;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\TabSet;
use Toast\Blocks\GalleryBlock;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Security\Permission;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class GalleryImageItem extends BlockItem
{
    private static $table_name  = 'Blocks_GalleryImageItem';

    private static $singular_name = 'Gallery Image Item';

    private static $plural_name = 'Gallery Image Items';

    private static $default_sort  = 'SortOrder';

    private static $db = [
        'Title' => 'Text',
        'SortOrder' => 'Int',
    ];

    private static $has_one = [
        'Parent' => GalleryBlock::class,
        'GalleryImage' => Image::class
    ];

    private static $owns = [
        'GalleryImage'
    ];

    private static $summary_fields = [
        'Title' => 'Title',
        'GalleryImage.CMSThumbnail' => 'Image'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        
        $fields->addFieldsToTab('Root.Main', [
            TextField::create('Title', 'Title'),
            UploadField::create('GalleryImage', 'Image')
                ->setFolderName('Uploads/Blocks')
        ]);

        return $fields;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
    }

    public function getCMSValidator()
    {
        return new RequiredFields([
            Image::class
        ]);
    }

    public function canView($member = null)
    {
        if ($this->Parent()) {
            return $this->Parent()->canView($member);
        }
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canEdit($member = null)
    {
        if ($this->Parent()) {
            return $this->Parent()->canEdit($member);
        }
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canDelete($member = null)
    {
        if ($this->Parent()) {
            return $this->Parent()->canDelete($member);
        }
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canCreate($member = null, $context = [])
    {
        if ($this->Parent()) {
            return $this->Parent()->canCreate($member, $context);
        }
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }
}
