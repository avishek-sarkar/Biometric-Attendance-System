<footer class="footer">
    <div class="container">
        <div class="text-center">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>Contact us: info@attendance.com</p>
            
            @if(Route::has('developer'))
                <a href="{{ route('developer') }}" class="btn btn-primary rounded-pill">Developer Info</a>
            @endif
        </div>
    </div>
</footer>