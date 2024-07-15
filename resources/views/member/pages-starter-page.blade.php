@extends('member.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
<div class="card rounded-4" style="height:800px;">
    <div class="card-body">
        <h4>Where does it come from?</h4>
        <p class="mb-4">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
            classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor
            at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a
            Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the
            undoubtable source.</p>
        <h4>Where can I get some?</h4>
        <p class="mb-3">There are many variations of passages of Lorem Ipsum available, but the majority have suffered
            alteration in some form, by injected humour, or randomised words which don't look even slightly believable.
            If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing
            hidden
            in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks
            as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin
            words, combined with a handful
            of model sentence structures, to generate Lorem Ipsum which looks reasonable.
            The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic
            words etc.</p>

        <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
            galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
            but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the
            1960s
            with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
            publishing software like Aldus PageMaker
            including versions of Lorem Ipsum.</p>
    </div>
</div>
<div class="row row-cols-1 row-cols-xl-2">
    <div class="col">
        <div class="card rounded-4">
            <div class="row g-0 align-items-center">
                <div class="col-md-4 border-end">
                    <div class="p-3 align-self-center">
                        <img src="https://placehold.co/400x300/png" class="w-100 rounded-start" alt="...">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">New iPhone Pro Max</h5>
                        <p class="card-text">Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia
                            All
                            the Lorem Ipsum generators.</p>
                        <h5>Price : $599</h5>
                        <div class="mt-4 d-flex align-items-center justify-content-between">
                            <button class="btn btn-grd btn-grd-primary d-flex gap-2 px-3 border-0"><i class="material-icons-outlined">shopping_basket</i>Add to Cart</button>
                            <div class="d-flex gap-1">
                                <a href="javascript:;" class="sharelink"><i class="material-icons-outlined">favorite_border</i></a>
                                <div class="dropdown position-relative">
                                    <a href="javascript:;" class="sharelink dropdown-toggle dropdown-toggle-nocaret" data-bs-auto-close="outside" data-bs-toggle="dropdown"><i class="material-icons-outlined">share</i></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-share shadow-lg border-0 p-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control ps-5" value="https://www.codervent.com" placeholder="Enter Url">
                                            <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50">link</span>
                                            <span class="input-group-text gap-1"><i class="material-icons-outlined fs-6">content_copy</i>Copy
                                                link</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 mt-3">
                                            <button class="py-1 px-3 border-0 rounded bg-pinterest text-white flex-fill d-flex gap-1"><i class="bi bi-pinterest"></i>Pinterest</button>
                                            <button class="py-1 px-3 border-0 rounded bg-facebook text-white flex-fill d-flex gap-1"><i class="bi bi-facebook"></i>Facebook</button>
                                            <button class="py-1 px-3 border-0 rounded bg-linkedin text-white flex-fill d-flex gap-1"><i class="bi bi-linkedin"></i>Linkedin</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card rounded-4">
            <div class="row g-0 align-items-center">
                <div class="col-md-4 border-end">
                    <div class="p-3">
                        <img src="https://placehold.co/400x300/png" class="w-100 rounded-start" alt="...">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Apple Watch Gray</h5>
                        <p class="card-text">Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia
                            All
                            the Lorem Ipsum generators.</p>
                        <h5>Price : $1025</h5>
                        <div class="mt-4 d-flex align-items-center justify-content-between">
                            <button class="btn btn-grd btn-grd-info border-0 d-flex gap-2 px-3"><i class="material-icons-outlined">shopping_basket</i>Add to Cart</button>
                            <div class="d-flex gap-1">
                                <a href="javascript:;" class="sharelink"><i class="material-icons-outlined">favorite_border</i></a>
                                <div class="dropdown position-relative">
                                    <a href="javascript:;" class="sharelink dropdown-toggle dropdown-toggle-nocaret" data-bs-auto-close="outside" data-bs-toggle="dropdown"><i class="material-icons-outlined">share</i></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-share shadow-lg border-0 p-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control ps-5" value="https://www.codervent.com" placeholder="Enter Url">
                                            <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50">link</span>
                                            <span class="input-group-text gap-1"><i class="material-icons-outlined fs-6">content_copy</i>Copy
                                                link</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 mt-3">
                                            <button class="py-1 px-3 border-0 rounded bg-pinterest text-white flex-fill d-flex gap-1"><i class="bi bi-pinterest"></i>Pinterest</button>
                                            <button class="py-1 px-3 border-0 rounded bg-facebook text-white flex-fill d-flex gap-1"><i class="bi bi-facebook"></i>Facebook</button>
                                            <button class="py-1 px-3 border-0 rounded bg-linkedin text-white flex-fill d-flex gap-1"><i class="bi bi-linkedin"></i>Linkedin</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="row g-0">
                <div class="col-md-4 border-end">
                    <div class="p-3">
                        <img src="https://placehold.co/400x650/png" class="w-100 rounded h-100" alt="...">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Lunch Box Prime</h5>
                        <p class="card-text">All the Lorem Ipsum generators on the Internet tend to repeat predefined
                            chunks
                            as necessary model.</p>
                        <h5>Price : $149</h5>
                        <div class="ratings text-warning mt-3">
                            <i class="material-icons-outlined">star</i>
                            <i class="material-icons-outlined">star</i>
                            <i class="material-icons-outlined">star</i>
                            <i class="material-icons-outlined">star</i>
                            <i class="material-icons-outlined">star</i>
                        </div>
                        <div class="mt-3 d-flex align-items-center justify-content-between">
                            <button class="btn btn-grd bg-grd-success border-0 d-flex gap-2 px-3"><i class="material-icons-outlined">shopping_cart</i>Add to Cart</button>
                            <div class="d-flex gap-1">
                                <a href="javascript:;" class="sharelink border"><i class="material-icons-outlined">favorite_border</i></a>
                                <a href="javascript:;" class="sharelink border" data-bs-toggle="modal" data-bs-target="#linkShareModal"><i class="material-icons-outlined">share</i></a>
                            </div>

                            <!--start share modal-->
                            <div class="modal" id="linkShareModal">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="position-relative">
                                                <a href="javascript:;" class="sharelink ms-auto" data-bs-dismiss="modal">
                                                    <span class="material-icons-outlined">close</span>
                                                </a>
                                            </div>
                                            <div class="text-center">
                                                <h4>Share This Product</h4>
                                                <p>Bootstrap only supports one modal window at a time.</p>
                                                <div class="d-flex align-items-center justify-content-center flex-wrap gap-4 py-5">
                                                    <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                                                        <a href="javascript:;" class="wh-64 bg-facebook text-white rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-facebook fs-3"></i></a>
                                                        <p class="mb-0">Facebook</p>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                                                        <a href="javascript:;" class="wh-64 bg-linkedin text-white rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-linkedin fs-3"></i></a>
                                                        <p class="mb-0">Linkedin</p>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                                                        <a href="javascript:;" class="wh-64 bg-dark text-white rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-twitter-x fs-3"></i></a>
                                                        <p class="mb-0">Twitter</p>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                                                        <a href="javascript:;" class="wh-64 bg-pinterest text-white rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-pinterest fs-3"></i></a>
                                                        <p class="mb-0">Pinterest</p>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                                                        <a href="javascript:;" class="wh-64 bg-whatsapp text-white rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-whatsapp fs-3"></i></a>
                                                        <p class="mb-0">WhatsApp</p>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                                                        <a href="javascript:;" class="wh-64 border text-dark rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-link fs-3"></i></a>
                                                        <p class="mb-0">Copy Link</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end share modal-->


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="row g-0">
                <div class="col-md-4 border-end align-items-stretch">
                    <div class="p-3">
                        <img src="https://placehold.co/400x650/png" class="w-100 rounded h-100" alt="...">
                    </div>
                </div>
                <div class="col-md-8 align-items-stretch">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Water Bottle Brown</h5>
                        <p class="card-text">All the Lorem Ipsum generators on the Internet tend to repeat predefined
                            chunks
                            as necessary Internet.</p>
                        <h5>Price : $258</h5>
                        <div class="ratings text-warning mt-3">
                            <i class="material-icons-outlined">star</i>
                            <i class="material-icons-outlined">star</i>
                            <i class="material-icons-outlined">star</i>
                            <i class="material-icons-outlined">star</i>
                            <i class="material-icons-outlined">star</i>
                        </div>
                        <div class="mt-3 d-flex align-items-center justify-content-between">
                            <button class="btn btn-grd bg-grd-warning border-0 raised d-flex gap-2 px-3"><i class="material-icons-outlined">shopping_cart</i>Add to Cart</button>
                            <div class="d-flex gap-1">
                                <a href="javascript:;" class="sharelink border"><i class="material-icons-outlined">favorite_border</i></a>
                                <a href="javascript:;" class="sharelink border" data-bs-toggle="modal" data-bs-target="#linkShareModal"><i class="material-icons-outlined">share</i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card">
            <img src="https://placehold.co/400x300/png" class="img-fluid card-img-top" alt="">
            <div class="card-body p-4">
                <h3 class="">Welcome to Company</h3>
                <p>Contrary to popular belief, Lorem Ipsum is not simply random text.
                    It has roots in a piece of classical Latin literature from 45 BC,
                    making it over 2000 years old.</p>
                <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below
                    for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by
                    Cicero are also reproduced in their exact original form, accompanied
                    by English versions from the 1914 translation by H. Rackham.</p>

                <div class="my-4 text-center">
                    <p class="fs-5">Welcome to the future of work.</p>
                    <a href="javascript:;" class="btn btn-grd btn-grd-danger border-0 btn-lg px-5">Start Exploring</a>
                </div>

                <div class="mt-5">
                    <div class="text-center">
                        <h5 class="mb-3">Explore top services</h5>
                    </div>
                    <div class="row row-cols-1 row-cols-lg-2 g-4">
                        <div class="col">
                            <div class="text-center">
                                <img src="https://placehold.co/400x300/png" class="img-fluid rounded" alt="">
                                <h5 class="mb-0 mt-3">Logo Design</h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <img src="https://placehold.co/400x300/png" class="img-fluid rounded" alt="">
                                <h5 class="mb-0 mt-3">Whiteboard & Animated</h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <img src="https://placehold.co/400x300/png" class="img-fluid rounded" alt="">
                                <h5 class="mb-0 mt-3">Voice Over</h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <img src="https://placehold.co/400x300/png" class="img-fluid rounded" alt="">
                                <h5 class="mb-0 mt-3">Wordpress</h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <img src="https://placehold.co/400x300/png" class="img-fluid rounded" alt="">
                                <h5 class="mb-0 mt-3">Articles & Blog Posts</h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <img src="https://placehold.co/400x300/png" class="img-fluid rounded" alt="">
                                <h5 class="mb-0 mt-3">Website Design</h5>
                            </div>
                        </div>
                    </div><!--end row-->
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row row-cols-1 row-cols-lg-2 g-3">
                    <div class="col">
                        <div class="card shadow-none bg-grd-voilet mb-0" style="height: 160px;">
                            <div class="card-body">
                                <h5 class="mb-0 text-white">Women Clothes</h5>
                                <img src="https://placehold.co/400x300/png" class="position-absolute end-0 bottom-0" width="140" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card shadow-none bg-grd-primary mb-0" style="height: 160px;">
                            <div class="card-body">
                                <h5 class="mb-0 text-white">Men Clothes</h5>
                                <img src="https://placehold.co/400x300/png" class="position-absolute end-0 bottom-0" width="90" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card shadow-none bg-grd-success mb-0" style="height: 160px;">
                            <div class="card-body">
                                <h5 class="mb-0 text-white">Airpods</h5>
                                <img src="https://placehold.co/400x300/png" class="position-absolute end-0 bottom-0" width="120" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card shadow-none bg-grd-danger mb-0" style="height: 160px;">
                            <div class="card-body">
                                <h5 class="mb-0 text-white">Furniture</h5>
                                <img src="https://placehold.co/400x300/png" class="position-absolute end-0 bottom-0 m-2" width="160" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card shadow-none bg-grd-deep-blue mb-0" style="height: 160px;">
                            <div class="card-body">
                                <h5 class="mb-0 text-white">Hand Watch</h5>
                                <img src="https://placehold.co/400x300/png" class="position-absolute end-0 bottom-0" width="130" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card shadow-none bg-grd-warning mb-0" style="height: 160px;">
                            <div class="card-body">
                                <h5 class="mb-0 text-white">Shoes Pair</h5>
                                <img src="https://placehold.co/400x300/png" class="position-absolute end-0 bottom-0 m-2" width="200" alt="">
                            </div>
                        </div>
                    </div>

                </div><!--end row-->
            </div>
        </div>

        <div class="card">
            <img src="https://placehold.co/400x500/png" class="card-img" alt="...">
            <div class="card-img-overlay">
                <p class="mb-4 text-white text-uppercase">Travel</p>
                <h3 class="card-title text-white">Various versions evolved</h3>
                <p class="mb-0 text-white">It was popularised in the 1960s with the release of Letraset sheets
                    containing. <br>
                    Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus
                </p>
            </div>
            <div class="bottom-0 position-absolute m-3">
                <a href="javascript:;" class="btn text-dark px-3 bg-white d-flex gap-2">Read More<span class="material-icons-outlined">east</span></a>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="card rounded-4">
                <img src="https://placehold.co/400x500/png" class="card-img rounded-4" alt="...">
                <div class="card-img-overlay">
                    <p class="mb-4 text-white text-uppercase">Corporate</p>
                    <h3 class="card-title text-white">Various versions evolved</h3>
                    <p class="mb-0 text-white">It was popularised in the 1960s with the release of Letraset sheets
                        containing.
                    </p>
                </div>
                <div class="bottom-0 position-absolute m-3">
                    <a href="javascript:;" class="btn text-dark px-3 bg-white d-flex gap-2">Read More<span class="material-icons-outlined">east</span></a>
                </div>
            </div>
            <div class="card rounded-4">
                <img src="https://placehold.co/400x500/png" class="card-img rounded-4" alt="...">
                <div class="card-img-overlay">
                    <p class="mb-4 text-white text-uppercase">Fitness</p>
                    <h3 class="card-title text-white">Various versions evolved</h3>
                </div>
                <div class="bottom-0 position-absolute m-3">
                    <a href="javascript:;" class="btn text-dark px-3 bg-white d-flex gap-2">Read More<span class="material-icons-outlined">east</span></a>
                </div>
            </div>
        </div>
    </div>
</div><!--end row-->

@endsection
@push('script')
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush
