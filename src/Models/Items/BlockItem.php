<?php

namespace Toast\Blocks\Items;

use SilverStripe\ORM\DataObject;

class BlockItem extends DataObject
{
    private static $table_name = 'Blocks_BlockItem';

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            $fields->removeByName([
                'ParentID',
                'SortOrder',
                'FileTracking',
                'LinkTracking'
            ]);

        });

        return parent::getCMSFields();
    }

}