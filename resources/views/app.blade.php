<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title inertia></title>
    
    <meta name="description" content="Default description about my Laravel + Vue app.">

    @vite('resources/js/app.js')
    @inertiaHead
</head>
<body class="font-sans antialiased">
    <h1>   </h1>
    @inertia
</body>
 <!-- Histats.com  START  (aync)-->
<script type="text/javascript">
var _Hasync= _Hasync|| [];
_Hasync.push(['Histats.start', '1,4969467,4,0,0,0,00010000']);
_Hasync.push(['Histats.fasi', '1']);
_Hasync.push(['Histats.track_hits', '']);
(function() {
var hs = document.createElement('script'); 
hs.type = 'text/javascript'; 
hs.async = true;
hs.src = ('//s10.histats.com/js15_as.js');
(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
})();
</script>
<noscript>
    <a href="/" target="_blank"><img  src="//sstatic1.histats.com/0.gif?4969467&101" alt="counter statistics" border="0"></a>
</noscript>
<!-- Histats.com  END  -->
</html>
