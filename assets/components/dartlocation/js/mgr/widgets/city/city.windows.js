dartLocation.window.City = function (config) {
    config = config || {};
    config.record = config.record || {object: {id: 0}};
    Ext.applyIf(config, {
        title: _('add'),
        url: dartLocation.config.connector_url,
        width:800,
        action: 'mgr/city/create',
        saveBtnText:_('add'),
        fields: [{
            xtype: 'textfield',
            name: 'key',
            fieldLabel: _('dartlocation_city_grid_key'),
            description: _('dartlocation_city_grid_key_empty'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'fias_id',
            fieldLabel: _('dartlocation_city_grid_fias_id'),
            description: _('dartlocation_city_grid_fias_id_empty'),
            anchor: '99%',
            allowBlank: true
        },{
            xtype: 'textfield',
            name: 'city',
            fieldLabel: _('dartlocation_city_grid_city'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'city_r',
            fieldLabel: _('dartlocation_city_grid_city_r'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'phone',
            fieldLabel: _('dartlocation_city_grid_phone'),
            anchor: '99%',
            allowBlank: true
        },{
            xtype: 'textfield',
            name: 'email',
            fieldLabel: _('dartlocation_city_grid_email'),
            anchor: '99%',
            allowBlank: true
        },{
            xtype: 'textarea',
            name: 'address',
            fieldLabel: _('dartlocation_city_grid_address'),
            anchor: '99%',
            allowBlank: true
        },{
            xtype: 'textarea',
            name: 'address_full',
            fieldLabel: _('dartlocation_city_grid_address_full'),
            anchor: '99%',
            allowBlank: true
        },{
            xtype: 'xcheckbox',
            name: 'default',
            boxLabel: _('dartlocation_city_grid_default'),
            anchor: '99%',
            allowBlank: true
        }]
    });
    dartLocation.window.City.superclass.constructor.call(this, config);
};
Ext.extend(dartLocation.window.City, MODx.Window);
Ext.reg('dartlocation-window-city', dartLocation.window.City);

dartLocation.window.UpdateCity = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'dartlocation-window-city';
    }
    Ext.applyIf(config, {
        title: _('update'),
        autoHeight: true,
        fields: this.getFields(config),
        url: dartLocation.config.connector_url,
        action: 'mgr/city/update',
        width: 800
    });
    dartLocation.window.UpdateCity.superclass.constructor.call(this, config);
};
Ext.extend(dartLocation.window.UpdateCity, MODx.Window, {
    getFields: function (config) {
        var tabs = [{
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items:[{
                title: _('dartlocation_window_main'),
                layout: 'anchor',
                items: [{
                    layout: 'column',
                    border: 'false',
                    anchor: '100%',
                    items:[{
                        columnWidth: 1,
                        layout: 'form',
                        defaults: {msTarget: 'under'},
                        border: 'false',
                        items: [{
                            xtype: 'hidden',
                            name: 'id',
                            id: config.id + '-id',
                        }, {
                            xtype: 'textfield',
                            name: 'key',
                            fieldLabel: _('dartlocation_city_grid_key'),
                            description: _('dartlocation_city_grid_key_empty'),
                            anchor: '99%',
                            allowBlank: false
                        },{
                            xtype: 'textfield',
                            name: 'fias_id',
                            fieldLabel: _('dartlocation_city_grid_fias_id'),
                            description: _('dartlocation_city_grid_fias_id_empty'),
                            anchor: '99%',
                            allowBlank: true
                        }, {
                            xtype: 'textfield',
                            name: 'city',
                            fieldLabel: _('dartlocation_city_grid_city'),
                            anchor: '99%',
                            allowBlank: false
                        }, {
                            xtype: 'textfield',
                            name: 'city_r',
                            fieldLabel: _('dartlocation_city_grid_city_r'),
                            anchor: '99%',
                            allowBlank: false
                        },{
                            xtype: 'textfield',
                            name: 'phone',
                            fieldLabel: _('dartlocation_city_grid_phone'),
                            anchor: '99%',
                            allowBlank: true
                        },{
                            xtype: 'textfield',
                            name: 'email',
                            fieldLabel: _('dartlocation_city_grid_email'),
                            anchor: '99%',
                            allowBlank: true
                        },{
                            xtype: 'textarea',
                            name: 'address',
                            fieldLabel: _('dartlocation_city_grid_address'),
                            anchor: '99%',
                            allowBlank: true
                        },{
                            xtype: 'textarea',
                            name: 'address_full',
                            fieldLabel: _('dartlocation_city_grid_address_full'),
                            anchor: '99%',
                            allowBlank: true
                        },{
                            xtype: 'xcheckbox',
                            name: 'default',
                            boxLabel: _('dartlocation_city_grid_default'),
                            anchor: '99%',
                            allowBlank: true
                        }]
                    }]
                }]
            },{
                title: _('dartlocation_window_fields'),
                layout: 'anchor',
                items:[{
                    layout: 'column',
                    border: 'false',
                    anchor: '100%',
                    items:[{
                        xtype: 'dartlocation-grid-fields',
                        preventRender: true,
                        record: config.record.object
                    }]
                }]
            }]
        }];
    
        return tabs;
    },

    loadDropZones: function () {
    }

});
Ext.reg('dartlocation-city-window-update', dartLocation.window.UpdateCity);

dartLocation.window.DuplicateCity = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'dartlocation-window-city-duplicate';
    }
    Ext.applyIf(config, {
        title: _('duplicate'),
        autoHeight: true,
        fields: this.getFields(config),
        url: dartLocation.config.connector_url,
        action: 'mgr/city/duplicate',
        width: 800
    });
    dartLocation.window.DuplicateCity.superclass.constructor.call(this, config);
};
Ext.extend(dartLocation.window.DuplicateCity, MODx.Window, {
    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-duplicate_id',
        },{
            xtype: 'textfield',
            name: 'key',
            fieldLabel: _('dartlocation_city_grid_key'),
            description: _('dartlocation_city_grid_key_empty'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'fias_id',
            fieldLabel: _('dartlocation_city_grid_fias_id'),
            description: _('dartlocation_city_grid_fias_id_empty'),
            anchor: '99%',
            allowBlank: true
        },{
            xtype: 'textfield',
            name: 'city',
            fieldLabel: _('dartlocation_city_grid_city'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'city_r',
            fieldLabel: _('dartlocation_city_grid_city_r'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'phone',
            fieldLabel: _('dartlocation_city_grid_phone'),
            anchor: '99%',
            allowBlank: true
        },{
            xtype: 'textfield',
            name: 'email',
            fieldLabel: _('dartlocation_city_grid_email'),
            anchor: '99%',
            allowBlank: true
        },{
            xtype: 'textarea',
            name: 'address',
            fieldLabel: _('dartlocation_city_grid_address'),
            anchor: '99%',
            allowBlank: true
        },{
            xtype: 'textarea',
            name: 'address_full',
            fieldLabel: _('dartlocation_city_grid_address_full'),
            anchor: '99%',
            allowBlank: true
        },{
            xtype: 'xcheckbox',
            name: 'default',
            boxLabel: _('dartlocation_city_grid_default'),
            anchor: '99%',
            allowBlank: true
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('dartlocation-city-window-duplicate', dartLocation.window.DuplicateCity);