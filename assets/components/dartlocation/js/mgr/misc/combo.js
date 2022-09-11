dartLocation.combo.Search = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        xtype: 'twintrigger',
        ctCls: 'x-field-search',
        allowBlank: true,
        msgTarget: 'under',
        emptyText: _('search'),
        name: 'query',
        triggerAction: 'all',
        clearBtnCls: 'x-field-search-clear',
        searchBtnCls: 'x-field-search-go',
        onTrigger1Click: this._triggerSearch,
        onTrigger2Click: this._triggerClear,
    });
    dartLocation.combo.Search.superclass.constructor.call(this, config);
    this.on('render', function () {
        this.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
            this._triggerSearch();
        }, this);
    });
    this.addEvents('clear', 'search');
};
Ext.extend(dartLocation.combo.Search, Ext.form.TwinTriggerField, {

    initComponent: function () {
        Ext.form.TwinTriggerField.superclass.initComponent.call(this);
        this.triggerConfig = {
            tag: 'span',
            cls: 'x-field-search-btns',
            cn: [
                {tag: 'div', cls: 'x-form-trigger ' + this.searchBtnCls},
                {tag: 'div', cls: 'x-form-trigger ' + this.clearBtnCls}
            ]
        };
    },

    _triggerSearch: function () {
        this.fireEvent('search', this);
    },

    _triggerClear: function () {
        this.fireEvent('clear', this);
    },

});
Ext.reg('dartlocation-combo-search', dartLocation.combo.Search);
Ext.reg('dartlocation-field-search', dartLocation.combo.Search);

dartLocation.combo.ComboBoxDefault = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        assertValue : function () {
            var val = this.getRawValue(),
                rec;
            if (this.valueField && Ext.isDefined(this.value)) {
                rec = this.findRecord(this.valueField, this.value);
            }
            /* fix for https://github.com/bezumkin/miniShop2/pull/350
            if(!rec || rec.get(this.displayField) != val){
                rec = this.findRecord(this.displayField, val);
            }*/
            if (rec && rec.get(this.displayField) != val) {
                rec = null;
            }
            if (!rec && this.forceSelection) {
                if (val.length > 0 && val != this.emptyText) {
                    this.el.dom.value = Ext.value(this.lastSelectionText, '');
                    this.applyEmptyText();
                } else {
                    this.clearValue();
                }
            } else {
                if (rec && this.valueField) {
                    if (this.value == val) {
                        return;
                    }
                    val = rec.get(this.valueField || this.displayField);
                }
                this.setValue(val);
            }
        },

    });
    dartLocation.combo.ComboBoxDefault.superclass.constructor.call(this, config);
};
Ext.extend(dartLocation.combo.ComboBoxDefault, MODx.combo.ComboBox);
Ext.reg('dartlocation-combo-combobox-default', dartLocation.combo.ComboBoxDefault);

dartLocation.combo.User = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'user',
        fieldLabel: config.name || 'createdby',
        hiddenName: config.name || 'createdby',
        displayField: 'fullname',
        valueField: 'id',
        anchor: '99%',
        fields: ['username', 'id', 'fullname'],
        pageSize: 20,
        typeAhead: false,
        editable: true,
        allowBlank: false,
        url: shopLogistic.config['connector_url'],
        baseParams: {
            action: 'mgr/system/user/getlist',
            combo: true,
        },
        tpl: new Ext.XTemplate(
            '\
            <tpl for=".">\
                <div class="x-combo-list-item">\
                    <span>\
                        <small>({id})</small>\
                        <b>{username}</b>\
                        <tpl if="fullname && fullname != username"> - {fullname}</tpl>\
                    </span>\
                </div>\
            </tpl>',
            {compiled: true}
        ),
    });
    shopLogistic.combo.User.superclass.constructor.call(this, config);
};
Ext.extend(dartLocation.combo.User, dartLocation.combo.ComboBoxDefault);
Ext.reg('dartlocation-combo-user', dartLocation.combo.User);

dartLocation.combo.City = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: shopLogistic.config.connector_url,
        baseParams: {
            action: 'mgr/city/load/city',
        },
        name: 'city',
        hiddenName: 'city',
        fields: ['id', 'city'],
        mode: 'remote',
        displayField: 'city',
        fieldLabel: _('dartlocation_city'),
        valueField: 'id',
        editable: true,
        anchor: '99%',
        allowBlank: false,
        autoLoad: false
    });
    dartLocation.combo.City.superclass.constructor.call(this, config);
};
Ext.extend(dartLocation.combo.City, MODx.combo.ComboBox);
Ext.reg('dartlocation-combo-city', dartLocation.combo.City);

dartLocation.combo.Product = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: dartLocation.config.connector_url,
        baseParams: {
            action: 'mgr/system/product/getlist',
        },
        name: 'product_id',
        hiddenName: 'product_id',
        fields: ['id', 'pagetitle', 'article', 'price'],
        mode: 'remote',
        displayField: 'pagetitle',
        fieldLabel: _('dartlocation_product_name'),
        valueField: 'id',
        editable: true,
        anchor: '99%',
        allowBlank: false,
        autoLoad: true,
        tpl: new Ext.XTemplate(
            '\
            <tpl for=".">\
                <div class="x-combo-list-item">\
                    <span>\
                        <small>({id})</small>\
                        <b>{pagetitle} ({article}) {price} р.</b>\
                    </span>\
                </div>\
            </tpl>',
            {compiled: true}
        ),
    });
    dartLocation.combo.Product.superclass.constructor.call(this, config);
};
Ext.extend(dartLocation.combo.Product, MODx.combo.ComboBox);
Ext.reg('dartlocation-combo-product', dartLocation.combo.Product);