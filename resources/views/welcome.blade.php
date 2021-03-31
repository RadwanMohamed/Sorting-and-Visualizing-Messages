<!DOCTYPE html>
<html>
<head>
    <title>sorting</title>
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
    src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&callback=initMap&libraries=&v=weekly"
    async
></script>
<script>
    let map;

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: new google.maps.LatLng(26.8206, 30.8025),
            zoom: 2,
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

                text :  {
                    color: "{{$value['color']}}",
                    fontWeight: 'bold',
                    text:  "{{$value['message']}}",
                    fontSize: '10px',
                },

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
                label:  features[i].text,
            });
        }
    }
</script>
</body>
</html>


