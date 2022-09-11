Ext.onReady(function () {
    dartLocation.config.connector_url = OfficeConfig.actionUrl;

    var grid = new dartLocation.panel.Home();
    grid.render('office-dartlocation-wrapper');

    var preloader = document.getElementById('office-preloader');
    if (preloader) {
        preloader.parentNode.removeChild(preloader);
    }
});