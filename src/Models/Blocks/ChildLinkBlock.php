<?php

namespace Toast\Blocks;

use SilverStripe\ORM\ArrayList;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\DropdownField;
use UncleCheese\Forms\ImageOptionsetField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class ChildLinkBlock extends Block
{
    private static $table_name = 'Blocks_ChildLinkBlock';

    private static $singular_name = 'Children';

    private static $plural_name = 'Children Links';

    private static $content_field = 'Content';

    private static $db = [
        'Content' => 'HTMLText',
        'Columns' => 'Enum("2,3,4", "3")',
        'Width' => 'Enum("standard,wide,narrow,very-narrow", "standard")'
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            $fields->addFieldsToTab('Root.Main', [
                HTMLEditorField::create('Content', 'Content')
                    ->setRows(15),
                DropdownField::create('Columns', 'Columns', singleton(self::class)->dbObject('Columns')->enumValues()),
                ImageOptionsetField::create('Width', 'Select a Width')
                    ->setSource([
                        'wide' => '/app/src/images/widths/wide.svg',
                        'standard' => '/app/src/images/widths/standard.svg',
                        'narrow' => '/app/src/images/widths/narrow.svg',
                        'very-narrow' => '/app/src/images/widths/very-narrow.svg'
                    ])->setImageWidth(100)->setImageHeight(100)
            ]);
        });

        return parent::getCMSFields();
    }

    public function getItems()
    {
        $output = ArrayList::create();
        if ($page = \Page::get()->filter('ContentBlocks.ID', $this->ID)->first()) {
            foreach ($page->Children() as $child) {
                $child->Blocks__ContentSummary = $child->{self::contentField()};
                $output->push($child);
            }
        }
        return $output;
    }

    private static function contentField()
    {
        if ($customContentField = Config::inst()->get(self::class, 'content_field')) {
            return $customContentField;
        }
        return self::$content_field;
    }
}
