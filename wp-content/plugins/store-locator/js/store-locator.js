var sl_map;
var sl_geocoder;
var sl_info_window;
var sl_marker_array = [];
var sl_marker_type;
var showAll = false;
var sl_geo_flag = 0;
if (!is_array(sl_categorization_array)) {
    var sl_categorization_array = []
}
var sl_marker_categorization_field = (is_array(sl_categorization_array) && sl_categorization_array.length > 0) ? sl_categorization_array[0] : 'type';
var sl_ccTLD = sl_google_map_domain.match(/\.([^\.]+)$/);
var sl_ccTLD_not_set = (typeof sl_ccTLD[1] == 'undefined' || sl_ccTLD[1] == 'null' || sl_ccTLD[1] == '');
if (sl_ccTLD_not_set || sl_ccTLD[1] == 'com') {
    var sl_ccTLD = (sl_ccTLD_not_set || sl_google_map_domain.indexOf('ditu') == -1) ? 'us' : 'cn'
} else {
    var sl_ccTLD = sl_ccTLD[1]
}
var sl_mvc_instances = [];
if (typeof sl_map_params != "undefined") {
    sl_map_params = sl_map_params.split("=").join("[]=")
}
if (!function_exists("sl_details_filter")) {
    var sl_details_filter = function(sl_details) {
            return sl_details
        }
}
if (window.location.host.indexOf('www.') != -1 && sl_base.indexOf('www.') == -1) {
    sl_base = sl_base.split('http://').join('http://www.')
} else if (window.location.host.indexOf('www.') == -1 && sl_base.indexOf('www.') != -1) {
    sl_base = sl_base.split('http://www.').join('http://')
}
function sl_load() {
    map_type_check();
    sl_geocoder = new google.maps.Geocoder();
    if ("undefined" != typeof document.getElementById("sl_map") && null != document.getElementById("sl_map")) {
        sl_map = new google.maps.Map(document.getElementById("sl_map"));
        if (typeof sl_infowindow_type != 'undefined') {
            sl_info_window = new sl_infowindow_type
        } else {
            sl_info_window = new google.maps.InfoWindow
        }
        if (function_exists("start_sl_load")) {
            start_sl_load()
        }
        if (sl_geolocate == '1') {
            showLoadImg('show', 'loadImg');
            try {
                if (typeof navigator.geolocation === 'undefined') {
                    ng = google.gears.factory.create('beta.geolocation')
                } else {
                    ng = navigator.geolocation
                }
            } catch (e) {}
            if (ng) {
                if (sl_geo_flag != 1) {
                    do_load_options()
                }
                ng.getCurrentPosition(sl_geo_success, sl_geo_error)
            } else {
                do_load_options()

            }
        } else {
            do_load_options()

        }

        if (function_exists("end_sl_load")) {
            google.maps.event.addDomListenerOnce(sl_map, 'tilesloaded', end_sl_load)
        }
    }

    $('.seeAllStores').click(function(){
          showAll = true;
          sl_load();
          $('.seeAllStores').addClass('hide'); 
    });

 
}
google.maps.event.addDomListener(window, 'load', sl_load);

