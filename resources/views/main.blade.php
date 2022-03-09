<!DOCTYPE html>
<html lang="en">
<head>
@include('head')
</head>

<body id="body">
@include('header')

@yield('content')

@include('footer')
@yield('js')
</body>
</html>
