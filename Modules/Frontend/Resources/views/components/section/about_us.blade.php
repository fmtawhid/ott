<div class="page-title">
        <h4 class="m-0 text-center">About Us</h4>
</div>
<div class="container">
    <div class="d-flex justify-content-between  flex-md-row flex-column-reverse">
        <div class="about-content p-5">  
                    <h4>{{$about_us}}</h4>
                    <p>Zatra TV is your go-to destination for an immersive and personalized entertainment experience. With a
                        vast library of movies, TV shows, documentaries, and original content, we offer something for
                        everyone.</p>
                        <div class="about-btn">
                            <button class="btn btn-primary">Explore More</button>
                        </div>
        </div>
        <img alt="images" src="../img/web-img/about1.png" class="img-fluid object-cover">
    </div>
</div>
<div id="card_sets_apart">
    <div class="section-spacing">
        <div class="container">
            <div class="text-center">
                <h4 class="fw-medium mb-4">What Sets Us Apart</h4>
                <p class="mb-5">Our mission is to connect people with the stories they love, anytime, anywhere. We strive to provide a seamless and enjoyable streaming experience that caters to diverse tastes and preferences</p>
            </div>
            <div class="row gy-4 row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-4">
                <div class="col">
                     @include('frontend::components.card.card_sets_apart',['sets_us_apart' => 'What Sets Us Apart'])
                </div>
                <div class="col">
                     @include('frontend::components.card.card_sets_apart',['sets_us_apart' => 'What Sets Us Apart'])
                </div>
                <div class="col">
                     @include('frontend::components.card.card_sets_apart',['sets_us_apart' => 'What Sets Us Apart'])
                </div>
                <div class="col">
                     @include('frontend::components.card.card_sets_apart',['sets_us_apart' => 'What Sets Us Apart'])
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section-spacing">
    <div class="container-fluid">
            <div class="row align-items-center align-content-center" style="background-image: url('../img/web-img/about_us_bg.jpg');  background-repeat: no-repeat; background-size: cover;">
                <div class="col-lg-6">
                    <div class="p-5">
                        <h4>Download Our Amazing OTT App, Unlimited Entertainment at Your Fingertips</h4>
                        <p>Experience endless entertainment with our amazing OTT app. Stream movies, shows, and more anytime, anywhere.</p>
                        <div class="about-app-btn">
                            <button ></button>
                        </div>  
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="../img/web-img/about-download-app.png" alt="about image">
                </div>
            </div>
    </div>
</div>

<div id="card_passionate_people">
    <div class="section-spacing-bottom">
        <div class="container">
            <div>
                <h4 class="fw-medium text-center mb-4">The Passionate People Powering Zatra TV</h4>
            </div>
            <div class="row gy-4 row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-4">
                <div class="col">
                    @include('frontend::components.card.card_passionate_people',['card_passionate_people' => 'The Passionate People Powering Zatra TV'])
                </div>
                <div class="col">
                    @include('frontend::components.card.card_passionate_people',['card_passionate_people' => 'The Passionate People Powering Zatra TV'])
                </div>
                <div class="col">
                    @include('frontend::components.card.card_passionate_people',['card_passionate_people' => 'The Passionate People Powering Zatra TV'])
                </div>
                <div class="col">
                    @include('frontend::components.card.card_passionate_people',['card_passionate_people' => 'The Passionate People Powering Zatra TV'])
                </div>
            </div>
        </div>
    </div>
</div>