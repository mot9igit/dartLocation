dartLocation.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'dartlocation-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('dartlocation') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('dartlocation_panel_city'),
                items: [{
                    html: _('dartlocation_panel_city_desc'),
                    cls: 'panel-desc',
                },{
                    xtype: 'panel',
                    cls: 'container',
                    items: [{
                        xtype: 'dartlocation-grid-city'
                    }]
                }]
            }]
        }]
    });
    dartLocation.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(dartLocation.panel.Home, MODx.Panel);
Ext.reg('dartlocation-panel-home', dartLocation.panel.Home);
