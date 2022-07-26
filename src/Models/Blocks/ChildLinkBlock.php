<?php

namespace Toast\Blocks;

use SilverStripe\ORM\ArrayList;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\DropdownField;
use UncleCheese\Forms\ImageOptionsetField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Core\Manifest\ModuleResourceLoader;

class ChildLinkBlock extends Block
{
    private static $table_name = 'Blocks_ChildLinkBlock';

    private static $singular_name = 'Children';

    private static $plural_name = 'Children Links';

    private static $content_field = 'Content';

    private static $db = [
        'Content' => 'HTMLText',
        'Columns' => 'Enum("2,3,4", "3")',
        'Width' => 'Enum("standard,wide,narrow,thin", "standard")'
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
                        'wide' => ModuleResourceLoader::resourceURL('toastnz/blocks:images/widths/wide.svg'),
                        'standard' => ModuleResourceLoader::resourceURL('toastnz/blocks:images/widths/standard.svg'),
                        'narrow' => ModuleResourceLoader::resourceURL('toastnz/blocks:images/widths/narrow.svg'),
                        'thin' => ModuleResourceLoader::resourceURL('toastnz/blocks:images/widths/thin.svg')
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
