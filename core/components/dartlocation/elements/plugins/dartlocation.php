<?php
$corePath = $modx->getOption('dartlocation_core_path', array(), $modx->getOption('core_path') . 'components/dartlocation/');
$dartLocation = $modx->getService('dartLocation', 'dartLocation', $corePath . 'model/');

/** @var modX $modx */
switch ($modx->event->name) {
	case 'OnLoadWebDocument':
		if (!$dartLocation) {
			$modx->log(xPDO::LOG_LEVEL_ERROR, 'Could not load dartlocation class!');
		}else{
			$api_key = $modx->getOption('dartlocation_api_key_dadata');
			if($api_key){
				$dartLocation->initialize($modx->context->key);
				if ($modx->getPlaceholder($modx->getOption('dartlocation_phx_prefix').'city')){
					$content = $dartLocation->getContent($modx->getPlaceholder($modx->getOption('dartlocation_phx_prefix').'city'), $modx->resource->id);
					if($content){
						$modx->resource->cacheable = 0;
						$modx->resource->content = $content;
					}
				}
			}else{
				$modx->log(xPDO::LOG_LEVEL_ERROR, 'dartLocation: enter dadata apikey!');
			}
		}
		break;
	case 'OnDocFormRender':
		$controller->dartLocation = $dartLocation;
		$controller->dartLocation->loadCustomJsCss();
		$modx->regClientStartupHTMLBlock('
            <script type="text/javascript">
                Ext.onReady(function() {
                    dartLocation.config.richtext = ' . $resource->richtext . ';
                });
            </script>
        ');
		break;
}