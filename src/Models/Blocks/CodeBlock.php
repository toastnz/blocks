<?php

namespace Toast\Blocks;

use Toast\Blocks\Block;
use SilverStripe\Forms\TextareaField;

class CodeBlock extends Block
{
    private static $table_name = 'Blocks_CodeBlock';

    private static $singular_name = 'Code';

    private static $plural_name = 'Code';

    private static $db = [
        'Content' => 'Text'
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            $fields->addFieldsToTab('Root.Main', [
                TextareaField::create('Content', 'Content')
                    ->setRows(20)
                    ->setAttribute('style', 'font-family: Courier, monospace;')
            ]);
        });

        return parent::getCMSFields();
    }
}
