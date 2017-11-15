@extends('layouts.site')

@section('styles')
<link rel="stylesheet" type="text/css" href="/assets/css/sweetalert2.min.css">
@endsection

@section('content')
<div id="content" class="no-bottom no-top">
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="animated" data-animation="fadeInLeft">Kontakt
                        <span class="small-border"></span>
                    </h1>
                    <div class="spacer-single"></div>
                </div>
                <div class="col-md-6">
                    <form name="contactForm" id='contact_form' method="POST" action='{{ route('contact.form') }}'>
                        {{ csrf_field() }}
                        <div><input type='text' name='sender_name' class="form-control" placeholder="Vaše ime" required></div>
                        <div><input style="color:white !important;" type='email' name='sender_email' class="form-control" placeholder="Vaša e-mail adresa" required></div>
                        <div><input type='text' name='subject' class="form-control" placeholder="Naslov" required></div>
                        <div><textarea name='message' id='message' class="form-control" placeholder="Tekst poruke" required></textarea></div>
                        <div class="g-recaptcha" data-theme="dark" data-sitekey="6Lda4TgUAAAAAACDuNOjVJxFGA3EkUnKy2bl_Ymk"></div><br>
                        <div><input type='submit' id="submit" value='Pošalji' class="btn btn-primary"></div>
                    </form>
                </div>
                <br>
                <br>
                <br>
                <div class="col-md-6">
                    <address>
                        <span><i class="fa fa-map-marker fa-lg"></i>Zagrebačka 74, Oroslavje</span>
                        <span><i class="fa fa-phone fa-lg"></i>098 725 223</span>
                        <span><i class="fa fa-envelope-o fa-lg"></i><a style="direction: rtl; unicode-bidi: bidi-override;" href="mailto:info@ahelos.hr">rh.soleha@ofni</a></span>
                    </address>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="/assets/js/sweetalert2.min.js"></script>
<script>
    jQuery(document).ready(function($){
        $("form#contact_form").submit(function( event ) {
            event.preventDefault();
            $("#submit").html('<span class="icon-refresh spinning"></span> Slanje...');
            $("#submit").prop('disabled', true);
            var formData = new FormData(this);
            var token = $('#contact_form > input[name="_token"]').val();
            $.ajax({
                type: 'POST',
                url: $("#contact_form").attr('action'),
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                headers: {'X-CSRF-TOKEN': token},
                data: formData,
                error: function(){
                    console.log("error");
                    console.log(formData);
                    $("#submit").html('Provjeri i pošalji poruku');
                    $("#submit").prop('disabled', false);
                },
                success: function(data) {
                    console.log("success");
                    console.log(data);
                    if(data.status === "success") {
                        swal("Uspjeh!", "Poruka je uspješno poslana!", "success");
                    }
                    else
                    {
                        var failStart = "";
                        $.each(data.errors, function(index, value) {
                            $.each(value,function(i){
                                failStart += value[i]+"\n";
                            });

                        });
                        swal("Poruka nije poslana! Popravite sljedeće pogreške:", failStart, "error");
                    }
                    $("#submit").html('Provjeri i pošalji poruku');
                    $("#submit").prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection
