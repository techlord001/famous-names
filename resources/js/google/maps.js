(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
    key: googleMapsApiKey,
    v: "weekly",
});


document.addEventListener('DOMContentLoaded', function() {
    let famousName;
    let lat;
    let lng;
    let viewButtons = document.querySelectorAll('.view-btn');
    
    viewButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            console.log('success');
            famousName = e.target.getAttribute('data-name');
            lat = parseFloat(e.target.getAttribute('data-lat'));
            lng = parseFloat(e.target.getAttribute('data-lng'));
            
            initMap(famousName, lat, lng);
        });
    });
});


async function initMap(famousName, lat, lng) {
    let map;

    const {
        Map
    } = await google.maps.importLibrary("maps");

    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

    const position = {
        lat: lat,
        lng: lng
    };

    map = new Map(document.getElementById("map"), {
        center: position,
        zoom: 8,
        mapId: "Famous Name Location",
    });

    const contentString = '<div><h5>' + famousName + '</h5><p>Latitude: ' + lat + '</p><p>Longitude: ' + lng + '</p></div>';


    const infowindow = new google.maps.InfoWindow({
        content: contentString,
        ariaLabel: "Famous Name Information",
    });


    const marker = new AdvancedMarkerElement({
        map: map,
        position: position,
        title: "Famous Name Information",
    });

    marker.addListener("click", () => {
        infowindow.open({
        anchor: marker,
        map,
        });
    });
}