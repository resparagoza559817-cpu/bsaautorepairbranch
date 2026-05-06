<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    @vite(['resources/css/app.css'])
    
</head>

<body>


    
<div class="min-h-screen flex items-center justify-center lg:justify-between px-6 lg:px-20">

  <!-- LEFT SIDE (LOGO / IMAGE) -->
  <div class="hidden lg:flex w-1/2 items-center justify-center">
    <img 
      src="{{ asset('images/BSA-DARK.png') }}" 
      alt="logo"
      class="max-w-[380px] w-full"
    >
  </div>

  <!-- RIGHT SIDE (LOGIN FORM) -->
  <div class="w-full max-w-[400px] lg:w-[400px] h-auto lg:h-[570px] px-5 py-4.5 rounded-3xl bg-white/20 backdrop-blur-md border border-white/20 shadow-lg text-white">
    
    <!-- Logo -->
    <div class="flex justify-center mb-1">
      <img src="{{ asset('images/LOGO-LIGHT.png') }}" alt="logo">
    </div>

    <!-- Title -->
    <p class="text-center text-sm text-black/80 mb-6">
      Welcome back! Please enter your details.
    </p>

<form method="POST" action="/login">
    @csrf
        <!-- Email -->
    <div class="mb-2">
      <label class="text-sm">Email</label>
      <input type="email"
        name="email"
        placeholder="Enter your email"
        class="w-full mt-1 px-3 py-2 rounded-lg bg-transparent border border-white/30 focus:outline-none focus:ring-2 focus:ring-orange-400 placeholder-white/50">
    </div>

    <!-- Password -->
    <div class="mb-2">
      <label class="text-sm">Password</label>
      <input type="password"
        name="password"
        placeholder="••••••••"
        class="w-full mt-1 px-3 py-2 rounded-lg bg-transparent border border-white/30 focus:outline-none focus:ring-2 focus:ring-orange-400 placeholder-white/50">
    </div>


    <!-- Remember + Forgot -->
    <div class="flex justify-between items-center text-sm mb-2">
      <label class="flex items-center gap-2">
        <input type="checkbox" class="accent-orange-400">
        Remember me
      </label>
      <a href="#" class="text-orange-200 hover:underline">Forgot password</a>
    </div>

    <!-- Button -->
    <button type="submit" value="submit" style="border-radius:10px" class="mb-[100px] w-full bg-gray-900 text-white py-2 hover:bg-black transition">
      Sign in
    </button>



</form>
  </div>

</div>



</body>
</html>