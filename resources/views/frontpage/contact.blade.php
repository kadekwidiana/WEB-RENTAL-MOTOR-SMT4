@extends('frontpage.layouts.main')

@section('content')
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('assets/images/kontak2.png');" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
      <div class="col-md-9 ftco-animate pb-5">
        <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Contact <i class="ion-ios-arrow-forward"></i></span></p>
        <h1 class="mb-3 bread">Contact Us</h1>
      </div>
    </div>
  </div>
</section>
<section class="ftco-section contact-section">
  <div class="container">
    <div class="row block-9">
      <div class="col-md-6 order-md-last d-flex">
        <form action="{{ route('contact-admin.store') }}" method="POST" class="bg-light p-5 contact-form" onsubmit="return validateForm();">
          @csrf
          @if(session('message'))
          <div class="alert alert-success mt-3">
            {{ session('message') }}
          </div>
          @endif
          <div class="form-group">
            <input type="text" name="nama" class="form-control" placeholder="Nama" required>
          </div>
          <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
          </div>
          <div class="form-group">
            <input type="text" name="subjek" class="form-control" placeholder="Subjek" required>
          </div>
          <div class="form-group">
            <textarea name="pesan" id="" cols="30" rows="7" class="form-control" placeholder="Pesan" required></textarea>
          </div>
          <div class="form-group">
            <input type="submit" value="Kirim Pesan" class="btn btn-primary py-3 px-5">
          </div>
          <div class="form-group">
            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITEKEY') }}"></div>
          </div>
        </form>
      </div>
      <div class="col-md-6">
        <div class="row d-flex mb-5 contact-info">
          <div class="col-md-12">
            <div class="border w-100 p-4 rounded mb-2 d-flex">
              <div class="icon mr-3">
                <span class="icon-map-o"></span>
              </div>
              <p><span>Alamat:</span>Jl.Tirta Tawar 108, Br.Kutuh Kaja, Ubud, Gianyar, Bali-Indonesia</p>
            </div>
          </div>
          <div class="col-md-12">
            <div class="border w-100 p-4 rounded mb-2 d-flex">
              <div class="icon mr-3">
                <span class="icon-mobile-phone"></span>
              </div>
              <p><span>No.Telpon:</span> <a href="tel://1234567920">+62 87 760 606 090</a></p>
            </div>
          </div>
          <div class="col-md-12">
            <div class="border w-100 p-4 rounded mb-2 d-flex">
              <div class="icon mr-3">
                <span class="icon-envelope-o"></span>
              </div>
              <p><span>Email:</span> <a href="mailto:info@yoursite.com">damarmotorbikerental@gmail.com</a></p>
            </div>
          </div>
        </div>
        <div class="row d-flex mb-5 contact-info">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63136.55239133598!2d115.224753560492!3d-8.496024084965537!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23d739f22c9c3%3A0x54a38afd6b773d1c!2sUbud%2C%20Kecamatan%20Ubud%2C%20Kabupaten%20Gianyar%2C%20Bali!5e0!3m2!1sid!2sid!4v1687055968281!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
  function validateForm() {
    var response = grecaptcha.getResponse();
    if (response.length === 0) {
      alert("Mohon centang verifikasi reCAPTCHA.");
      return false;
    } else {
      return true;
    }
  }
</script>
@endsection

