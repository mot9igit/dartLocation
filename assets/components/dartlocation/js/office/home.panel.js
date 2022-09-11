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
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: false,
            hideMode: 'offsets',
            items: [{
                title: _('dartlocation_items'),
                layout: 'anchor',
                items: [{
                    html: _('dartlocation_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'dartlocation-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    dartLocation.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(dartLocation.panel.Home, MODx.Panel);
Ext.reg('dartlocation-panel-home', dartLocation.panel.Home);
