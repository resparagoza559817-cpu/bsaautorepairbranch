<nav class="navbar navbar-expand-lg" style="background-color: #232323;">
        <div class="container">
            <div class="row">
                <img class="my-1.5" style="width: 140px; height: 70px;" src="{{ asset('images/HEAD-LOGO-LIGHT.png') }}" alt="Logo">
            </div>
            

            <div class="navbar-collapse">
            <ul class="navbar-nav ms-auto" >
                <li class="nav-item mx-2 font-weight-bold">
                    <a class="nav-link active" style="color: #E9E9E9; font-size: 18px;" href="">Home</a>
                </li>

                <li class="nav-item mx-2 font-weight-bold">
                    <a class="nav-link" style="color: #E9E9E9; font-size: 18px;" href="">About us</a>
                </li>

                <li class="nav-item mx-2 font-weight-bold">
                    <a class="nav-link" style="color: #E9E9E9; font-size: 18px;" href="">Services</a>
                </li>

                <li class="nav-item font-weight-bold ms-3">
                    <!-- Background color changed to Cyan (#00ffff) -->
                    <a class="nav-link px-4 py-2" style="color: #000; font-size: 18px; background-color: #00ffff; border-radius: 30px;" href="{{ route('login') }}">Log in as admin</a>
                </li>
            </ul>
            </div>
        </div>
</nav>


<style>
    nav{
        animation: bgslide 1.5s ease-in backwards;
    }

    @keyframes bgslide {
    0% {
        background-position: -200px;
        opacity: 0;
    }

    100% {
        background-position: center;
        opacity: 1;
    }
}
</style>