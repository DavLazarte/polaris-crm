<?php
// Restore and Blade-ify the files safely without encoding issues.
$files = [
    ['name' => 'index.html.bak', 'blade' => 'home.blade.php', 'title' => 'Polaris Cooperation Group'],
    ['name' => 'nosotros.html.bak', 'blade' => 'nosotros.blade.php', 'title' => 'Quiénes Somos | Polaris'],
    ['name' => 'servicios.html.bak', 'blade' => 'servicios.blade.php', 'title' => 'Servicios | Polaris'],
    ['name' => 'contacto.html.bak', 'blade' => 'contacto.blade.php', 'title' => 'Contacto | Polaris'],
];

$publicPath = __DIR__ . '/public/';
$viewsPath = __DIR__ . '/resources/views/';

foreach ($files as $f) {
    if (!file_exists($publicPath . $f['name'])) continue;
    
    $content = file_get_contents($publicPath . $f['name']);
    
    // Extract Body
    $navEndIndex = strpos($content, '</nav>');
    $navEndIndex = $navEndIndex !== false ? $navEndIndex + 6 : 0;
    $footerStartIndex = strpos($content, '<footer>');
    if ($footerStartIndex === false) $footerStartIndex = strlen($content);
    
    $bodyContent = substr($content, $navEndIndex, $footerStartIndex - $navEndIndex);
    
    // Fix links
    $bodyContent = str_replace('src="assets/', 'src="{{ asset(\'assets/', $bodyContent);
    $bodyContent = str_replace('.png"', '.png\') }}"', $bodyContent);
    $bodyContent = str_replace('.jpg"', '.jpg\') }}"', $bodyContent);
    $bodyContent = str_replace('href="contacto.html"', 'href="{{ route(\'contacto\') }}"', $bodyContent);
    $bodyContent = str_replace('href="news.html"', 'href="{{ route(\'news\') }}"', $bodyContent);
    $bodyContent = str_replace('href="index.html"', 'href="{{ route(\'home\') }}"', $bodyContent);
    $bodyContent = str_replace('href="servicios.html"', 'href="{{ route(\'servicios\') }}"', $bodyContent);
    $bodyContent = str_replace('href="nosotros.html"', 'href="{{ route(\'nosotros\') }}"', $bodyContent);
    
    $finalContent = "@extends('layouts.app')\n@section('title', '" . $f['title'] . "')\n@section('content')\n" . $bodyContent . "\n@endsection";
    
    file_put_contents($viewsPath . $f['blade'], $finalContent);
}

// Restore layout correctly
$indexContent = file_get_contents($publicPath . 'index.html.bak');
$navEndIndex = strpos($indexContent, '</nav>') + 6;
$footerStartIndex = strpos($indexContent, '<footer>');
$headAndNav = substr($indexContent, 0, $navEndIndex);
$footerAndScripts = substr($indexContent, $footerStartIndex);

$headAndNav = str_replace('href="assets/', 'href="{{ asset(\'assets/', $headAndNav);
$headAndNav = preg_replace('/\.css"/', '.css\') }}"', $headAndNav);
$headAndNav = str_replace('src="assets/', 'src="{{ asset(\'assets/', $headAndNav);
$headAndNav = preg_replace('/\.png"/', '.png\') }}"', $headAndNav);
$headAndNav = str_replace('href="index.html"', 'href="{{ route(\'home\') }}"', $headAndNav);
$headAndNav = str_replace('href="nosotros.html"', 'href="{{ route(\'nosotros\') }}"', $headAndNav);
$headAndNav = str_replace('href="servicios.html"', 'href="{{ route(\'servicios\') }}"', $headAndNav);
$headAndNav = str_replace('href="contacto.html"', 'href="{{ route(\'contacto\') }}"', $headAndNav);
$headAndNav = str_replace('href="news.html"', 'href="{{ route(\'news\') }}"', $headAndNav);
$headAndNav = preg_replace('/<title>.*?<\/title>/', '<title>@yield(\'title\', \'Polaris\')</title>', $headAndNav);

$footerAndScripts = str_replace('src="assets/', 'src="{{ asset(\'assets/', $footerAndScripts);
$footerAndScripts = preg_replace('/\.png"/', '.png\') }}"', $footerAndScripts);
$footerAndScripts = preg_replace('/\.js"/', '.js\') }}"', $footerAndScripts);
$footerAndScripts = str_replace('href="index.html"', 'href="{{ route(\'home\') }}"', $footerAndScripts);
$footerAndScripts = str_replace('href="nosotros.html"', 'href="{{ route(\'nosotros\') }}"', $footerAndScripts);
$footerAndScripts = str_replace('href="servicios.html"', 'href="{{ route(\'servicios\') }}"', $footerAndScripts);
$footerAndScripts = str_replace('href="contacto.html"', 'href="{{ route(\'contacto\') }}"', $footerAndScripts);
$footerAndScripts = str_replace('href="news.html"', 'href="{{ route(\'news\') }}"', $footerAndScripts);

$layoutContent = $headAndNav . "\n\n@yield('content')\n\n" . $footerAndScripts;
file_put_contents($viewsPath . 'layouts/app.blade.php', $layoutContent);

echo "Restored perfectly.";