function sl_geo_success(point) {
    sl_geo_flag = 1;
    var the_coords = new google.maps.LatLng(point.coords.latitude, point.coords.longitude);
    sl_geocoder.geocode({
        'location': the_coords
    }, function(results) {
        aI = document.getElementById('addressInput');
        aI.value = results[0].formatted_address;
        searchLocationsNear(the_coords, aI.value)
    })
}
function sl_geo_error(err) {
    sl_geo_flag = 1;
    do_load_options()
}
function do_load_options() {
    if (sl_load_locations_default == '0') {
        sl_geocoder.geocode({
            'address': sl_google_map_country
        }, function(results, status) {
            var myOptions = {
                center: results[0].geometry.location,
                zoom: sl_zoom_level,
                mapTypeId: sl_map_type_v3,
                overviewMapControl: sl_map_overview_control,
                disableDefaultUI: false,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                }
            };
            if (typeof sl_map_options != 'undefined' && typeof sl_map_options === 'object') {
                myOptions = mergeArray(sl_map_options, myOptions)
            }
            sl_map.setOptions(myOptions)
        })
    }
    if (sl_load_locations_default == "1") {
        var bounds = new google.maps.LatLngBounds();
        var searchUrl = sl_base + "/sl-xml.php";
        if (typeof sl_map_params != "undefined") {
            searchUrl += "?" + sl_map_params
        }
        retrieveData(searchUrl, function(data) {
            var xml = data.responseXML;
            var markerNodes = xml.documentElement.getElementsByTagName("marker");
            var sidebar = document.getElementById('map_sidebar');
            sidebar.innerHTML = '';
            for (var i = 0; i < markerNodes.length; i++) {
                var sl_details = buildDetails(markerNodes[i], i);
                sl_marker_type = markerNodes[i].getAttribute(sl_marker_categorization_field);
                if (sl_marker_type == "" || sl_marker_type == null) {
                    sl_marker_type = "sl_map_end_icon"
                }
                var icon = (typeof sl_icons != 'undefined' && typeof sl_icons[sl_marker_type] != 'undefined') ? sl_icons[sl_marker_type] : {
                    url: sl_map_end_icon,
                    name: 'Default'
                };
                var marker = createMarker(sl_details, sl_marker_type, icon);

                if (sl_load_results_with_locations_default == '1') {
                    var sidebarEntry = createSidebarEntry(marker, sl_details, showAll);
                    sidebarEntry.id = "sidebar_div_" + i;
                    sidebar.appendChild(sidebarEntry)
                }
                bounds.extend(sl_details['point'])
            }
            
             $('.carouselStock').bxSlider({
                slideWidth: 200,
                minSlides: 2,
                maxSlides: 2,
                slideMargin: 40,
                nextText:"",
                prevText:""
              });
            
            
            if (showAll) $('.seeAllStores').addClass('hide');
            else $('.seeAllStores').removeClass('hide');

           

            
            if (markerNodes.length == 0) {
                sl_geocoder.geocode({
                    'address': sl_google_map_country
                }, function(results, status) {
                    var myOptions = {
                        center: results[0].geometry.location,
                        zoom: sl_zoom_level,
                        mapTypeId: sl_map_type_v3,
                        overviewMapControl: sl_map_overview_control,
                        disableDefaultUI: false,
                        mapTypeControlOptions: {
                            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                        }
                    };
                    if (typeof sl_map_options != 'undefined' && typeof sl_map_options === 'object') {
                        myOptions = mergeArray(sl_map_options, myOptions)
                    }
                    if (typeof sl_mvc_objects != 'undefined' && typeof sl_mvc_objects['type'] != 'undefined' && typeof sl_mvc_objects['options'] != 'undefined') {
                        for (mvc in sl_mvc_objects['type']) {
                            sl_mvc_instances[mvc] = new sl_mvc_objects['type'][mvc](sl_mvc_objects['options'][mvc]);
                            sl_mvc_instances[mvc].setMap(sl_map)
                        }
                    }
                    sl_map.setOptions(myOptions)
                })
            } else {
                var myOptions = {
                    center: bounds.getCenter(),
                    mapTypeId: sl_map_type_v3,
                    overviewMapControl: sl_map_overview_control,
                    disableDefaultUI: false,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                    }
                };
                if (typeof sl_map_options != 'undefined' && typeof sl_map_options === 'object') {
                    myOptions = mergeArray(sl_map_options, myOptions)
                }
                if (typeof sl_mvc_objects != 'undefined' && typeof sl_mvc_objects['type'] != 'undefined' && typeof sl_mvc_objects['options'] != 'undefined') {
                    for (mvc in sl_mvc_objects['type']) {
                        sl_mvc_instances[mvc] = new sl_mvc_objects['type'][mvc](sl_mvc_objects['options'][mvc]);
                        sl_mvc_instances[mvc].setMap(sl_map)
                    }
                }
                sl_map.setOptions(myOptions);
                sl_map.fitBounds(bounds)
            }
            if (sl_map.getZoom() > 16) {
                sl_map.setZoom(9)
            }
        })
    

        
    }

    
    
    
    
}
function searchLocations() {
    if (function_exists("start_searchLocations")) {
        start_searchLocations()
    }
    var address = document.getElementById('addressInput').value;
    sl_geocoder.geocode({
        'address': address,
        'region': sl_ccTLD
    }, function(results, status) {
        if (status != google.maps.GeocoderStatus.OK) {
            showLoadImg('stop', 'loadImg');
            if (sl_location_not_found_message.split(' ').join('') != "") {
                alert(sl_location_not_found_message)
            } else {
                alert(address + ' Not Found')
            }
        } else {
            searchLocationsNear(results[0].geometry.location, address)

        }
    });
    if (function_exists("end_searchLocations")) {
        end_searchLocations()
    }
}
function searchLocationsNear(center, homeAddress) {
    if (function_exists("start_searchLocationsNear")) {
        start_searchLocationsNear()
    }
    var radius = 1000;
    var searchUrl = sl_base + '/sl-xml.php?mode=gen&lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
    if (typeof sl_map_params != "undefined") {
        searchUrl += sl_map_params
    }
    retrieveData(searchUrl, function(data) {
        var xml = data.responseXML;
        var markerNodes = xml.documentElement.getElementsByTagName('marker');
        clearLocations();
        var bounds = new google.maps.LatLngBounds();

        var point = new google.maps.LatLng(center.lat(), center.lng());
        var markerOpts = {
            map: sl_map,
            position: point,
            icon: sl_map_home_icon
        };
        if (typeof sl_marker_options != 'undefined' && typeof sl_marker_options === 'object') {
            markerOpts = mergeArray(sl_marker_options, markerOpts)
        }
        var icon = {
            url: sl_map_home_icon
        };
        bounds.extend(point);
        var homeMarker = new google.maps.Marker(markerOpts);
        determineShadow(icon, homeMarker);
        var html = '<div id="sl_info_bubble"><span class="your_location_label">Your Location:</span> <br/>' + homeAddress + '</div>';
        bindInfoWindow(homeMarker, sl_map, sl_info_window, html);
        var sidebar = document.getElementById('map_sidebar');
        sidebar.innerHTML = '';
        if (markerNodes.length == 0) {
            showLoadImg('stop', 'loadImg');
            sidebar.innerHTML = '<div class="text_below_map">' + sl_no_results_found_message + '</div>';
            sl_marker_array.push(homeMarker);
            sl_map.setCenter(point);
            return
        }
        for (var i = 0; i < markerNodes.length; i++) {
            var sl_details = buildDetails(markerNodes[i], i);
            sl_marker_type = markerNodes[i].getAttribute(sl_marker_categorization_field);
            if (sl_marker_type == "" || sl_marker_type == null) {
                sl_marker_type = "sl_map_end_icon"
            }
            var icon = (typeof sl_icons != 'undefined' && typeof sl_icons[sl_marker_type] != 'undefined') ? sl_icons[sl_marker_type] : {
                url: sl_map_end_icon,
                name: 'Default'
            };
            var marker = createMarker(sl_details, sl_marker_type, icon);
            var sidebarEntry = createSidebarEntry(marker, sl_details, showAll);
            sidebarEntry.id = "sidebar_div_" + i;
            sidebar.appendChild(sidebarEntry);
            bounds.extend(sl_details['point'])
        }
        sl_marker_array.push(homeMarker);
        sl_map.setCenter(bounds.getCenter());
        sl_map.fitBounds(bounds);
        sl_map.setZoom(15);
        showLoadImg('stop', 'loadImg')

    });
    if (function_exists("end_searchLocationsNear")) {
        end_searchLocationsNear()
    }
}
function createMarker(sl_details, type, icon) {
    var markerOpts = {
        map: sl_map,
        position: sl_details['point'],
        icon: icon.url
    };
    if (typeof sl_marker_options != 'undefined' && typeof sl_marker_options === 'object') {
        markerOpts = mergeArray(sl_marker_options, markerOpts)
    }
    var marker = new google.maps.Marker(markerOpts);
    determineShadow(icon, marker);
    if (function_exists("start_createMarker")) {
        start_createMarker()
    }
    html = buildMarkerHTML(sl_details);
    bindInfoWindow(marker, sl_map, sl_info_window, html);
    sl_marker_array.push(marker);
    if (function_exists("end_createMarker")) {
        end_createMarker()
    }
    return marker
}
var resultsDisplayed = 0;
var bgcol = "white";

