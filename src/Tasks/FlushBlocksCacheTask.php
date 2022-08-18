<?php

namespace Toast\Blocks\Tasks;

use SilverStripe\Dev\BuildTask;
use Psr\SimpleCache\CacheInterface;
use SilverStripe\Core\Injector\Injector;

class FlushBlocksCacheTask extends BuildTask
{
    private static $segment = 'FlushBlocksCacheTask';

    protected $title = 'Clear all content blocks cache';

    protected $description = 'Clear cached data for all content blocks on the site';

    public function run($request)
    {
        $cache = Injector::inst()->get(CacheInterface::class . '.toastBlocksCache');
        $cache->clear();

        echo 'Removed cache for all content blocks.';        
    }
}
