@extends('frontpage.layouts.main')

@section('content')
<div class="hero-wrap ftco-degree-bg" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/images/rent.png');" data-stellar-background-ratio="0.5">
  <div class="container">
    <div class="row no-gutters slider-text justify-content-start align-items-center justify-content-center">
      <div class="col-lg-8 ftco-animate">
        <div class="text w-100 text-center mb-md-5 pb-md-5">
          <h1 class="mb-4" style="color: white;">SURE I DON'T MISS STAYCATION IN BALI ?</h1>
          <p style="font-size: 18px; color: white;">Cheap quality motorbike rental</p>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="ftco-section ftco-no-pt bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 heading-section text-center ftco-animate mb-5">
        <span class="subheading">WHAT WE OFFER</span>
        <h2 class="mb-2">Featured Vehicles</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="carousel-car owl-carousel">
            @foreach ($motors as $motor)
            <div class="item">
                <div class="car-wrap rounded ftco-animate">
                    @if ($motor['nama_motor'] == 'Nmax')
                      <div class="img rounded d-flex align-items-end" style="background-image: url(../assets/images/nmax_abu.jpg);">
                    @elseif($motor['nama_motor'] == 'Lexi')
                      <div class="img rounded d-flex align-items-end" style="background-image: url(../assets/images/lexi.jpg);">
                    @elseif($motor['nama_motor'] == 'Beat')
                      <div class="img rounded d-flex align-items-end" style="background-image: url(../assets/images/beat3.jpg);">
                    @elseif($motor['nama_motor'] == 'Scoopy')
                      <div class="img rounded d-flex align-items-end" style="background-image: url(../assets/images/scopy_putih.jpg);">
                    @elseif($motor['nama_motor'] == 'ADV')
                      <div class="img rounded d-flex align-items-end" style="background-image: url(../assets/images/ADV.jpg);">
                    @elseif($motor['nama_motor'] == 'PCX')
                      <div class="img rounded d-flex align-items-end" style="background-image: url(../assets/images/pcx1.jpg);">
                    @elseif($motor['nama_motor'] == 'Vario')
                      <div class="img rounded d-flex align-items-end" style="background-image: url(../assets/images/vario.webp);">
                    @endif
                    
                  </div>
                  <div class="text">
                    <h2 class="mb-0"><a href="car-single.html">{{ $motor['nama_motor'] }} {{ $motor['cc'] }} cc.</a></h2>
                    <div class="d-flex mb-3">
                        <span class="text-bold">{{ $motor['tipe'] }}</span>
                        <p class="price ml-auto">Rp {{ number_format($motor['harga_sewa'], 0, ',', '.') }} <span>/day</span></p>
                    </div>
                    <div class="d-flex mb-3">
                        @if ($motor['status'] == 1)
                            <span class="badge bg-success">Available</span>
                        @else
                            <span class="badge bg-secondary">For Rent</span>
                        @endif
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <a href="/view-motor" class="btn btn-primary py-2 ">
                            Details
                        </a>
                    </div>
                    
                    </div>
                </div>
              </div>
            @endforeach
          
          
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section ftco-about">
  <div class="container">
    <div class="row no-gutters">
      <div class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url(assets/images/gambar9.jpg);">
      </div>
      <div class="col-md-6 wrap-about ftco-animate">
        <div class="heading-section heading-section-white pl-md-5">
          <span class="subheading">About us</span>
          <h2 class="mb-4">Bali motorbike rental is CHEAP & EASY</h2>

          <p>CHEAP Bali motorbike rental with QUALITY units 24 hours a day. Rentals We always ensure comfort for customers by providing several free facilities such as driving the vehicle to the consumer's hotel, ensuring raincoats are available on the motorbike seats, and free fuel.</p>
          <p><a href="/about" class="btn btn-primary py-3 px-4">Readmore...</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-md-7 text-center heading-section ftco-animate">
        <span class="subheading">Services</span>
        <h2 class="mb-3">Why Choose Our Rental?</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="services services-2 w-100 text-center">
          <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-wedding-car"></span></div>
          <div class="text w-100">
            <h3 class="heading mb-2">Trusted & Safe</h3>
            <p>As one of the experienced motorbike rental services in Bali, we have been trusted by many clients in terms of motorbike rental according to what is needed. No kidding, fast process, and direct service.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="services services-2 w-100 text-center">
          <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-transportation"></span></div>
          <div class="text w-100">
            <h3 class="heading mb-2">Fast & Easy Booking Process</h3>
            <p>You can use the Tel, Email or Whatsapp services to make a motorbike rental reservation in Bali. So this can save you time looking for motorbike rental in Bali.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="services services-2 w-100 text-center">
          <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-car"></span></div>
          <div class="text w-100">
            <h3 class="heading mb-2">Vehicles In Prime Condition</h3>
            <p>For the condition of the vehicle itself, we are also very detailed, starting from maintenance, cleanliness, to the engines. So don't be afraid if the vehicle will experience complaints during use.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="services services-2 w-100 text-center">
          <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-transportation"></span></div>
          <div class="text w-100">
            <h3 class="heading mb-2">Routine Care</h3>
            <p>To provide satisfaction to consumers. The motorbikes that we rent are always checked and carried out periodic maintenance to official dealers. So consumers can use motorbikes comfortably and safely while in Bali.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-md-7 heading-section text-center ftco-animate">
        <span class="subheading">Gallery</span>
        <h2>Damar Motorbike Rental</h2>
      </div>
    </div>
    <div class="row d-flex">
      <div class="col-md-4 d-flex ftco-animate">
        <div class="blog-entry justify-content-end">
          <a href="blog-single.html" class="block-20" style="background-image: url('assets/images/rental1.jpg');">
          </a>
          <div class="text pt-4">
            <div class="meta mb-3">
          </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 d-flex ftco-animate">
        <div class="blog-entry justify-content-end">
          <a href="blog-single.html" class="block-20" style="background-image: url('assets/images/rental2.jpg');">
          </a>
          <div class="text pt-4">
            <div class="meta mb-3">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 d-flex ftco-animate">
        <div class="blog-entry justify-content-end">
          <a href="blog-single.html" class="block-20" style="background-image: url('assets/images/rental4.jpg');">
          </a>
          <div class="text pt-4">
            <div class="meta mb-3">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 d-flex ftco-animate">
        <div class="blog-entry justify-content-end">
          <a href="blog-single.html" class="block-20" style="background-image: url('assets/images/rental5.jpg');">
          </a>
          <div class="text pt-4">
            <div class="meta mb-3">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 d-flex ftco-animate">
        <div class="blog-entry justify-content-end">
          <a href="blog-single.html" class="block-20" style="background-image: url('assets/images/rental6.jpg');">
          </a>
          <div class="text pt-4">
            <div class="meta mb-3">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 d-flex ftco-animate">
        <div class="blog-entry">
          <a href="blog-single.html" class="block-20" style="background-image: url('assets/images/rental3.jpg');">
          </a>
          <div class="text pt-4">
            <div class="meta mb-3">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>	
@endsection