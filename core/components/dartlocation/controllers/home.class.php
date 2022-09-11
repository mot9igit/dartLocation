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
        $this->dartLocation = $this->modx->getService('dartLocation', 'dartLocation', MODX_CORE_PATH . 'components/dartlocation/model/');
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
        $this->addCss($this->dartLocation->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->dartLocation->config['jsUrl'] . 'mgr/dartlocation.js');
        $this->addJavascript($this->dartLocation->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->dartLocation->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->dartLocation->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->dartLocation->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->dartLocation->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->dartLocation->config['jsUrl'] . 'mgr/sections/home.js');

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