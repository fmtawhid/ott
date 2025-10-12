@extends('frontend::layouts.auth_layout')

@section('content')

<div class="profile-section section-spacing d-flex flex-column justify-content-center">
    <div class="container">
        <div class="text-center mb-5">
            <div class="mb-5 pb-5">
                @include('frontend::components.partials.logo')
            </div>
            <h4 class="mb-0">Who is Streaming?</h4>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 justify-content-center gy-5">
                    <div class="col">
                        <div class="card profil-card">
                            <div class="card-body text-center">
                                <div class="profile-card-image">
                                    <img src="../img/web-img/user-img.png" alt="profile-image">
                                </div>
                                <h5 class="mt-3 mb-4 font-size-18">Noah</h5>
                                <button class="btn p-0 h6 mb-0" data-bs-toggle="modal" data-bs-target="#selectProfileModal">
                                    <span class="d-flex align-items-center gap-2">
                                        <span><i class="ph ph-pencil-simple-line"></i></span>
                                        <span>Edit</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card profil-card">
                            <div class="card-body text-center">
                                <div class="profile-card-image">
                                    <img src="../img/web-img/user-img.png" alt="profile-image">
                                </div>
                                <h5 class="mt-3 mb-4 font-size-18">Noah</h5>
                                <button class="btn p-0 h6 mb-0" data-bs-toggle="modal" data-bs-target="#selectProfileModal">
                                    <span class="d-flex align-items-center gap-2">
                                        <span><i class="ph ph-pencil-simple-line"></i></span>
                                        <span>Edit</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card profil-card">
                            <div class="card-body text-center">
                                <div class="profile-card-image">
                                    <img src="../img/web-img/user-img.png" alt="profile-image">
                                </div>
                                <h5 class="mt-3 mb-4 font-size-18">Noah</h5>
                                <button class="btn p-0 h6 mb-0" data-bs-toggle="modal" data-bs-target="#selectProfileModal">
                                    <span class="d-flex align-items-center gap-2">
                                        <span><i class="ph ph-pencil-simple-line"></i></span>
                                        <span>Edit</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card profil-card">
                            <div class="card-body text-center">
                                <div class="profile-card-image">
                                    <img src="../img/web-img/user-img.png" alt="profile-image">
                                </div>
                                <h5 class="mt-3 mb-4 font-size-18">Noah</h5>
                                <button class="btn p-0 h6 mb-0" data-bs-toggle="modal" data-bs-target="#selectProfileModal">
                                    <span class="d-flex align-items-center gap-2">
                                        <span><i class="ph ph-pencil-simple-line"></i></span>
                                        <span>Edit</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card profil-card">
                            <div class="card-body text-center">
                                <div class="profile-card-image">
                                    <img src="../img/web-img/user-img.png" alt="profile-image">
                                </div>
                                <h5 class="mt-3 mb-4 font-size-18">Noah</h5>
                                <button class="btn p-0 h6 mb-0" data-bs-toggle="modal" data-bs-target="#selectProfileModal">
                                    <span class="d-flex align-items-center gap-2">
                                        <span><i class="ph ph-pencil-simple-line"></i></span>
                                        <span>Edit</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card profil-card">
                            <div class="card-body text-center">
                                <div class="profile-card-image">
                                    <img src="../img/web-img/user-img.png" alt="profile-image">
                                </div>
                                <h5 class="mt-3 mb-4 font-size-18">Noah</h5>
                                <button class="btn p-0 h6 mb-0" data-bs-toggle="modal" data-bs-target="#selectProfileModal">
                                    <span class="d-flex align-items-center gap-2">
                                        <span><i class="ph ph-pencil-simple-line"></i></span>
                                        <span>Edit</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card profil-card cursor-pointer" data-bs-toggle="modal" data-bs-target="#selectProfileModal">
                            <div class="card-body text-center d-flex flex-column align-items-center justify-content-center">
                                <div class="profile-card-add-user">
                                    <i class="ph ph-plus"></i>
                                </div>
                                <h5 class="mt-3 mb-0 font-size-18">Add User</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Modal -->
<div class="modal fade add-profile-modal" id="selectProfileModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content position-relative">
        <button type="button" class="btn btn-primary custom-close-btn rounded-2" data-bs-dismiss="modal">
            <i class="ph ph-x text-white fw-bold align-middle"></i>
        </button>
        <div class="modal-body text-center">
            <div class="select-profile-slider d-flex align-items-center gap-3 ">
                <div class="slick-item">
                    <div class="select-profile-card">
                        <img src="../img/web-img/user-img.png" class="select-profile-image" alt="select-profile-image">
                    </div>
                </div>
                <div class="slick-item">
                    <div class="select-profile-card">
                        <img src="../img/web-img/user-img.png" class="select-profile-image" alt="select-profile-image">
                    </div>
                </div>
                <div class="slick-item">
                    <div class="select-profile-card">
                        <img src="../img/web-img/user-img.png" class="select-profile-image" alt="select-profile-image">
                    </div>
                </div>
                <div class="slick-item">
                    <div class="select-profile-card">
                        <img src="../img/web-img/user-img.png" class="select-profile-image" alt="select-profile-image">
                    </div>
                </div>
                <div class="slick-item">
                    <div class="select-profile-card">
                        <img src="../img/web-img/user-img.png" class="select-profile-image" alt="select-profile-image">
                    </div>
                </div>
            </div>
            <div class="pt-4 mt-4 user-login-card">
                <form class="editProfileDetail">
                    <div class="input-group mb-3">
                        <span class="profile-input-text input-group-text px-0"><i class="ph ph-user"></i></span>
                        <input type="text" name="first_name" class="form-control profile-input" value="Noha">
                    </div>
                    <div class="mt-5 pt-4">
                        <button class="btn btn-primary">Update & Continue</button>
                    </div>
                    <div class="mt-5 pt-2">
                        <button class="btn btn-link">Remove</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
</div>

@endsection
