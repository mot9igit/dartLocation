dartLocation.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'dartlocation-panel-home',
            renderTo: 'dartlocation-panel-home-div'
        }]
    });
    dartLocation.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(dartLocation.page.Home, MODx.Component);
Ext.reg('dartlocation-page-home', dartLocation.page.Home);