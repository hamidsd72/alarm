@extends('layouts.admin')
<link rel="stylesheet" href="https://cdn.map.ir/web-sdk/1.4.2/css/mapp.min.css">
<link rel="stylesheet" href="https://cdn.map.ir/web-sdk/1.4.2/css/fa/style.css">
@section('css')
@endsection
@section('content')
<div id="app"></div>
@endsection
@section('js')

<script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/mapp.env.js"></script>
<script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/mapp.min.js"></script>
<script>
     $(document).ready(function() {
  var app = new Mapp({
    element: '#app',
    presets: {
      latlng: {
        lat: @json($lat),
        lng: @json($lng)
      },
      zoom: 16
    },
    apiKey: @json($map_api_key)
  });
  app.addLayers();
  app.map.on('click', function(e) {
    // آدرس یابی و نمایش نتیجه در یک باکس مشخص
    // app.showReverseGeocode({
    //   state: {
    //     latlng: {
    //       lat: e.latlng.lat,
    //       lng: e.latlng.lng
    //     },
    //     zoom: 16
    //   }
    // });
    // app.addMarker({
    //   name: 'advanced-marker',
    //   latlng: {
    //     lat: e.latlng.lat,
    //     lng: e.latlng.lng
    //   },
    //   icon: app.icons.red,
    //   popup: false
    // });

    // برای سفارشی سازی نمایش نتیجه به جای متد بالا از متد زیر میتوان استفاده کرد

    app.findReverseGeocode({
      state: {
        latlng: {
          lat: e.latlng.lat,
          lng: e.latlng.lng
        },
        zoom: 16
      },
      after: function(data) {
        $("#long_lat").val(`${e.latlng.lat},${e.latlng.lng}`);
        app.addMarker({
          name: 'advanced-marker',
          latlng: {
            lat: e.latlng.lat,
            lng: e.latlng.lng
          },
          icon: app.icons.red,
          popup: {
            title: {
              i18n: 'آدرس '
            },
            description: {
              i18n: data.address
            },
            class: 'marker-class',
            open: true
          }
        });
      }
    });
  });
});

</script>
@endsection