<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var dartLocation $dartLocation */

$tpl = $modx->getOption('tpl', $scriptProperties, '');

$dartLocation = $modx->getService('dartLocation', 'dartLocation', MODX_CORE_PATH . 'components/dartlocation/model/', $scriptProperties);
if (!$dartLocation) {
	return 'Could not load dartLocation class!';
}

if (!$modx->loadClass('pdofetch', MODX_CORE_PATH . 'components/pdotools/model/pdotools/', false, true)) {
	return false;
}
$pdoFetch = new pdoFetch($modx, $scriptProperties);
$out = array();

$cities = $modx->getCollection('dartLocationCity');

foreach($cities as $city){
	$tmp = $city->toArray();
	$coords = explode(",", $tmp['address_coordinats']);
	$pos = array((float) trim($coords[0]), (float) trim($coords[1]));
	if(!$tmp['properties']){
		$data = json_decode($dartLocation->getGeoData($pos), 1);
		if(count($data['suggestions'])){
			$tmp['data'] = str_replace("{", "{ ", json_encode($data['suggestions'][0]));
		}
		$city->set('properties', $tmp['data']);
		$city->save();
	}else{
		$tmp['data'] = json_encode($tmp['properties']);
	}

	$out['cities'][] =  $tmp;
}

$output = $pdoFetch->getChunk($tpl, $out);
return $output;