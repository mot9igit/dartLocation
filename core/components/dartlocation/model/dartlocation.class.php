<?php

class dartLocation
{
    /** @var modX $modx */
    public $modx;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {
		$this->modx =& $modx;
		$corePath = $this->modx->getOption('dartlocation_core_path', $config, $this->modx->getOption('core_path') . 'components/dartlocation/');
		$assetsUrl = $this->modx->getOption('dartlocation_assets_url', $config, $this->modx->getOption('assets_url') . 'components/dartlocation/');
		$assetsPath = $this->modx->getOption('dartlocation_assets_path', $config, $this->modx->getOption('base_path') . 'assets/components/dartlocation/');

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',

            'connectorUrl' => $assetsUrl . 'connector.php',
			'actionUrl' => $assetsUrl . 'action.php',
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',

			'city_fields' => array_merge(['id'], explode(',', $this->modx->getOption('dartlocation_city_fields')), ['actions']),
			'version' => '0.0.1',
        ], $config);

		if ($this->pdoTools = $this->modx->getService('pdoFetch')) {
			$this->pdoTools->setConfig($this->config);
		}

        $this->modx->addPackage('dartlocation', $this->config['modelPath']);
        $this->modx->lexicon->load('dartlocation:default');
    }

	/**
	 * Initializes component into different contexts.
	 *
	 * @param string $ctx The context to load. Defaults to web.
	 * @param array $scriptProperties Properties for initialization.
	 *
	 * @return bool
	 */
	public function initialize($ctx = 'web', $scriptProperties = array())
	{
		if (isset($this->initialized[$ctx])) {
			return $this->initialized[$ctx];
		}
		$this->config = array_merge($this->config, $scriptProperties);
		$this->config['ctx'] = $ctx;
		$this->modx->lexicon->load('dartlocation:default');

		if ($ctx != 'mgr' && (!defined('MODX_API_MODE') || !MODX_API_MODE) && !$this->config['json_response']) {
			$config = $this->pdoTools->makePlaceholders($this->config);

			// Register CSS
			$css = trim($this->modx->getOption('dartlocation_frontend_css'));
			if (!empty($css) && preg_match('/\.css/i', $css)) {
				if (preg_match('/\.css$/i', $css)) {
					$css .= '?v=' . substr(md5($this->config['version']), 0, 10);
				}
				$this->modx->regClientCSS(str_replace($config['pl'], $config['vl'], $css));
			}

			// Register JS
			$js = trim($this->modx->getOption('dartlocation_frontend_js'));
			if (!empty($js) && preg_match('/\.js/i', $js)) {
				if (preg_match('/\.js$/i', $js)) {
					$js .= '?v=' . substr(md5($this->config['version']), 0, 10);
				}
				$this->modx->regClientScript($this->config['assetsUrl'].'/libs/autocomplete/src/jquery.autocomplete.js');
				$this->modx->regClientScript(str_replace($config['pl'], $config['vl'], $js));

				$js_setting = array(
					'cssUrl' => $this->config['cssUrl'] . 'web/',
					'jsUrl' => $this->config['jsUrl'] . 'web/',
					'actionUrl' => $this->config['actionUrl'],
					'dadata_api_key' => $this->modx->getOption('dartlocation_api_key_dadata'),

					'ctx' => $ctx
				);

				$data = json_encode($js_setting, true);
				$this->modx->regClientStartupScript(
					'<script>dartlocationConfig = ' . $data . ';</script>',
					true
				);
			}
		}
		$load = $this->loadServices($ctx);
		$this->initialized[$ctx] = $load;

		// init city
		if(isset($_SESSION['dartlocation'][$ctx])) {
			$this->modx->setPlaceholders($_SESSION['dartlocation'][$ctx]['pls'], 'dl.');
		}

		return $load;
	}

	/**
	 * @param string $ctx
	 *
	 * @return bool
	 */
	public function loadServices($ctx = 'web')
	{
		// Default classes
		if (!class_exists('Dadata')) {
			require_once dirname(__FILE__) . '/dadata.class.php';
			$token = $this->modx->getOption('dartlocation_api_key_dadata');
			$secret = $this->modx->getOption('dartlocation_secret_key_dadata');
			$this->dadata = new Dadata($token, $secret);
			$this->dadata->init();
		}
		return true;
	}

	/**
	 * Base fields
	 * @return type
	 */
	public function fields() {
		return array(
			1 => 'key',
			2 => 'city',
			3 => 'city_r',
			4 => 'phone',
			5 => 'email',
			6 => 'address',
			7 => 'address_full',
		);
	}

	/**
	 * Handle frontend requests with actions
	 *
	 * @param $action
	 * @param array $data
	 *
	 * @return array|bool|string
	 */
	public function handleRequest($action, $data = array())
	{
		$ctx = !empty($data['ctx'])
			? (string)$data['ctx']
			: 'web';
		if ($ctx != 'web') {
			$this->modx->switchContext($ctx);
		}
		$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
		$this->initialize($ctx, array('json_response' => $isAjax));
		switch ($action) {
			case 'get/suggestion':
				if ($data['value']) {
					$this->dadata->init();
					$response = $this->dadata->clean("address", $data['value']);
				}
				break;
			case 'city/accept':
				$response = $this->setShopCity($data);
				break;
			case 'get/cities':
				$response = $this->getCities($data);
				break;
			case 'city/status':
				$response = $this->getCityStatus($data);
				break;
			case 'city/check':
				$response = $this->checkCity($data);
				break;
			case 'city/more':
				$response = $this->cityMore($data);
				break;

		}
		return $response;
	}

	public function getLocationData($city){
		$dt = array(
			"query" => $city
		);
		$res = $this->dadata->findById('address', $dt);
		return $res;
	}

	public function getCityStatus($data){
		$ctx = $data['ctx'];
		$citycheck = 0;
		if(isset($_SESSION['dartlocation'][$ctx]['pls']['citycheck'])){
			if($_SESSION['dartlocation'][$ctx]['pls']['citycheck']){
				$citycheck = 1;
			}
		}
		if(empty($_SESSION['dartlocation'][$ctx]) || $citycheck){
			$location = $this->getLoocationByIP();
			$_SESSION['dartlocation'][$ctx] = $location;
			$_SESSION['dartlocation'][$ctx]['pls'] = array(
				'citycheck' => 1,
				'city' => $location['location']['value']
			);
		}
		return $this->success("", $_SESSION['dartlocation'][$ctx]);
	}

	public function setShopCity($data){
		$ctx = $data['ctx'];
		$_SESSION['dartlocation'][$ctx]['pls']['citycheck'] = 0;
		return $this->success("", array(
			"cityclose" => 1
		));
	}

	public function getLoocationByIP(){
		$res = $this->dadata->iplocate($_SERVER['REMOTE_ADDR']);
		return $res;
	}

	/**
	 * Run processor
	 * @param type $name
	 * @param type $params
	 * @return type
	 */
	public function runProcessor($name = '', $params = array()) {
		return $this->modx->runProcessor($name, $params, array('processors_path' => $this->config['processorsPath']))->response;
	}

	public function checkCity($data){
		$ctx = $data['ctx'];
		$_SESSION['dartlocation'][$ctx] = $data['data'];
		$_SESSION['dartlocation'][$ctx]['pls'] = array(
			'citycheck' => 0,
			'city' => $data['data']['city_with_type']? : $data['data']['result']
		);
		return $this->success("", array(
			"reload" => true
		));
	}

	public function cityMore($data){
		$ctx = $data['ctx'];
		$pos = array((float) $data['latitude'], (float) $data['longitude']);
		$dt = $this->getGeoData($pos);
		$data = $dt['suggestions'][0];

		$_SESSION['dartlocation'][$ctx] = $data;
		$_SESSION['dartlocation'][$ctx]['pls'] = array(
			'citycheck' => 0,
			'city' => $data['data']['city_with_type']? : $data['data']['settlement_with_type']
		);
		return $this->success("", array(
			"reload" => true
		));
	}

	public function getGeoData($coords){
		$res = $this->dadata->geolocate($coords[0], $coords[1], 1);
		return $res;
	}

	/**
	 * Get city suggestion by dadata
	 * @param array $data
	 * @return mixed
	 */
	public function getCities($data) {
		$dt = array(
			'from_bound' => array(
				"value" => "city"
			),
			'to_bound' => array(
				"value" => "city"
			),
			"restrict_value" => 1
		);
		if($data['query']) {
			$dt['query'] = $data['query'];
			$res = $this->dadata->suggest('address', $dt);
			return $res;
		}
	}

	/**
	 * Load custom js & css
	 */
	public function loadCustomJsCss (){
		$this->modx->controller->addCss($this->config['cssUrl'] . 'mgr/dartlocation.css?v='.$this->config['version']);
		$this->modx->controller->addJavascript($this->config['jsUrl'] . 'mgr/dartlocation.js?v='.$this->config['version']);
		$this->modx->controller->addLastJavascript($this->config['jsUrl'] . 'mgr/misc/utils.js?v='.$this->config['version']);
		$this->modx->controller->addLastJavascript($this->config['jsUrl'] . 'mgr/misc/combo.js?v='.$this->config['version']);
		$this->modx->controller->addLastJavascript($this->config['jsUrl'] . 'mgr/widgets/city/resource.tab.js?v='.$this->config['version']);
		$this->modx->controller->addLastJavascript($this->config['jsUrl'] . 'mgr/widgets/city/resource.panel.js?v='.$this->config['version']);
		$this->modx->controller->addLastJavascript($this->config['jsUrl'] . 'mgr/widgets/city/resource.grid.js?v='.$this->config['version']);
		$this->modx->controller->addLastJavascript($this->config['jsUrl'] . 'mgr/widgets/city/resource.windows.js?v='.$this->config['version']);

		$this->modx->controller->addHtml('<script>
            Ext.onReady(function() {
                dartLocation.config = ' . json_encode($this->config) . ';
                dartLocation.config.connector_url = "' . $this->config['connectorUrl'] . '";
            });
        </script>');

		$this->modx->controller->addLexiconTopic('dartlocation:default');
	}

	/**
	 * Get more fields
	 * @param type $domain_id
	 * @return type
	 */
	public function getFields($city_id) {
		$response = $this->modx->getCollection('dartLocationFields', array('city' => $city_id));
		$output = array();
		if (count($response)) {
			foreach ($response as $item) {
				$output[$item['key']] = $item['value'];
			}
		}
		return $output;
	}

	/**
	 * Duplicate fields
	 * @param type $old_item
	 * @param type $new_item
	 */
	public function duplicateFields($old_item, $new_item) {
		$fields = $this->modx->getCollection('dartLocationFields', array('city' => $old_item));
		if (count((array)$fields)) {
			foreach ($fields as $item) {
				$fields = $this->modx->newObject('dartLocationFields');
				$fields->set('city', $new_item);
				$fields->set('name', $item->name);
				$fields->set('key', $item->key);
				$fields->set('value', $item->value);
				$fields->save();
			}
		}
	}

	/**
	 * Get city name by domain id
	 * @param type $domain_id
	 * @return type
	 */
	public function getCityNameById($city_id) {
		$response = $this->modx->getObject('dartLocationCity', array('id' => $city_id));
		if (!$response) return false;
		return $response->city;
	}

	/**
	 * Get domain id by domain
	 * @param type $city
	 * @return type
	 */
	public function getCityId($city) {
		$response = $this->modx->getObject('dartLocationCity', array('key' => $city));
		if (!$response) return false;
		return $response->id;
	}

	/**
	 * Get resource content
	 * @param type $city
	 * @param type $resource
	 * @return type
	 */
	public function getContent($city, $resource) {
		$response = $this->modx->getObject('dartLocationResource', ['resource' => $resource]);
		if (!$response) return false;
		return $response->content;
	}

	/**
	 * Shorthand for original modX::invokeEvent() method with some useful additions.
	 *
	 * @param $eventName
	 * @param array $params
	 * @param $glue
	 *
	 * @return array
	 */
	public function invokeEvent($eventName, array $params = array(), $glue = '<br/>')
	{
		if (isset($this->modx->event->returnedValues)) {
			$this->modx->event->returnedValues = null;
		}

		$response = $this->modx->invokeEvent($eventName, $params);
		if (is_array($response) && count($response) > 1) {
			foreach ($response as $k => $v) {
				if (empty($v)) {
					unset($response[$k]);
				}
			}
		}

		$message = is_array($response) ? implode($glue, $response) : trim((string)$response);
		if (isset($this->modx->event->returnedValues) && is_array($this->modx->event->returnedValues)) {
			$params = array_merge($params, $this->modx->event->returnedValues);
		}

		return array(
			'success' => empty($message),
			'message' => $message,
			'data' => $params,
		);
	}

	/**
	 * This method returns an error of the order
	 *
	 * @param string $message A lexicon key for error message
	 * @param array $data .Additional data, for example cart status
	 * @param array $placeholders Array with placeholders for lexicon entry
	 *
	 * @return array|string $response
	 */
	public function error($message = '', $data = array(), $placeholders = array())
	{
		$response = array(
			'success' => false,
			//'message' => $this->modx->lexicon($message, $placeholders),
			'message' => $message,
			'data' => $data,
		);

		return $this->config['json_response']
			? json_encode($response)
			: $response;
	}


	/**
	 * This method returns an success of the order
	 *
	 * @param string $message A lexicon key for success message
	 * @param array $data .Additional data, for example cart status
	 * @param array $placeholders Array with placeholders for lexicon entry
	 *
	 * @return array|string $response
	 */
	public function success($message = '', $data = array(), $placeholders = array())
	{
		$response = array(
			'success' => true,
			'message' => $this->modx->lexicon($message, $placeholders),
			'data' => $data,
		);

		return $this->config['json_response']
			? json_encode($response)
			: $response;
	}
}