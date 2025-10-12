@props(["extra"=>""])

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        {{ $logo }}
                    </div>

                    <div>
                        {{ $slot }}
                    </div>

                    <div class="text-center mt-3 d-none">
                        {{ $extra }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
