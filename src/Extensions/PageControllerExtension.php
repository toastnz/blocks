<?php

namespace Toast\Blocks\Extensions;

use SilverStripe\Core\Extension;

class PageControllerExtension extends Extension
{
    public function onBeforeInit()
    {
        if ($request = $this->owner->getRequest()) {
            if ($request->getVar('flush_blocks')) {                
                if ($this->owner->hasMethod('data')) {
                    if ($this->owner->data()->hasMethod('ContentBlocks')) {
                        foreach($this->owner->ContentBlocks() as $block) {
                            $block->clearCache();                            
                        }
                    }
                }
            }
        }
    }

}
