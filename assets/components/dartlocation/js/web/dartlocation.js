/*
 *   Author: Petropavlovsky Artem https://dart.agency/
 *   Date: 12/09/2022
 */
var dartlocation = {
    options: {
        wrapper: '.dl_wrap',
        geo_close: '.dl_city_close',
        geo_more: '.dl_city_more_info',
        geo_city: '.dl_geo_city',
        geo_checked: '.city_checked',
        geo_complete: '.city_complete'
    },
    initialize: function () {
        var action = 'city/status';
        var data = {
            dl_action: action
        };
        dartlocation.send(data);
        $(document).on("click", dartlocation.options.geo_checked, function(e) {
            e.preventDefault();
            var action = 'city/check';
            var data = {
                dl_action: action,
                data: $(this).data('data')
            };
            dartlocation.send(data);
        });
        $(dartlocation.options.geo_complete).dAutocomplete({
            serviceUrl: dartlocationConfig['actionUrl'],
            minChars: 3,
            type: "POST",
            params: {
                dl_action: 'get/cities'
            },
            onSelect: function (suggestion) {
                var action = 'city/check';
                var data = {
                    dl_action: action,
                    data: suggestion.data
                };
                dartlocation.send(data);
            }
        });
        $(document).on("click", dartlocation.options.geo_more, function(e) {
            e.preventDefault();
            let geoposition = navigator.geolocation.getCurrentPosition(
                function(position) {
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;
                    // геокодер
                    var action = 'city/more';
                    var data = {
                        dl_action: action,
                        longitude: longitude,
                        latitude: latitude
                    };
                    dartlocation.send(data);
                });
            // show modal
            var cityModal = new bootstrap.Modal(document.getElementById('modal_city'));
            cityModal.show();
        });
        },
    send: function(data){
        var response = '';
        data.ctx = dartlocationConfig['ctx'];
        $.ajax({
            type: "POST",
            url: dartlocationConfig['actionUrl'],
            dataType: 'json',
            data: data,
            success:  function(data_r) {
                if(data_r.data.hasOwnProperty('pls')){
                    if(data_r.data.pls.citycheck == 1){
                        $(dartlocation.options.geo_city).text(data_r.data.pls.city);
                        $('.dl_city_close').attr("data-data", JSON.stringify(data_r.data));
                        $(".city_popup").addClass('active');
                    }
                }
                if(typeof data_r.data.reload !== "undefined"){
                    if(data_r.data.reload) {
                        document.location.reload();
                    }
                }
                if(typeof data_r.data.cityclose !== "undefined"){
                    if(data_r.data.cityclose) {
                        $(".city_popup").removeClass('active');
                    }
                }
            }
        });
    },
}

$(document).ready(function(){
    if($(dartlocation.options.wrapper).length){
        dartlocation.initialize();
    }
})