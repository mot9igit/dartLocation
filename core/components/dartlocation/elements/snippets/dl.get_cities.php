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
	if($tmp['fias_id'] == ''){
		$data = $dartLocation->dadata->clean("address", $tmp['city']);
		if(count($data)){
			$tmp['data'] = str_replace("{", "{ ", json_encode($data[0]));
			$city->set('fias_id', $data[0]['fias_id']);
			$city->set('properties', $tmp['data']);
			$city->save();
		}
	}else{
		$tmp['data'] = json_encode($tmp['properties']);
	}
	$out['cities'][] =  $tmp;
}

$output = $pdoFetch->getChunk($tpl, $out);
return $output;