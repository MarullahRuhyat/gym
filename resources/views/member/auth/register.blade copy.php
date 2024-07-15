@extends('member.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
<!--start stepper one-->
<h6 class="text-uppercase">Non Linear</h6>
<hr>
<div id="stepper1" class="bs-stepper">
<div class="card">
<div class="card-header">
   <div class="d-lg-flex flex-lg-row align-items-lg-center justify-content-lg-between" role="tablist">
      <div class="step" data-target="#test-l-1">
         <div class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-l-1">
            <div class="bs-stepper-circle">1</div>
            <div class="">
               <h5 class="mb-0 steper-title">Package Member</h5>
               <p class="mb-0 steper-sub-title">Select package</p>
            </div>
         </div>
      </div>
      <div class="bs-stepper-line"></div>
      <div class="step" data-target="#test-l-2">
         <div class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2">
            <div class="bs-stepper-circle">2</div>
            <div class="">
               <h5 class="mb-0 steper-title">Register</h5>
               <p class="mb-0 steper-sub-title">Fill your account details</p>
            </div>
         </div>
      </div>
      <div class="bs-stepper-line"></div>
      <div class="step" data-target="#test-l-3">
         <div class="step-trigger" role="tab" id="stepper1trigger3" aria-controls="test-l-3">
            <div class="bs-stepper-circle">3</div>
            <div class="">
               <h5 class="mb-0 steper-title">Pay</h5>
               <p class="mb-0 steper-sub-title">Pay your membership</p>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="card-body">
   <div class="bs-stepper-content">
      <form onSubmit="return false">
         <div id="test-l-1" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger1">
            <h5 class="mb-1">Your Personal Information</h5>
            <p class="mb-4">Enter your personal information to get closer to copanies</p>
            <div class="row g-3">
               <div class="row row-cols-1 row-cols-lg-3 g-4">
                  @foreach($package as $package)
                  <div class="col" style="padding-bottom:10px">
                     <div class="text-center">
                        <div class="card rounded-4 border-0 shadow-sm " style="height:300px; background-color:#adb5bd">
                           <div class="card-body" style="display: flex; flex-direction: column; justify-content: flex-end;">
                              <h5 class="mb-3">{{$package->name}}</h5>
                              <h1 class="mb-3">{{$package->price}}</h1>
                              <p class="gray-color mb-3">{{$package->description}}</p>
                              <a href="{{route('member.selected_package_detail', $package->id)}}" class="btn btn-primary">Select</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
               </div>
               <!--end row-->
               <div class="col-12 col-lg-6">
                  <button class="btn btn-grd-primary px-4" onclick="stepper1.next()">Next<i class='bx bx-right-arrow-alt ms-2'></i></button>
               </div>
            </div>
            <!---end row-->
         </div>
         <div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2">
            <h5 class="mb-1">Account Details</h5>
            <p class="mb-4">Enter Your Account Details.</p>
            <div class="row g-3">
               <div class="col">
                  <div class="card">
                     <div class="row g-0">
                        <div class="col-md-4 border-end">
                           <div class="p-3">
                              <img src="{{ URL::asset('build/images/02.png') }}" class="w-100 rounded h-100" alt="...">
                           </div>
                        </div>
                        <div class="col-md-8">
                           <div class="card-body">
                              <h5 class="card-title mb-3">Lunch Box Prime</h5>
                              <p class="card-text">All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks
                                 as necessary model.
                              </p>
                              <h5>Price : $149</h5>
                              <div class="ratings text-warning mt-3">
                                 <i class="material-icons-outlined">star</i>
                                 <i class="material-icons-outlined">star</i>
                                 <i class="material-icons-outlined">star</i>
                                 <i class="material-icons-outlined">star</i>
                                 <i class="material-icons-outlined">star</i>
                              </div>
                              <div class="mt-3 d-flex align-items-center justify-content-between">
                                 <button class="btn btn-grd bg-grd-success border-0 d-flex gap-2 px-3"><i
                                    class="material-icons-outlined">shopping_cart</i>Add to Cart</button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                           <button class="btn btn-grd-info px-4" onclick="stepper1.previous()"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                           <button class="btn btn-grd-primary px-4" onclick="stepper1.next()">Next<i class='bx bx-right-arrow-alt ms-2'></i></button>
                        </div>
                     </div>
                  </div>
                  <!---end row-->
               </div>
               <div id="test-l-3" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger3">
                  <h5 class="mb-1">Your Education Information</h5>
                  <p class="mb-4">Inform companies about your education life</p>
                  <div class="row g-3">
                     <div class="col-12 col-lg-6">
                        <label class="form-label">School Name</label>
                        <input type="text" class="form-control" placeholder="School Name">
                     </div>
                     <div class="col-12 col-lg-6">
                        <label class="form-label">Board Name</label>
                        <input type="text" class="form-control" placeholder="Board Name">
                     </div>
                     <div class="col-12 col-lg-6">
                        <label class="form-label">University Name</label>
                        <input type="text" class="form-control" placeholder="University Name">
                     </div>
                     <div class="col-12 col-lg-6">
                        <label class="form-label">Course Name</label>
                        <select class="form-select">
                           <option selected>---</option>
                           <option value="1">One</option>
                           <option value="2">Two</option>
                           <option value="3">Three</option>
                        </select>
                     </div>
                     <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                           <button class="btn btn-grd-info px-4" onclick="stepper1.previous()"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                           <button class="btn btn-grd-primary px-4" onclick="stepper1.next()">Next<i class='bx bx-right-arrow-alt ms-2'></i></button>
                        </div>
                     </div>
                  </div>
                  <!---end row-->
               </div>
			</div>
		</div>
      </form>
      </div>
      </div>
   </div>
</div>
<!--end stepper one-->
<!--end main wrapper-->
@endsection
@push('script')
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/bs-stepper/js/main.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush
