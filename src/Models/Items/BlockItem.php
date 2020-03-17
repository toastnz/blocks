<?php

namespace Toast\Blocks\Items;

use SilverStripe\ORM\DataObject;

class BlockItem extends DataObject
{
    private static $table_name = 'Blocks_BlockItem';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'ParentID',
            'SortOrder',
            'FileTracking',
            'LinkTracking'
        ]);

        return $fields;
    }

}