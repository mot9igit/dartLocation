var dartLocation = function (config) {
    config = config || {};
    dartLocation.superclass.constructor.call(this, config);
};
Ext.extend(dartLocation, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('dartlocation', dartLocation);

dartLocation = new dartLocation();