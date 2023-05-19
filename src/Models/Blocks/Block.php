<?php

namespace Toast\Blocks;

use Page;
use ReflectionClass;
use SilverStripe\ORM\DB;
use SilverStripe\Security\Security;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
use SilverStripe\Security\Member;
use SilverStripe\Control\Director;
use Psr\SimpleCache\CacheInterface;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Security\Permission;
use SilverStripe\Versioned\Versioned;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\CMS\Controllers\CMSPageEditController;

class Block extends DataObject
{
    private static $table_name = 'Blocks_Block';

    private static $singular_name = 'Block';

    private static $plural_name = 'Blocks';

    private static $db = [
        'Title' => 'Varchar(255)'
    ];

    private static $casting = [
        'Icon' => 'HTMLText'
    ];

    private static $summary_fields = [
        'IconForCMS' => 'Type',
        'Title' => 'Title',
        'ContentSummary' => 'Content'
    ];

    private static $searchable_fields = [
        'Title'
    ];

    private static $extensions = [
        Versioned::class
    ];

    private static $versioned_gridfield_extensions = true;

    public function getIconForCMS()
    {
        $icon = str_replace('[resources]', RESOURCES_DIR . '/vendor', self::config()->get('icon') ?: '');

        return DBField::create_field('HTMLText', '
            <div title="' . $this->i18n_singular_name() . '" style="margin: 0 auto;width:50px; height:50px; white-space:nowrap; ">
                <img style="width:100%;height:100%;display:inline-block !important" src="' . $icon . '">
            </div>
            <span style="font-weight:bold;display:block;line-height:10px;text-align:center;margin:0px 0 0;padding:0;font-size:10px;text-transform:uppercase;">' . $this->i18n_singular_name() . '</span>
        ');
    }

    public function IconForCMS()
    {
        return $this->getIconForCMS();
    }

    public function forTemplate()
    {
        $template = $this->ClassName;
        $this->extend('updateBlockTemplate', $template);

        if (self::config()->get('enable_cache')) {
            $cache = Injector::inst()->get(CacheInterface::class . '.toastBlocksCache');

            if ($cachedContents = $cache->get($this->getCacheKey())) {
                return $cachedContents;
            }

            $renderedContents = $this->renderWith([$template, 'Toast\Blocks\Block']);
            $cache->set($this->getCacheKey(), $renderedContents);

            return $renderedContents;
        }

        return $this->renderWith([$template, 'Toast\Blocks\Block']);
    }

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            if ($this->ID) {
                $fields->addFieldsToTab('Root.More', [
                    LiteralField::create('BlockLink', 'Block Link <br><a href="' . $this->AbsoluteLink() . '" target="_blank">' . $this->AbsoluteLink() . '</a><hr>'),
                    ReadonlyField::create('Shortcode', 'Shortcode', '[block,id=' . $this->ID . ']')
                ]);
            }

            $fields->addFieldsToTab('Root.Main', [
                TextField::create('Title', 'Title')
                    ->setDescription('Title used for internal reference only and does not appear on the site.')
            ]);
        });

        return parent::getCMSFields();
    }

    public function getContentSummary()
    {
        return DBField::create_field(DBHTMLText::class, '');
    }

    public function getTitle()
    {
        if ($this->exists()) {
            return $this->getField('Title') ?: $this->i18n_singular_name();
        } else {
            return $this->getField('Title');
        }
    }

    public function getApiURL()
    {
        return Controller::join_links(Controller::curr()->AbsoluteLink(), 'Block', $this->ID);
    }

    public function getLink($action = null)
    {
        $parent = $this->getParentPage();

        if ($parent && $parent->exists()) {
            return $parent->Link($action) . '#' . $this->getHtmlID();
        }

        $parent = Page::get()->leftJoin('Page_ContentBlocks', '"Page_ContentBlocks"."PageID" = "SiteTree"."ID"')
            ->where('"Page_ContentBlocks"."Blocks_BlockID" = ' . $this->ID)
            ->first();

        if ($parent && $parent->exists()) {
            return $parent->Link($action) . '#' . $this->getHtmlID();
        }

        return '';
    }

    public function Link($action = null)
    {
        return $this->getLink($action);
    }

    public function getAbsoluteLink($action = null)
    {
        return Controller::join_links(Director::absoluteBaseURL(), $this->Link($action));
    }

    public function AbsoluteLink($action = null)
    {
        return $this->getAbsoluteLink($action);
    }

    public function getHtmlID()
    {
        $reflect = new ReflectionClass($this);

        $templateName = $reflect->getShortName() ?: $this->ClassName;

        return $templateName . '_' . $this->ID;
    }

    public function getDisplayTitle()
    {
        $title = $this->Title;

        $parent = $this->getParentPage();

        if ($parent && $parent->exists()) {
            $title .= ' (on page ' . $parent->Title . ')';
        }

        return $title;
    }

    public function canView($member = null)
    {
        if ($member && Permission::checkMember($member, ["ADMIN", "SITETREE_VIEW_ALL"])) {
            return true;
        }

        $extended = $this->extendedCan('canView', $member);

        if ($extended !== null) {
            return $extended;
        }

        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canEdit($member = null)
    {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canDelete($member = null)
    {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canCreate($member = null, $context = [])
    {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canDeleteFromLive($member = null)
    {
        $extended = $this->extendedCan('canDeleteFromLive', $member);

        if ($extended !== null) {
            return $extended;
        }

        return $this->canPublish($member);
    }

    public function canPublish($member = null)
    {
        if (!$member || !(is_a($member, Member::class)) || is_numeric($member)) {
            $member = Security::getCurrentUser();
        }

        if ($member && Permission::checkMember($member, "ADMIN")) {
            return true;
        }

        $extended = $this->extendedCan('canPublish', $member);
        if ($extended !== null) {
            return $extended;
        }

        return $this->canEdit($member);
    }

    public function isPublished()
    {
        if ($this->isNew()) {
            return false;
        }

        return (DB::prepared_query("SELECT \"ID\" FROM \"Blocks_Block_Live\" WHERE \"ID\" = ?", [$this->ID])->value())
            ? true
            : false;
    }

    public function isNew()
    {
        if (empty($this->ID)) {
            return true;
        }

        if (is_numeric($this->ID)) {
            return false;
        }

        return stripos($this->ID, 'new') === 0;
    }

    public function getParentPage()
    {
        if ($controller = Controller::curr()) {
            if (!$controller instanceof CMSPageEditController) {
                try {
                    if ($data = $controller->data()) {
                        if ($data->ID) {
                            return SiteTree::get()->byID($data->ID);
                        }
                    }
                } catch (\Exception $e) {
                }
            }
        }
    }

    public function doArchive()
    {
        $this->invokeWithExtensions('onBeforeArchive', $this);

        $thisID = $this->ID;

        if (!$this->isPublished() || $this->doUnpublish()) {
            $this->delete();

            DB::prepared_query("DELETE FROM \"Page_ContentBlocks\" WHERE \"Blocks_BlockID\" = ?", [$thisID]);

            $this->invokeWithExtensions('onAfterArchive', $this);

            return true;
        }

        return false;
    }

    public function canArchive($member = null)
    {
        if (!$member) {
            $member = Security::getCurrentUser();
        }

        $extended = $this->extendedCan('canArchive', $member);
        if ($extended !== null) {
            return $extended;
        }

        if (!$this->canDelete($member)) {
            return false;
        }

        if ($this->ExistsOnLive && !$this->canDeleteFromLive($member)) {
            return false;
        }

        return true;
    }

    public function getCacheKey()
    {
        $keyParts = ['Block', $this->ID, $this->LastEdited];

        $dbFields = Config::inst()->get($this->ClassName, 'db');        
        $dbFields = is_array($dbFields) ? $dbFields : [];

        foreach(array_keys($dbFields) as $dbField) {
            $keyParts[] = $this->$dbField;
        }
        
        $relations = $this->hasOne() + $this->hasMany() + $this->manyMany();

        foreach(array_keys($relations) as $relationName) {
            foreach($this->$relationName() as $record) {
                $keyParts[] = $record->LastEdited;
            }
        }

        return sha1(implode(',', $keyParts));        
    }


    public function clearCache()
    {
        $cache = Injector::inst()->get(CacheInterface::class . '.toastBlocksCache');
        $cache->delete($this->getCacheKey());
    }
}
