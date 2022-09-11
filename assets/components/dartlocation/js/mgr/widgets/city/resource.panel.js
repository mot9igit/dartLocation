dartLocation.panel.Resource = function (config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'dartlocation-panel-resource',
        autoHeight: true,
        layout: 'form',
        anchor: '99%',
        items: [{
            xtype: 'dartlocation-grid-resource',
            cls: 'main-wrapper',
            record: config.record
        }]
    });
    dartLocation.panel.Resource.superclass.constructor.call(this, config);
};
Ext.extend(dartLocation.panel.Resource, MODx.Panel);
Ext.reg('dartlocation-panel-resource', dartLocation.panel.Resource);
