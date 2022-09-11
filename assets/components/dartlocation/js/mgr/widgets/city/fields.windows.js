dartLocation.window.Fields = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('add'),
        url: dartLocation.config.connector_url,
        width:600,
        action: 'mgr/fields/create',
        saveBtnText:_('add'),
        fields: [{
            xtype: 'hidden',
            name: 'city',
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'name',
            fieldLabel: _('dartlocation_fields_grid_name'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'key',
            fieldLabel: _('dartlocation_fields_grid_key'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textarea',
            name: 'value',
            fieldLabel: _('dartlocation_fields_grid_value'),
            anchor: '99%',
            allowBlank: false
        }]
    });
    dartLocation.window.Fields.superclass.constructor.call(this, config);
};
Ext.extend(dartLocation.window.Fields, MODx.Window);
Ext.reg('dartlocation-window-fields', dartLocation.window.Fields);

dartLocation.window.UpdateFields = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'dartlocation-window-fields-update';
    }
    Ext.applyIf(config, {
        title: _('update'),
        autoHeight: true,
        fields: this.getFields(config),
        url: dartLocation.config.connector_url,
        action: 'mgr/fields/update',
        width: 600
    });
    dartLocation.window.UpdateFields.superclass.constructor.call(this, config);
};
Ext.extend(dartLocation.window.UpdateFields, MODx.Window, {
    getFields: function (config) {
        
        return [{
            xtype: 'hidden',
            name: 'id',
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'name',
            fieldLabel: _('dartlocation_fields_grid_name'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'key',
            fieldLabel: _('dartlocation_fields_grid_key'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textarea',
            name: 'value',
            fieldLabel: _('dartlocation_fields_grid_value'),
            anchor: '99%',
            allowBlank: false
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('dartlocation-fields-window-update', dartLocation.window.UpdateFields);