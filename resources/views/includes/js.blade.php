<script type="text/javascript" src="{{ asset('assets/scripts/new/bootstrap4.6.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/scripts/new/popper1.16.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/scripts/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/scripts/custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/scripts/new/jquery.cookie.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/scripts/new/swiper.min.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('assets/scripts/new/nouislider.min.js') }}"></script> --}}
<script type="text/javascript" src="{{ asset('assets/scripts/new/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/scripts/new/color-scheme-demo.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('assets/scripts/new/pwa-services.js') }}"></script> --}}
<script src="{{asset('admin/js/persian-date.min.js')}}"></script>
<script src="{{asset('admin/js/persian-datepicker.min.js')}}"></script>

<script>
    "use strict"
    $(window).on('load', function() {

        /* range picker for filter */
        var html5Slider = document.getElementById('rangeslider');
        // noUiSlider.create(html5Slider, {
        //     start: [0, 100],
        //     connect: true,
        //     range: {
        //         'min': 0,
        //         'max': 500
        //     }
        // });

        var inputNumber = document.getElementById('input-number');
        var select = document.getElementById('input-select');

        // html5Slider.noUiSlider.on('update', function(values, handle) {
        //     var value = values[handle];

        //     if (handle) {
        //         inputNumber.value = value;
        //     } else {
        //         select.value = Math.round(value);
        //     }
        // });
        // select.addEventListener('change', function() {
        //     html5Slider.noUiSlider.set([this.value, null]);
        // });
        // inputNumber.addEventListener('change', function() {
        //     html5Slider.noUiSlider.set([null, this.value]);
        // });


        /* carousel */
        var swiper = new Swiper('.swiper-products', {
            slidesPerView: 'auto',
            spaceBetween: 0,
            pagination: 'false'
        });

    });
</script>
<script>
    @if (auth()->user())
        function loadDoc() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                console.log( this.responseText );
            }
            xhttp.open("GET", '{{url("/")."/update-roll-call"}}');
            xhttp.send();
            setTimeout(loadDoc, 100000);
        }
        loadDoc();
        
        function checkCalendar( offDays , offDays2 ) {
            // جدول تقویم
            let calendars = document.querySelectorAll('.table-days tbody tr td');
            if (Array(calendars).length) {
                    
                // تقویم ها رو میگیره و روز تعطیل رو درست میکنه
                calendars.forEach( (calendar, counter)  => {
                    // اعمال روز تعطیل برای هر هفنه
                    if (offDays.length) {
                        
                        if ( counter % 7 == 0 && counter > 0 ) {
                            for (let index = 0; index < offDays.length; index++) {
                                offDays[index] += 7;
                            }
                        }
                        // خالی کردن مقدار دکمه تقویم
                        if ( offDays.includes(counter) ) {
                            calendar.setAttribute('data-unix', null);
                            calendar.setAttribute('data-date', null);
                            calendar.addEventListener( 'click', e => {
                            })
                            // تغییر سی اس اس
                            calendar.children[0].classList.add('bg-danger');
                            calendar.children[0].classList.add('text-white');
                        }
                    
                    }
                    if (offDays2.length) {

                        // خالی کردن مقدار دکمه تقویم
                        if ( offDays2.includes( calendar.getAttribute('data-date') ) ) {
                            calendar.setAttribute('data-unix', null);
                            calendar.setAttribute('data-date', null);
                            calendar.addEventListener( 'click', e => {
                            })
                            // تغییر سی اس اس
                            calendar.children[0].classList.add('bg-danger');
                            calendar.children[0].classList.add('text-white');
                        }
                        
                    }
                })
                console.log('run checkCalendar')
                setTimeout(() => { checkCalendar( @json($offDaysList) , @json($offDaysList2) ); }, 3000);

            }
        }
        
        document.querySelector('.flex-shrink-0').addEventListener( 'click', e => {
            checkCalendar( @json($offDaysList) , @json($offDaysList2) );
        })
            

    @endif

    if ($('.carousel')[0]) {
        $('.carousel').carousel({ interval: 3000 })
    }
    $('.date_p').persianDatepicker({
        observer: true,
        format: 'YYYY/MM/DD',
        altField: '.observer-example-alt',
        initialValue:false,
    }); 
    $(document).ready(function () {
        $('select[name=state_id]').on('change', function () {
            $.get("{{url('/')}}/city-ajax/" + $(this).val(), function (data, status) {
                $('select[name=city_id]').empty();
                $.each(data, function (key, value) {
                    $('select[name=city_id]').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                $('select[name=city_id]').trigger('change');
            });
        });
    });
</script>
@yield('js')
