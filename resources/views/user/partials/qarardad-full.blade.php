<style>
    div.left input {
        text-align: left !important;
    }
</style>
<h4 class="mb-4">فرم ثبت قرارداد </h4>
{{ Form::open(array('route' => 'user.forms.store', 'method' => 'POST', 'files' => true)) }}
    <div id="cou_head3">مرحله 
        <span id="counter3">۱</span>
        از ۵
    </div>
    <div class="row">
        <input type="hidden" id="form_type" name="form_type" value="عقد قرارداد">
        <div id="first_name3" class="col-md-6">
            <div class="form-group">
                {{ Form::label('first_name', '* نام') }}
                {{ Form::text('first_name',null, array('class' => 'form-control', 'required' => 'required', 'id' => 'inp_first_name3')) }}
            </div>
        </div>
        <div id="last_name3" class="col-md-6 d-none">
            <div class="form-group">
                {{ Form::label('last_name', '* نام خانوادگی') }}
                {{ Form::text('last_name',null, array('class' => 'form-control', 'required' => 'required', 'id' => 'inp_last_name3')) }}
            </div>
        </div>
        <div id="education3" class="col-md-6 d-none">
            <div class="form-group">
                {{ Form::label('education', '* آخرین مدرک تحصیلی') }}
                {{ Form::text('education',null, array('class' => 'form-control', 'required' => 'required', 'id' => 'inp_education3')) }}
            </div>
        </div>
        <div id="whatsapp3" class="col-md-6 d-none">
            <div class="form-group left">
                {{ Form::label('whatsapp', '* شماره واتس اپ') }}
                {{ Form::number('whatsapp',null, array('class' => 'form-control ', 'required' => 'required', 'id' => 'inp_whatsapp3')) }}
            </div>
        </div>
        <div id="description3" class="col-md-12 d-none">
            <div class="form-group">
                {{ Form::label('description', '* لطفا مختصری درباره قرارداد مدنظر را بیان فرمایید') }}
                {{ Form::textarea('description',null, array('class' => 'form-control textarea', 'required' => 'required', 'id' => 'inp_description3')) }}
            </div>
        </div>
    </div>
    <p id="alert3" class="text-center d-none">ابتدا فیلد فرم را وارد کنید</p>
    <div class="row mb-3">
        <div class="col">
            <button id="confirm3" type="submit" class="btn btn-info col-12 d-none" >تایید</button>
            <button id="next3" type="button" class="btn btn-danger col-12" onclick="nextStep3()">بعدی</button>
        </div>
        <div class="col">
            <button type="button" class="btn btn-secondary col-12" data-dismiss="modal">انصراف</button>
        </div>
    </div>
{{ Form::close() }} 

<script>
    var counter3 = 1;
    function nextStep3() {
        var access = false;
        switch (counter3) {
            case 1:
                if( (document.getElementById("inp_first_name3").value).length > 0) {
                    document.getElementById("first_name3").classList.add("d-none");
                    document.getElementById("last_name3").classList.remove("d-none");
                    access = true;
                }
                break;
            case 2:
                if( (document.getElementById("inp_last_name3").value).length > 0) {
                    document.getElementById("last_name3").classList.add("d-none");
                    document.getElementById("education3").classList.remove("d-none");
                    access = true;
                }
                break;
            case 3:
                if( (document.getElementById("inp_education3").value).length > 0) {
                    document.getElementById("education3").classList.add("d-none");
                    document.getElementById("whatsapp3").classList.remove("d-none");
                    access = true;
                }
                break;
            case 4:
                if( (document.getElementById("inp_whatsapp3").value).length > 0) {
                    document.getElementById("whatsapp3").classList.add("d-none");
                    document.getElementById("description3").classList.remove("d-none");
                    access = true;
                }
                break;
        }
        if (access) {
            document.getElementById("alert3").classList.add("d-none");
            counter3 += 1;
            var num = '۲';
            switch (counter3) {
                case 3:
                    num = '۳';
                    break;
                case 4:
                    num = '۴';
                    break;
                case 5:
                    num = '۵';
                    break;
            }
            document.getElementById("counter3").innerHTML = num;
            if (counter3==5) {
                document.getElementById("confirm3").classList.remove("d-none");
                document.getElementById("next3").classList.add("d-none");
            }
        } else {
            document.getElementById("alert3").classList.remove("d-none");
        }
    }
</script>