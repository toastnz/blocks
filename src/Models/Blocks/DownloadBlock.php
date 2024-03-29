<?php

namespace Toast\Blocks;

use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\FieldType\DBField;
use Toast\Blocks\Items\DownloadBlockItem;
use UncleCheese\Forms\ImageOptionsetField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutoCompleter;
use SilverStripe\Core\Manifest\ModuleResourceLoader;

class DownloadBlock extends Block
{
    private static $table_name = 'Blocks_DownloadBlock';

    private static $singular_name = 'Download';

    private static $plural_name = 'Downloads';

    private static $db = [
        'Width' => 'Enum("standard,wide,narrow,thin", "standard")'
    ];

    private static $has_many = [
        'Items' => DownloadBlockItem::class,
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            $fields->removeByName('Items');

            $fields->removeByName(['Items', 'Width']);

            if ($this->exists()) {
                $config = GridFieldConfig_RelationEditor::create(50)
                    ->removeComponentsByType(GridFieldAddExistingAutoCompleter::class)
                    ->removeComponentsByType(GridFieldDeleteAction::class)
                    ->addComponents(new GridFieldDeleteAction())
                    ->addComponents(GridFieldOrderableRows::create('SortOrder'));
                $grid = GridField::create('Items', 'Files', $this->Items(), $config);
                $fields->addFieldsToTab(
                    'Root.Main',
                    [
                        $grid,
                        ImageOptionsetField::create('Width', 'Select a Width')
                            ->setSource([
                                'wide' => ModuleResourceLoader::resourceURL('toastnz/blocks:images/widths/wide.svg'),
                                'standard' => ModuleResourceLoader::resourceURL('toastnz/blocks:images/widths/standard.svg'),
                                'narrow' => ModuleResourceLoader::resourceURL('toastnz/blocks:images/widths/narrow.svg'),
                                'thin' => ModuleResourceLoader::resourceURL('toastnz/blocks:images/widths/thin.svg')        
                            ])->setImageWidth(100)->setImageHeight(100)
                    ]
                );
            } else {
                $fields->addFieldToTab('Root.Main', LiteralField::create('', '<div class="message notice">Save this block to show additional options.</div>'));
            }
        });

        return parent::getCMSFields();
    }

    public function getContentSummary()
    {
        if ($this->Items()) {
            return DBField::create_field('Text', implode(', ', $this->Items()->column('Title')));
        }

        return DBField::create_field('Text', $this->Title);
    }
}
