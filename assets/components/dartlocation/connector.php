<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
	/** @noinspection PhpIncludeInspection */
	require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var dartLocation $dartLocation */


$corePath = $modx->getOption('dartlocation_core_path', array(), $modx->getOption('core_path') . 'components/dartlocation/');
$dartLocation = $modx->getService('dartLocation', 'dartLocation', $corePath . 'model/');
$modx->lexicon->load('dartlocation:default');

// handle request
$corePath = $modx->getOption('dartlocation_core_path', array(), $modx->getOption('core_path') . 'components/dartlocation/');
$path = $modx->getOption('processorsPath', $dartLocation->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest([
    'processors_path' => $path,
    'location' => '',
]);