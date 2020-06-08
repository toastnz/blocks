<?php

namespace Toast\Blocks;

use SilverStripe\Dev\Debug;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\RequiredFields;
use DorsetDigital\SimpleInstagram\InstagramHelper;

class InstagramFeedBlock extends Block
{

    private static $table_name = 'Blocks_InstagramFeedBlock';

    private static $singular_name = 'Instagram Feed';

    private static $plural_name = 'Instagram Feed';

    private static $db = [
        'InstagramID' => 'Varchar(255)',
        'TotalItems' => 'Int',
        'Content' => 'HTMLText'
    ];

    private static $defaults = [
        'TotalItems' => 5
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab('Root.Main', [
            TextField::create('InstagramID', 'Instagram Page')
                ->setAttribute('placeholder', 'eg. newzealand')
                ->setDescription('Only the ID portion of the URL (do not include https://instagram.com/)'),
            NumericField::create('TotalItems', 'Number of posts to show')
                ->setDescription('Defaults to 5'),
            HTMLEditorField::create('Content', 'Content')
        ]);

        return $fields;
    }

    public function getCMSValidator()
    {
        $required = new RequiredFields(['InstagramID', 'TotalItems']);
        $this->extend('updateCMSValidator', $required);
        return $required;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        $this->InstagramID = ltrim(str_replace('https://instagram.com', '', $this->InstagramID), '/');
    }


    public function getInstagramFeed()
    {
        if ($this->InstagramID) {
            $insta = InstagramHelper::create($this->InstagramID);
            return $insta->getFeed();
        } else {
            return false;
        }
    }

    public function getItemsLimit()
    {
        return $this->TotalItems ?: 5;
    }

}
