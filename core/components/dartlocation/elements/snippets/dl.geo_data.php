<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var dartLocation $dartLocation */
$tpl = $modx->getOption('tpl', $scriptProperties, 'dl.geodata');
$modal_tpl = $modx->getOption('modal_tpl', $scriptProperties, 'dl.modal');

$dartLocation = $modx->getService('dartLocation', 'dartLocation', MODX_CORE_PATH . 'components/dartlocation/model/', $scriptProperties);
if (!$dartLocation) {
	return 'Could not load dartLocation class!';
}

if (!$modx->loadClass('pdofetch', MODX_CORE_PATH . 'components/pdotools/model/pdotools/', false, true)) {
	return false;
}
$pdoFetch = new pdoFetch($modx, $scriptProperties);
$data = array();

$ctx = $modx->context->key;

if (isset($_SESSION['dartlocation'][$ctx])) {
	$data = $_SESSION['dartlocation'][$ctx]['pls'];
}

$output = $pdoFetch->getChunk($tpl, $data);
$modal = $pdoFetch->getChunk($modal_tpl, $data);
$modx->regClientHTMLBlock($modal);

if (!empty($toPlaceholder)) {
	$modx->setPlaceholder($toPlaceholder, $output);
	return '';
}
return $output;