<?php

/**
 * The home manager controller for dartLocation.
 *
 */
class dartLocationHomeManagerController extends modExtraManagerController
{
    /** @var dartLocation $dartLocation */
    public $dartLocation;


    /**
     *
     */
    public function initialize()
    {
		$corePath = $this->modx->getOption('dartlocation_core_path', array(), $this->modx->getOption('core_path') . 'components/dartlocation/');
        $this->dartLocation = $this->modx->getService('dartLocation', 'dartLocation', $corePath . 'model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['dartlocation:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('dartlocation');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->dartLocation->config['cssUrl'] . 'mgr/dartlocation.css?v='.$this->dartLocation->config['version']);
        $this->addJavascript($this->dartLocation->config['jsUrl'] . 'mgr/dartlocation.js?v='.$this->dartLocation->config['version']);
        $this->addJavascript($this->dartLocation->config['jsUrl'] . 'mgr/misc/utils.js?v='.$this->dartLocation->config['version']);
        $this->addJavascript($this->dartLocation->config['jsUrl'] . 'mgr/misc/combo.js?v='.$this->dartLocation->config['version']);
		$this->addJavascript($this->dartLocation->config['jsUrl'] . 'mgr/widgets/city/city.grid.js?v='.$this->dartLocation->config['version']);
		$this->addJavascript($this->dartLocation->config['jsUrl'] . 'mgr/widgets/city/fields.grid.js?v='.$this->dartLocation->config['version']);
		$this->addJavascript($this->dartLocation->config['jsUrl'] . 'mgr/widgets/city/city.windows.js?v='.$this->dartLocation->config['version']);
		$this->addJavascript($this->dartLocation->config['jsUrl'] . 'mgr/widgets/city/fields.windows.js?v='.$this->dartLocation->config['version']);
        $this->addJavascript($this->dartLocation->config['jsUrl'] . 'mgr/widgets/home.panel.js?v='.$this->dartLocation->config['version']);
        $this->addJavascript($this->dartLocation->config['jsUrl'] . 'mgr/sections/home.js?v='.$this->dartLocation->config['version']);

        $this->addHtml('<script type="text/javascript">
        dartLocation.config = ' . json_encode($this->dartLocation->config) . ';
        dartLocation.config.connector_url = "' . $this->dartLocation->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "dartlocation-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="dartlocation-panel-home-div"></div>';

        return '';
    }
}