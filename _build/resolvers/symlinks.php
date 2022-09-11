<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/dartLocation/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/dartlocation')) {
            $cache->deleteTree(
                $dev . 'assets/components/dartlocation/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/dartlocation/', $dev . 'assets/components/dartlocation');
        }
        if (!is_link($dev . 'core/components/dartlocation')) {
            $cache->deleteTree(
                $dev . 'core/components/dartlocation/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/dartlocation/', $dev . 'core/components/dartlocation');
        }
    }
}

return true;