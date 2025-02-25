@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Activate your profile by completing your information</h1>
    <script>
        setTimeout(function() {
            window.location.href = 'activate.php';
        }, 3000); // Redirects after 3 seconds
    </script>
</div>
@endsection
