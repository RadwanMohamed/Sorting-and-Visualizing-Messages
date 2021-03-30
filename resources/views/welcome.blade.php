<!DOCTYPE html>
<html>
<head>
    <title>Custom Markers</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <style>
        #map {
            height: 100%;
        }

        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

    </style>
</head>
<body>
<div id="map"></div>

<!-- Async script executes immediately and must be after any DOM elements used in callback. -->
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJX9QlWUokfa9TQcz2ZDMFZ9RypFDHDLs&callback=initMap&libraries=&v=weekly"
    async
></script>
<script>
    let map;

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: new google.maps.LatLng(-33.91722, 151.23064),
            zoom: 16,
        });
        const icons = {
            Neutral: {
                icon: "{{url('/img/map_normal.png')}}",
            },
            Negative: {
                icon: "{{url('/img/map_sad.png')}}",
            },
            Positive: {
                icon: "{{url('/img/map_smile.png')}}",
            },
        };
        const features = [
                @foreach($data as $value)
            {
                position: new google.maps.LatLng(parseFloat("{{$value['location']['lat']}}"),parseFloat("{{$value['location']['lng']}}")),
                type: "{{$value['sentiment']}}",
            },
            @endforeach
        ];
        console.log(features);
        // Create markers.
        for (let i = 0; i < features.length; i++) {
            console.log(features[i]);
            const marker = new google.maps.Marker({
                position: features[i].position,
                icon: icons[features[i].type].icon,
                map: map,
            });
        }
    }
</script>
</body>
</html>


