<?php

namespace Toast\Blocks;

use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\UserForms\Model\UserDefinedForm;

class UserFormBlock extends Block
{
    private static $table_name = 'Blocks_UserFormBlock';
    
    private static $singular_name = 'User form';
    
    private static $plural_name = 'User forms';

    public function getCMSFields()
    {        
        $fields = parent::getCMSFields();

        $fields->insertAfter('Title',
            LiteralField::create('', '<div class="message warning"><strong>Note:</strong><br />Form must be configured from the <strong>Form Fields</strong> page tab and only applies to <strong>User Defined Form</strong> page types.</div>')
        );

        return $fields;
    }

    public function Form()
    {
        if ($page = $this->getParentPage()) {
            if ($page->ClassName == UserDefinedForm::class) {
                return DBField::create_field(DBHTMLText::class, $page->UserDefinedForm);
            }
        }
    }


    public function getContentSummary()
    {
        if ($page = $this->getParentPage()) {
            return DBField::create_field('HTMLText', '<strong>Applied to page:</strong><br />' . $page->MenuTitle);
        }
    }

}