function createSidebarEntry(marker, sl_details, showAll) {
    if (function_exists("start_createSidebarEntry")) {
        start_createSidebarEntry()
    }
    if (document.getElementById('map_sidebar_td') != null) {
        document.getElementById('map_sidebar_td').style.display = 'block'
    }
    var div = document.createElement('div');
    var html = buildSidebarHTML(sl_details, showAll);
    div.innerHTML = html;
    div.className = 'results_entry';
    div.setAttribute('name', 'results_entry');
    resultsDisplayed++;
    google.maps.event.addDomListener(div, 'click', function() {
        google.maps.event.trigger(marker, 'click')
    });
    if (function_exists("end_createSidebarEntry")) {
        end_createSidebarEntry()
    }

    return div
}
function retrieveData(url, callback) {
    var request = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
            if (function_exists("end_retrieveData")) {
                end_retrieveData()
            }
        }
    };
    request.open('GET', url, true);
    request.send(null)
}
function doNothing() {}
function bindInfoWindow(marker, map, infoWindow, html) {
    var infowindow_click_function = function() {
            infoWindow.close();
            infoWindow.setContent(html);
            if (typeof sl_infowindow_options != 'undefined' && typeof sl_infowindow_options === 'object') {
                infoWindow.setOptions(sl_infowindow_options)
            }
            infoWindow.open(map, marker)
        };
    google.maps.event.addListener(marker, 'click', infowindow_click_function);
    google.maps.event.addListener(marker, 'visible_changed', function() {
        infoWindow.close()
    })
}
function clearLocations() {
    sl_info_window.close();
    for (var i = 0; i < sl_marker_array.length; i++) {
        sl_marker_array[i].setMap(null)
    }
    sl_marker_array.length = 0
}
function determineShadow(icon, marker) {
    if (icon.url.indexOf('flag') != '-1') {
        marker.setShadow(sl_base + "/icons/flag_shadow_v3.png")
    } else if (icon.url.indexOf('arrow') != '-1') {
        marker.setShadow(sl_base + "/icons/arrow_shadow_v3.png")
    } else if (icon.url.indexOf('bubble') != '-1') {
        marker.setShadow(sl_base + "/icons/bubble_shadow_v3.png")
    } else if (icon.url.indexOf('marker') != '-1') {
        marker.setShadow(sl_base + "/icons/marker_shadow_v3.png")
    } else if (icon.url.indexOf('sign') != '-1') {
        marker.setShadow(sl_base + "/icons/sign_shadow_v3.png")
    } else if (icon.url.indexOf('droplet') != '-1') {
        marker.setShadow(sl_base + "/icons/droplet_shadow_v3.png")
    } else {
        marker.setShadow(sl_base + "/icons/blank.png")
    }
}
function map_type_check() {
    if (sl_map_type == 'G_NORMAL_MAP') {
        sl_map_type_v3 = google.maps.MapTypeId.ROADMAP
    } else if (sl_map_type == 'G_SATELLITE_MAP') {
        sl_map_type_v3 = google.maps.MapTypeId.SATELLITE
    } else if (sl_map_type == 'G_HYBRID_MAP') {
        sl_map_type_v3 = google.maps.MapTypeId.HYBRID
    } else if (sl_map_type == 'G_PHYSICAL_MAP') {
        sl_map_type_v3 = google.maps.MapTypeId.TERRAIN
    } else if (sl_map_type != google.maps.MapTypeId.ROADMAP && sl_map_type != google.maps.MapTypeId.SATELLITE && sl_map_type != google.maps.MapTypeId.HYBRID && sl_map_type != google.maps.MapTypeId.TERRAIN) {
        sl_map_type_v3 = google.maps.MapTypeId.ROADMAP
    } else {
        sl_map_type_v3 = sl_map_type
    }
}
function function_exists(func) {
    return eval("typeof window." + func + " === 'function'")
}
function is_array(arr) {
    return eval(typeof arr === 'object' && arr instanceof Array)
}
function empty(value) {
    return eval(typeof value === 'undefined')
}
function isset(value) {
    return eval(typeof value !== 'undefined')
}
function mergeArray(array1, array2) {
    for (item in array1) {
        array2[item] = array1[item]
    }
    return array2
}
function determineDirectionsLink(sl_details, html) {
    var homeAddress = sl_details['homeAddress'];
    if (homeAddress.split(" ").join("") != "") {
        html = html.split("sl_details['sl_directions_link']").join('\'<a href="http://' + sl_google_map_domain + '/maps?saddr=' + encodeURIComponent(homeAddress) + '&daddr=' + encodeURIComponent(sl_details['fullAddress']) + '" target="_blank" class="storelocatorlink">' + sl_directions_label + '</a>\'')
    } else {
        html = html.split("sl_details['sl_directions_link']").join('\'<a href="http://' + sl_google_map_domain + '/maps?q=' + encodeURIComponent(sl_details['fullAddress']) + '" target="_blank" class="storelocatorlink">Map</a>\'')
    }
    return html
}
if (!function_exists("buildSidebarHTML")) {
    function buildSidebarHTML(sl_details, showAll) {
        var street = sl_details['sl_address'];
        if (sl_details['sl_address2'].split(' ').join('') != "") {
            street += sl_details['sl_address2'] + '<br/>'
        }
        var city = sl_details['sl_city'];
        if (city.split(' ').join('') != "") {
            city += ', '
        } else {
            city = ""
        }
        var state_zip = sl_details['sl_state'] + ' ' + sl_details['sl_zip'];
        if (sl_details['fullAddress'].split(",").join("").split(" ").join("") == "") {
            sl_details['fullAddress'] = sl_details['sl_latitude'] + "," + sl_details['sl_longitude']
        }
        var homeAddress = sl_details['homeAddress'];
        var name = sl_details['sl_store'];
        var distance = sl_details['sl_distance'];
        var url = sl_details['sl_url'];
        var phone = sl_details['sl_phone'];
        var image = sl_details['sl_image'];
        if (url.search(/^https?\:\/\//i) != -1 && url.indexOf(".") != -1) {
            link = "&nbsp;|&nbsp;<a href='" + url + "' target='_blank' class='storelocatorlink'><nobr>" + sl_website_label + "</nobr></a>"
        } else {
            url = "";
            link = ""
        }
        sl_details['sl_distance_unit'] = sl_distance_unit;
        sl_details['sl_google_map_domain'] = sl_google_map_domain;
        if (function_exists("sl_results_template") && sl_results_template(sl_details)) {
            var html = decode64(sl_results_template(sl_details));
            html = determineDirectionsLink(sl_details, html);
            html = eval("'" + html + "'")
        } else {
            var distance_display = (distance.toFixed(1) != '' && distance.toFixed(1) != 'null' && distance.toFixed(1) != 'NaN') ? '<br>' + distance.toFixed(1) + ' ' + sl_distance_unit : "";
            var html = "";
            if (sl_details['tableHide'] > 2) {
                if (showAll) html += '<table class="tableStoreLocator">'
                else html += '<table class="tableStoreLocator storesTableLocator">'
            } else {
                html += '<table class="tableStoreLocator">'
            }
            html += '<tr><td><h4 class="titleListStockist">' + name + '</h4><p>' + street + ' ' + city + ' ' + state_zip + '<br/>' + phone + ' <br/><a class="stockistListUrl" href="' + url + '">' + url + '</a></p></td><td class="tdRightStore"><div class="carouselStock"><div class="slide"><img src="'+image+'"></div><div class="slide"><img src="'+image+'"></div><div class="slide"><img src="'+image+'"></div></div></td></tr></table>'

                     
        }
        return html
    }
}
if (function_exists("buildMarkerHTML") != true) {
    function buildMarkerHTML(sl_details) {
        var street = sl_details['sl_address'];
        if (street.split(' ').join('') != "") {
            street += '<br/>'
        } else {
            street = ""
        }
        if (sl_details['sl_address2'].split(' ').join('') != "") {
            street += sl_details['sl_address2'] + '<br/>'
        }
        var city = sl_details['sl_city'];
        if (city.split(' ').join('') != "") {
            city += ', '
        } else {
            city = ""
        }
        var state_zip = sl_details['sl_state'] + ' ' + sl_details['sl_zip'];
        if (sl_details['fullAddress'].split(",").join("").split(" ").join("") == "") {
            sl_details['fullAddress'] = sl_details['sl_latitude'] + "," + sl_details['sl_longitude']
        }
        var homeAddress = sl_details['homeAddress'];
        var name = sl_details['sl_store'];
        var distance = sl_details['sl_distance'];
        var url = sl_details['sl_url'];
        var image = sl_details['sl_image'];
        var description = sl_details['sl_description'];
        var hours = sl_details['sl_hours'];
        var phone = sl_details['sl_phone'];
        var fax = sl_details['sl_fax'];
        var email = sl_details['sl_email'];
        var more_html = "";
        if (url.search(/^https?\:\/\//i) != -1 && url.indexOf(".") != -1) {
            more_html += "| <a href='" + url + "' target='_blank' class='storelocatorlink'><nobr>" + sl_website_label + "</nobr></a>"
        } else {
            url = ""
        }
        if (image.indexOf(".") != -1) {
            more_html += "<br/><img src='" + image + "' class='sl_info_bubble_main_image'>"
        } else {
            image = ""
        }
        if (description != "") {
            more_html += "<br/>" + description + ""
        } else {
            description = ""
        }
        if (hours != "") {
            more_html += "<br/><span class='location_detail_label'>" + sl_hours_label + ":</span> " + hours
        } else {
            hours = ""
        }
        if (phone != "") {
            more_html += "<br/><span class='location_detail_label'>" + sl_phone_label + ":</span> " + phone
        } else {
            phone = ""
        }
        if (fax != "") {
            more_html += "<br/><span class='location_detail_label'>" + sl_fax_label + ":</span> " + fax
        } else {
            fax = ""
        }
        if (email != "") {
            more_html += "<br/><span class='location_detail_label'>" + sl_email_label + ":</span> " + email
        } else {
            email = ""
        }
        sl_details['sl_more_html'] = more_html;
        sl_details['sl_distance_unit'] = sl_distance_unit;
        sl_details['sl_google_map_domain'] = sl_google_map_domain;
        if (function_exists("sl_bubble_template") && sl_bubble_template(sl_details)) {
            sl_details['sl_distance'] = distance.toFixed(1);
            var html = decode64(sl_bubble_template(sl_details));
            html = determineDirectionsLink(sl_details, html);
            html = eval("'" + html + "'")
        } else {
            var html = '<div id="sl_info_bubble"><h3 class="titleBubbleHeader"><strong>' + name + '</strong></h3><strong>' + street + city + state_zip + '</strong><br/>' + phone + '<br/><span class="urlBubble"><strong><a href="' + url + '">' + url + '</a></strong></span></div>'
        }
        return html
    }
}
if (function_exists("buildDetails") != true) {
    function buildDetails(markerNode, iterator) {
        var details_array = {
            'tableHide': iterator,
            'fullAddress': markerNode.getAttribute('address'),
            'sl_address': markerNode.getAttribute('street'),
            'sl_address2': markerNode.getAttribute('street2'),
            'sl_city': markerNode.getAttribute('city'),
            'sl_state': markerNode.getAttribute('state'),
            'sl_zip': markerNode.getAttribute('zip'),
            'sl_latitude': markerNode.getAttribute('lat'),
            'sl_longitude': markerNode.getAttribute('lng'),
            'sl_store': markerNode.getAttribute('name'),
            'sl_description': markerNode.getAttribute('description'),
            'sl_url': markerNode.getAttribute('url'),
            'sl_hours': markerNode.getAttribute('hours'),
            'sl_phone': markerNode.getAttribute('phone'),
            'sl_fax': markerNode.getAttribute('fax'),
            'sl_email': markerNode.getAttribute('email'),
            'sl_image': markerNode.getAttribute('image'),
            'sl_tags': markerNode.getAttribute('tags'),
            'sl_distance': parseFloat(markerNode.getAttribute('distance')),
            'homeAddress': document.getElementById('addressInput').value,
            'point': new google.maps.LatLng(parseFloat(markerNode.getAttribute('lat')), parseFloat(markerNode.getAttribute('lng')))
        };
        if (typeof sl_xml_properties_array != "undefined") {
            if (is_array(sl_xml_properties_array)) {
                for (key in sl_xml_properties_array) {
                    details_array[sl_xml_properties_array[key]] = markerNode.getAttribute(sl_xml_properties_array[key])
                }
            }
        }
        details_array = sl_details_filter(details_array);
        return details_array
    }
}