<?php

namespace Toast\Blocks;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\FieldType\DBField;
use Toast\Blocks\Items\GalleryImageItem;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class GalleryBlock extends Block
{
    private static $table_name = 'Blocks_GalleryBlock';

    private static $singular_name = 'Gallery';

    private static $plural_name = 'Galleries';

    private static $db = [
        'ShowThumbnail' => 'Boolean'
    ];

    private static $has_many = [
        'GalleryImages' => GalleryImageItem::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab('Root.Main', [
            CheckboxField::create('ShowThumbnail', 'Show Thumbnail')
        ]);

        if ($this->ID) {
            $config = GridFieldConfig_RelationEditor::create(50)
                ->removeComponentsByType(GridFieldAddExistingAutoCompleter::class)
                ->removeComponentsByType(GridFieldDeleteAction::class)
                ->addComponents(new GridFieldDeleteAction())
                ->addComponents(GridFieldOrderableRows::create('SortOrder'));                
            $grid = GridField::create('GalleryImages', 'Gallery Images', $this->GalleryImages(), $config);
            $fields->addFieldToTab('Root.GalleryImages', $grid);

        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('', '<div class="message notice">Save this block to show additional options.</div>'));
        }

        return $fields;
    }


}
