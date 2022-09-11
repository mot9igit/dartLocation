dartLocation.window.CreateCFResource = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('add'),
        url: dartLocation.config.connector_url,
        width: 700,
        autoHeight: true,
        action: 'mgr/city/resource/create',
        saveBtnText:_('add'),
        fields: [{
            xtype: 'hidden',
            name: 'resource',
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'dartlocation-combo-city',
            name: 'city',
            fieldLabel: _('dartlocation_resource_grid_city'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textarea',
            name: 'content',
            fieldLabel: _('dartlocation_resource_grid_content'),
            anchor: '100%',
            allowBlank: false,
            height: 400,
            id: config.id + '-content',
            listeners: {
                render: function (config) {
                    if (MODx.loadRTE && dartLocation.config.richtext == 1) {
                        window.setTimeout(function() {
                            MODx.loadRTE(config.id);
                        }, 300);
                    }
                }
            }
        }]
    });
    dartLocation.window.CreateCFResource.superclass.constructor.call(this, config);
};
Ext.extend(dartLocation.window.CreateCFResource, MODx.Window);
Ext.reg('dartlocation-window-resource', dartLocation.window.CreateCFResource);

dartLocation.window.UpdateResource = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'dartlocation-window-resource-update';
    }
    Ext.applyIf(config, {
        title: _('update'),
        autoHeight: true,
        fields: this.getFields(config),
        url: dartLocation.config.connector_url,
        action: 'mgr/city/resource/update',
        width: 700
    });
    dartLocation.window.UpdateResource.superclass.constructor.call(this, config);
};
Ext.extend(dartLocation.window.UpdateResource, MODx.Window, {
    getFields: function (config) {
        
        return [{
            xtype: 'hidden',
            name: 'id',
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'dartlocation-combo-city',
            name: 'city',
            fieldLabel: _('dartlocation_resource_grid_city'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textarea',
            name: 'content',
            fieldLabel: _('dartlocation_resource_grid_content'),
            anchor: '100%',
            allowBlank: false,
            height: 400,
            id: config.id + '-content',
            listeners: {
                render: function (config) {
                    if (MODx.loadRTE && dartLocation.config.richtext == 1) {
                        window.setTimeout(function() {
                            MODx.loadRTE(config.id);
                        }, 300);
                    }
                }
            }
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('dartlocation-resource-window-update', dartLocation.window.UpdateResource);