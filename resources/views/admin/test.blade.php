@extends('admin.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
<h1>Speech to Text Demo</h1>
<button id="start-btn">Start Listening</button>
<div id="result"></div>
@endsection
@section('javascript')
<script>
    // Check for browser support
    window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    if ('SpeechRecognition' in window) {
        const recognition = new SpeechRecognition();
        recognition.interimResults = true;
        recognition.lang = 'en-US';

        const startButton = document.getElementById('start-btn');
        const resultDiv = document.getElementById('result');

        startButton.addEventListener('click', () => {
            recognition.start();
            startButton.disabled = true;
            startButton.textContent = 'Listening...';
        });

        recognition.addEventListener('result', (event) => {
            let transcript = '';
            for (const result of event.results) {
                transcript += result[0].transcript;
            }
            resultDiv.textContent = transcript;
        });

        recognition.addEventListener('end', () => {
            startButton.disabled = false;
            startButton.textContent = 'Start Listening';
        });

    } else {
        alert('Your browser does not support Speech Recognition.');
    }
</script>
@endsection
@push('script')
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush