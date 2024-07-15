@extends('member.layouts.app')
@section('title')
starter Page
@endsection
@section('css')
<style>


:root {
  --circle-size: clamp(1.5rem, 5vw, 3rem);
  --spacing: clamp(0.25rem, 2vw, 0.5rem);
}

.c-stepper {
  display: flex;
  padding: 0;
}

.c-stepper__item {
  display: flex;
  flex-direction: column;
  flex: 1;
  text-align: center;

  &:before {
    --size: 3rem;
    content: "";
    display: block;
    width: var(--circle-size);
    height: var(--circle-size);
    border-radius: 50%;
    background-color: lightgrey;
    background-color: red;
    opacity: 0.5;
    margin: 0 auto 1rem;
  }

  &:not(:last-child) {
    &:after {
      content: "";
      position: relative;
      top: calc(var(--circle-size) / 2);
      width: calc(100% - var(--circle-size) - calc(var(--spacing) * 2));
      left: calc(50% + calc(var(--circle-size) / 2 + var(--spacing)));
      height: 2px;
      background-color: #e0e0e0;
      order: -1;
    }
  }
}

.c-stepper__title {
  font-weight: bold;
  font-size: clamp(1rem, 4vw, 1.25rem);
  margin-bottom: 0.5rem;
}

.c-stepper__desc {
  color: grey;
  font-size: clamp(0.85rem, 2vw, 1rem);
  padding-left: var(--spacing);
  padding-right: var(--spacing);
}

/*** Non-demo CSS ***/

.wrapper {
  max-width: 1000px;
  margin: 2rem auto 0;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
    Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
  padding: 1rem;
}

*,
*:before,
*:after {
  box-sizing: border-box;
}

</style>
@endsection

@section('content')
<div class="card rounded-4">
    <div class="card-body" style="height: 100%;">
        <div class="mt-5">
            <div class="text-center" style="padding-bottom:30px;">
                <h5 class="mb-3" style="padding-bottom:20px;">Explore top services</h5>
                <div class="wrapper option-1 option-1-1">
                    <ol class="c-stepper">
                        <li class="c-stepper__item">
                        <h3 class="c-stepper__title">Step 1</h3>
                        <p class="c-stepper__desc">Some desc text</p>
                        </li>
                        <li class="c-stepper__item">
                        <h3 class="c-stepper__title">Step 2</h3>
                        <p class="c-stepper__desc">Some desc text</p>
                        </li>
                        <li class="c-stepper__item">
                        <h3 class="c-stepper__title">Step 3</h3>
                        <p class="c-stepper__desc">Some desc text</p>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-lg-3 g-4">
                <div class="col">
                    <div class="text-center">
                        <img src="https://placehold.co/400x300/png" class="img-fluid rounded" alt="">
                        <h5 class="mb-0 mt-3">Logo Design</h5>
                    </div>
                </div>
            </div><!--end row-->
        </div>

    </div>
</div>

@endsection
@push('script')
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush
