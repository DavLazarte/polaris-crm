<?php

$publicPath = __DIR__ . '/public/';
$viewsPath = __DIR__ . '/resources/views/';

function processHtmlFile($filename) {
    global $publicPath;
    $content = file_get_contents($publicPath . $filename);
    
    // Fix Links
    $content = str_replace('href="index.html"', 'href="{{ route(\'home\') }}"', $content);
    $content = str_replace('href="nosotros.html"', 'href="{{ route(\'nosotros\') }}"', $content);
    $content = str_replace('href="servicios.html"', 'href="{{ route(\'servicios\') }}"', $content);
    $content = str_replace('href="contacto.html"', 'href="{{ route(\'contacto\') }}"', $content);
    $content = str_replace('href="news.html"', 'href="{{ route(\'news\') }}"', $content);
    
    // Fix assets
    $content = str_replace('src="assets/', 'src="{{ asset(\'assets/', $content);
    $content = str_replace('href="assets/', 'href="{{ asset(\'assets/', $content);
    $content = preg_replace('/\.png"/', '.png\') }}"', $content);
    $content = preg_replace('/\.jpg"/', '.jpg\') }}"', $content);
    $content = preg_replace('/\.css"/', '.css\') }}"', $content);
    $content = preg_replace('/\.js"/', '.js\') }}"', $content);
    
    return $content;
}

$indexContent = processHtmlFile('index.html.bak');

// Extract layout
$navEndIndex = strpos($indexContent, '</nav>') + 6;
$footerStartIndex = strpos($indexContent, '<footer>');

$headAndNav = substr($indexContent, 0, $navEndIndex);
$footerAndScripts = substr($indexContent, $footerStartIndex);

// Layout Translations
$layoutTrans = [
    '>Inicio<' => '>{{ __(\'Inicio\') }}<',
    '>Quiénes Somos<' => '>{{ __(\'Quiénes Somos\') }}<',
    '>Servicios<' => '>{{ __(\'Servicios\') }}<',
    '>Perspectivas<' => '>{{ __(\'Perspectivas\') }}<',
    '>Contacto<' => '>{{ __(\'Contacto\') }}<',
    '>Hablemos<' => '>{{ __(\'Hablemos\') }}<',
    'Firma consultora experta en inserción internacional, cooperación y desarrollo de negocios globales. Buenos Aires, Argentina.' => '{{ __(\'Firma consultora experta en inserción internacional, cooperación y desarrollo de negocios globales. Buenos Aires, Argentina.\') }}',
    '<h5>Navegación</h5>' => '<h5>{{ __(\'Navegación\') }}</h5>',
    '<h5>Recursos</h5>' => '<h5>{{ __(\'Recursos\') }}</h5>',
    '>Manual de Marca<' => '>{{ __(\'Manual de Marca\') }}<',
    '>Buenos Aires, Argentina<' => '>{{ __(\'Buenos Aires, Argentina\') }}<',
    '© 2026 Polaris Cooperation Group. Todos los derechos reservados.' => '{{ __(\'© 2026 Polaris Cooperation Group. Todos los derechos reservados.\') }}',
    '>Privacidad<' => '>{{ __(\'Privacidad\') }}<',
    '>Términos<' => '>{{ __(\'Términos\') }}<'
];

foreach ($layoutTrans as $s => $r) {
    $headAndNav = str_replace($s, $r, $headAndNav);
    $footerAndScripts = str_replace($s, $r, $footerAndScripts);
}
$headAndNav = preg_replace('/<title>.*?<\/title>/', '<title>@yield(\'title\', \'Polaris\')</title>', $headAndNav);

$layoutFinal = $headAndNav . "\n\n@yield('content')\n\n" . $footerAndScripts;
file_put_contents($viewsPath . 'layouts/app.blade.php', $layoutFinal);

function generateBlade($htmlFilename, $bladeName, $title, $translations) {
    global $viewsPath;
    $content = processHtmlFile($htmlFilename);
    
    $navEndIndex = strpos($content, '</nav>');
    if ($navEndIndex !== false) $navEndIndex += 6;
    else $navEndIndex = 0;
    
    $footerStartIndex = strpos($content, '<footer>');
    if ($footerStartIndex === false) $footerStartIndex = strlen($content);
    
    $body = substr($content, $navEndIndex, $footerStartIndex - $navEndIndex);
    
    foreach ($translations as $s => $r) {
        $body = str_replace($s, $r, $body);
    }
    
    $final = "@extends('layouts.app')\n@section('title', '$title')\n@section('content')\n" . $body . "\n@endsection";
    file_put_contents($viewsPath . $bladeName, $final);
}

// 1. Home
generateBlade('index.html.bak', 'home.blade.php', 'Polaris Cooperation Group', [
    'Cooperación y Negocios' => '{{ __(\'Cooperación y Negocios\') }}',
    'Diseñamos la arquitectura de su<br>estrategia internacional' => '{!! __(\'Diseñamos la arquitectura de su<br>estrategia internacional\') !!}',
    'Somos el puente entre el talento local y las oportunidades globales. Conectamos empresas, gobiernos y organizaciones con centros de decisión estratégica, innovación y financiamiento en el mundo.' => '{{ __(\'Somos el puente entre el talento local y las oportunidades globales. Conectamos empresas, gobiernos y organizaciones con centros de decisión estratégica, innovación y financiamiento en el mundo.\') }}',
    '>Hablemos de su proyecto<' => '>{{ __(\'Hablemos de su proyecto\') }}<',
    '>Conocer nuestros servicios<' => '>{{ __(\'Conocer nuestros servicios\') }}<',
    'Años de<br>experiencia' => '{!! __(\'Años de<br>experiencia\') !!}',
    'Países en<br>nuestra red' => '{!! __(\'Países en<br>nuestra red\') !!}',
    'Proyectos<br>gestionados' => '{!! __(\'Proyectos<br>gestionados\') !!}',
    'Cómo lo ayudamos' => '{{ __(\'Cómo lo ayudamos\') }}',
    'Desarrollamos soluciones a medida para que su organización atraviese fronteras con seguridad, respaldo y una estrategia clara de crecimiento.' => '{{ __(\'Desarrollamos soluciones a medida para que su organización atraviese fronteras con seguridad, respaldo y una estrategia clara de crecimiento.\') }}',
    '>Nuestra Metodología<' => '>{{ __(\'Nuestra Metodología\') }}<',
    '>Iniciar un Proyecto<' => '>{{ __(\'Iniciar un Proyecto\') }}<',
    'Conocer a la firma &rarr;' => '{!! __(\'Conocer a la firma &rarr;\') !!}',
    'Análisis y casos de éxito' => '{{ __(\'Análisis y casos de éxito\') }}',
    'Insights sobre comercio exterior, financiamiento internacional y tendencias globales que impactan en nuestra región.' => '{{ __(\'Insights sobre comercio exterior, financiamiento internacional y tendencias globales que impactan en nuestra región.\') }}',
    'Ver todas &rarr;' => '{!! __(\'Ver todas &rarr;\') !!}',
    'Iniciemos juntos' => '{{ __(\'Iniciemos juntos\') }}',
    '¿Listo para expandir<br>sus fronteras?' => '{!! __(\'¿Listo para expandir<br>sus fronteras?\') !!}',
    'Contacte a nuestro equipo de especialistas y diseñemos juntos la arquitectura internacional de su organización o territorio.' => '{{ __(\'Contacte a nuestro equipo de especialistas y diseñemos juntos la arquitectura internacional de su organización o territorio.\') }}',
    '>Iniciar una consulta<' => '>{{ __(\'Iniciar una consulta\') }}<',
    '>Ver nuestros servicios<' => '>{{ __(\'Ver nuestros servicios\') }}<',
    '<div class="sec-label fade-up">Servicios</div>' => '<div class="sec-label fade-up">{{ __(\'Servicios\') }}</div>',
    '<div class="sec-label">Perspectivas</div>' => '<div class="sec-label">{{ __(\'Perspectivas\') }}</div>',
]);

// 2. Nosotros
generateBlade('nosotros.html.bak', 'nosotros.blade.php', 'Quiénes Somos | Polaris', [
    'Nuestra Firma' => '{{ __(\'Nuestra Firma\') }}',
    'Estrategia con<br>'."\n".'            <span>poder de ejecución.</span>' => '{!! __(\'Estrategia con<br><span>poder de ejecución.</span>\') !!}',
    'Polaris es una consultora boutique que proyecta tu institución al mundo. Diseñamos trayectorias de internacionalización a medida para una inserción inteligente y pragmática en el sistema internacional contemporáneo.' => '{{ __(\'Polaris es una consultora boutique que proyecta tu institución al mundo. Diseñamos trayectorias de internacionalización a medida para una inserción inteligente y pragmática en el sistema internacional contemporáneo.\') }}',
    'Alcance Global' => '{{ __(\'Alcance Global\') }}',
    'Inteligencia relacional en mercados que importan.' => '{{ __(\'Inteligencia relacional en mercados que importan.\') }}',
    'Operamos en América Latina, Europa y mercados estratégicos emergentes.'."\n".'                    Nuestra red activa de actores públicos, privados y multilaterales nos permite'."\n".'                    identificar oportunidades antes que el mercado y activar proyectos con rapidez.' => '{{ __(\'Operamos en América Latina, Europa y mercados estratégicos emergentes. Nuestra red activa de actores públicos, privados y multilaterales nos permite identificar oportunidades antes que el mercado y activar proyectos con rapidez.\') }}',
    'Iniciar un proyecto &rarr;' => '{!! __(\'Iniciar un proyecto &rarr;\') !!}',
    'Regiones activas' => '{{ __(\'Regiones activas\') }}',
    'Actores en red' => '{{ __(\'Actores en red\') }}',
    'Orientados a resultados' => '{{ __(\'Orientados a resultados\') }}',
    'Modelo de Trabajo' => '{{ __(\'Modelo de Trabajo\') }}',
    'Cuatro pasos.<br>Un resultado concreto.' => '{!! __(\'Cuatro pasos.<br>Un resultado concreto.\') !!}',
    'Un proceso diseñado para eliminar incertidumbre y maximizar el impacto'."\n".'                en cada etapa de la internacionalización.' => '{{ __(\'Un proceso diseñado para eliminar incertidumbre y maximizar el impacto en cada etapa de la internacionalización.\') }}',
    'Diagnóstico Estratégico Profundo' => '{{ __(\'Diagnóstico Estratégico Profundo\') }}',
    'Evaluamos capacidades, contexto político-económico, oportunidades globales y riesgos. Benchmark internacional y análisis competitivo de posición en el mercado objetivo.' => '{{ __(\'Evaluamos capacidades, contexto político-económico, oportunidades globales y riesgos. Benchmark internacional y análisis competitivo de posición en el mercado objetivo.\') }}',
    'Diseño de Arquitectura Internacional' => '{{ __(\'Diseño de Arquitectura Internacional\') }}',
    'Definimos la hoja de ruta: mercados prioritarios, alianzas estratégicas, fuentes de financiamiento, posicionamiento y narrativa global diferencial.' => '{{ __(\'Definimos la hoja de ruta: mercados prioritarios, alianzas estratégicas, fuentes de financiamiento, posicionamiento y narrativa global diferencial.\') }}',
    'Activación Operativa' => '{{ __(\'Activación Operativa\') }}',
    'Implementamos: misiones comerciales, agendas de alto nivel, vinculaciones clave, acceso a fondos internacionales y desarrollo de nuevos mercados.' => '{{ __(\'Implementamos: misiones comerciales, agendas de alto nivel, vinculaciones clave, acceso a fondos internacionales y desarrollo de nuevos mercados.\') }}',
    'Monitoreo y Ajuste Dinámico' => '{{ __(\'Monitoreo y Ajuste Dinámico\') }}',
    'Monitoreamos resultados en tiempo real y adaptamos la estrategia según las dinámicas cambiantes del entorno geopolítico y comercial global.' => '{{ __(\'Monitoreamos resultados en tiempo real y adaptamos la estrategia según las dinámicas cambiantes del entorno geopolítico y comercial global.\') }}',
    'Diferencial' => '{{ __(\'Diferencial\') }}',
    'Un modelo basado en el<br>'."\n".'                    <em>talento humano.</em>' => '{!! __(\'Un modelo basado en el<br><em>talento humano.</em>\') !!}',
    'Combinamos formación de excelencia con años de experiencia real en la gestión pública y privada para construir capacidades y garantizar resultados.' => '{{ __(\'Combinamos formación de excelencia con años de experiencia real en la gestión pública y privada para construir capacidades y garantizar resultados.\') }}',
    'Formación de excelencia' => '{{ __(\'Formación de excelencia\') }}',
    'Profesionales capacitados para abordar la inserción inteligente en el sistema internacional contemporáneo.' => '{{ __(\'Profesionales capacitados para abordar la inserción inteligente en el sistema internacional contemporáneo.\') }}',
    'Experiencia de gestión real' => '{{ __(\'Experiencia de gestión real\') }}',
    'Años de trayectoria liderando proyectos estratégicos en los ámbitos público y privado.' => '{{ __(\'Años de trayectoria liderando proyectos estratégicos en los ámbitos público y privado.\') }}',
    'Construcción de capacidades' => '{{ __(\'Construcción de capacidades\') }}',
    'No solo diseñamos la estrategia, transferimos las competencias necesarias para sostenerla.' => '{{ __(\'No solo diseñamos la estrategia, transferimos las competencias necesarias para sostenerla.\') }}',
    '¿Qué hacemos?' => '{{ __(\'¿Qué hacemos?\') }}',
    'Expansión Global' => '{{ __(\'Expansión Global\') }}',
    'Acompañamos a gobiernos, empresas y organizaciones de la sociedad civil a proyectarse estratégicamente a nivel internacional de manera soberana y pragmática.' => '{{ __(\'Acompañamos a gobiernos, empresas y organizaciones de la sociedad civil a proyectarse estratégicamente a nivel internacional de manera soberana y pragmática.\') }}',
    'Aterrizaje Regional' => '{{ __(\'Aterrizaje Regional\') }}',
    'Ejecutamos y gestionamos en todas sus etapas los proyectos de organismos y actores internacionales en Argentina y Sudamérica de forma eficiente.' => '{{ __(\'Ejecutamos y gestionamos en todas sus etapas los proyectos de organismos y actores internacionales en Argentina y Sudamérica de forma eficiente.\') }}',
    'Éxito Compartido' => '{{ __(\'Éxito Compartido\') }}',
    'Trabajamos bajo esquemas colaborativos orientados a resultados tangibles y el desarrollo institucional duradero.' => '{{ __(\'Trabajamos bajo esquemas colaborativos orientados a resultados tangibles y el desarrollo institucional duradero.\') }}',
    'Iniciemos juntos' => '{{ __(\'Iniciemos juntos\') }}',
    '¿Listo para expandir<br>sus fronteras?' => '{!! __(\'¿Listo para expandir<br>sus fronteras?\') !!}',
    'Contacte a nuestro equipo de especialistas y diseñemos juntos la arquitectura internacional de su organización.' => '{{ __(\'Contacte a nuestro equipo de especialistas y diseñemos juntos la arquitectura internacional de su organización o territorio.\') }}',
    '>Iniciar una consulta<' => '>{{ __(\'Iniciar una consulta\') }}<',
    '>Ver nuestros servicios<' => '>{{ __(\'Ver nuestros servicios\') }}<',
]);

// 3. Servicios
generateBlade('servicios.html.bak', 'servicios.blade.php', 'Servicios | Polaris', [
    'Llegar más lejos.<br>'."\n".'            <span>Llegar mejor.</span>' => '{!! __(\'Llegar más lejos.<br><span>Llegar mejor.</span>\') !!}',
    'Diseñamos estrategias de inserción global para organizaciones que buscan abrir nuevos mercados, acceder a financiamiento y construir alianzas sólidas en el exterior.' => '{{ __(\'Diseñamos estrategias de inserción global para organizaciones que buscan abrir nuevos mercados, acceder a financiamiento y construir alianzas sólidas en el exterior.\') }}',
    'Nuestro equipo de especialistas traduce la complejidad del entorno internacional en una hoja de ruta clara, pragmática y orientada a resultados.' => '{{ __(\'Nuestro equipo de especialistas traduce la complejidad del entorno internacional en una hoja de ruta clara, pragmática y orientada a resultados.\') }}',
    '>Para Empresas<' => '>{{ __(\'Para Empresas\') }}<',
    '>Para Gobiernos<' => '>{{ __(\'Para Gobiernos\') }}<',
    '>Tercer Sector<' => '>{{ __(\'Tercer Sector\') }}<',
    'Internacionalización Corporativa' => '{{ __(\'Internacionalización Corporativa\') }}',
    'Soft Landing y Expansión' => '{{ __(\'Soft Landing y Expansión\') }}',
    'Diseño y ejecución de estrategias de aterrizaje en nuevos mercados. Reducción de riesgos comerciales y operativos.' => '{{ __(\'Diseño y ejecución de estrategias de aterrizaje en nuevos mercados. Reducción de riesgos comerciales y operativos.\') }}',
    'Misiones Comerciales' => '{{ __(\'Misiones Comerciales\') }}',
    'Organización de agendas B2B de alto nivel. Vinculación directa con tomadores de decisión y socios estratégicos.' => '{{ __(\'Organización de agendas B2B de alto nivel. Vinculación directa con tomadores de decisión y socios estratégicos.\') }}',
    'Inteligencia de Mercado' => '{{ __(\'Inteligencia de Mercado\') }}',
    'Análisis competitivo, barreras arancelarias, mapeo de actores clave y viabilidad de productos en destino.' => '{{ __(\'Análisis competitivo, barreras arancelarias, mapeo de actores clave y viabilidad de productos en destino.\') }}',
    'Financiamiento y Licitaciones' => '{{ __(\'Financiamiento y Licitaciones\') }}',
    'Identificación de oportunidades y formulación de proyectos para acceder a fondos de organismos multilaterales.' => '{{ __(\'Identificación de oportunidades y formulación de proyectos para acceder a fondos de organismos multilaterales.\') }}',
    'Cooperación para el Desarrollo' => '{{ __(\'Cooperación para el Desarrollo\') }}',
    'Estrategia de Inserción' => '{{ __(\'Estrategia de Inserción\') }}',
    'Diseño de políticas públicas para la proyección internacional de provincias y municipios.' => '{{ __(\'Diseño de políticas públicas para la proyección internacional de provincias y municipios.\') }}',
    'Atracción de Inversiones' => '{{ __(\'Atracción de Inversiones\') }}',
    'Posicionamiento territorial y vinculación con fondos de inversión y empresas globales.' => '{{ __(\'Posicionamiento territorial y vinculación con fondos de inversión y empresas globales.\') }}',
    'Cooperación Descentralizada' => '{{ __(\'Cooperación Descentralizada\') }}',
    'Articulación con gobiernos subnacionales extranjeros y redes globales de ciudades.' => '{{ __(\'Articulación con gobiernos subnacionales extranjeros y redes globales de ciudades.\') }}',
    'Fondos Multilaterales' => '{{ __(\'Fondos Multilaterales\') }}',
    'Estructuración de proyectos para financiamiento de infraestructura y desarrollo sostenible (BID, CAF, BM, UE).' => '{{ __(\'Estructuración de proyectos para financiamiento de infraestructura y desarrollo sostenible (BID, CAF, BM, UE).\') }}',
    'Alianzas Estratégicas Globales' => '{{ __(\'Alianzas Estratégicas Globales\') }}',
    'Mapeo de Donantes' => '{{ __(\'Mapeo de Donantes\') }}',
    'Identificación de fundaciones internacionales y agencias de cooperación alineadas a la misión de la ONG.' => '{{ __(\'Identificación de fundaciones internacionales y agencias de cooperación alineadas a la misión de la ONG.\') }}',
    'Formulación de Proyectos' => '{{ __(\'Formulación de Proyectos\') }}',
    'Diseño técnico de propuestas bajo los estándares requeridos por los organismos internacionales.' => '{{ __(\'Diseño técnico de propuestas bajo los estándares requeridos por los organismos internacionales.\') }}',
    'Fortalecimiento Institucional' => '{{ __(\'Fortalecimiento Institucional\') }}',
    'Capacitación de equipos locales en gestión de cooperación y desarrollo de alianzas globales.' => '{{ __(\'Capacitación de equipos locales en gestión de cooperación y desarrollo de alianzas globales.\') }}',
    'Advocacy Internacional' => '{{ __(\'Advocacy Internacional\') }}',
    'Posicionamiento de agendas locales en foros y organismos internacionales.' => '{{ __(\'Posicionamiento de agendas locales en foros y organismos internacionales.\') }}',
    'El Método Polaris' => '{{ __(\'El Método Polaris\') }}',
    'Precisión en cada etapa' => '{{ __(\'Precisión en cada etapa\') }}',
    'Evaluación de Viabilidad' => '{{ __(\'Evaluación de Viabilidad\') }}',
    'Analizamos el potencial real antes de iniciar la expansión.' => '{{ __(\'Analizamos el potencial real antes de iniciar la expansión.\') }}',
    'Plan de Acción' => '{{ __(\'Plan de Acción\') }}',
    'Hoja de ruta con plazos, presupuestos y responsables.' => '{{ __(\'Hoja de ruta con plazos, presupuestos y responsables.\') }}',
    'Ejecución en Destino' => '{{ __(\'Ejecución en Destino\') }}',
    'Acompañamiento local a través de nuestra red de socios.' => '{{ __(\'Acompañamiento local a través de nuestra red de socios.\') }}',
    'Transferencia' => '{{ __(\'Transferencia\') }}',
    'Construimos capacidades internas en tu organización.' => '{{ __(\'Construimos capacidades internas en tu organización.\') }}',
    '<div class="sec-label">Servicios</div>' => '<div class="sec-label">{{ __(\'Servicios\') }}</div>',
]);

// 4. Contacto
generateBlade('contacto.html.bak', 'contacto.blade.php', 'Contacto | Polaris', [
    'Estamos listos para su próximo paso.' => '{{ __(\'Estamos listos para su próximo paso.\') }}',
    'Complete el formulario y un especialista de nuestro equipo analizará su caso para coordinar una primera reunión estratégica.' => '{{ __(\'Complete el formulario y un especialista de nuestro equipo analizará su caso para coordinar una primera reunión estratégica.\') }}',
    'Nuestras Oficinas' => '{{ __(\'Nuestras Oficinas\') }}',
    'Correo Electrónico' => '{{ __(\'Correo Electrónico\') }}',
    'Nombre completo' => '{{ __(\'Nombre completo\') }}',
    'Organización / Empresa' => '{{ __(\'Organización / Empresa\') }}',
    'Correo electrónico' => '{{ __(\'Correo electrónico\') }}',
    'País' => '{{ __(\'País\') }}',
    'Áreas de Interés' => '{{ __(\'Áreas de Interés\') }}',
    '>Expansión Internacional<' => '>{{ __(\'Expansión Internacional\') }}<',
    '>Financiamiento<' => '>{{ __(\'Financiamiento\') }}<',
    '>Misiones Comerciales<' => '>{{ __(\'Misiones Comerciales\') }}<',
    'Mensaje' => '{{ __(\'Mensaje\') }}',
    'placeholder="Cuéntenos sobre su proyecto o desafío..."' => 'placeholder="{{ __(\'Cuéntenos sobre su proyecto o desafío...\') }}"',
    'Enviar consulta' => '{{ __(\'Enviar consulta\') }}',
    'Enviando...' => '{{ __(\'Enviando...\') }}',
    '¡Muchas gracias!' => '{{ __(\'¡Muchas gracias!\') }}',
    'Tu consulta ha sido enviada con éxito.<br>Nos pondremos en contacto en menos de 48 horas hábiles.' => '{!! __(\'Tu consulta ha sido enviada con éxito.<br>Nos pondremos en contacto en menos de 48 horas hábiles.\') !!}',
    'Volver al Inicio' => '{{ __(\'Volver al Inicio\') }}',
    '<div class="sec-label light">Contacto</div>' => '<div class="sec-label light">{{ __(\'Contacto\') }}</div>',
]);

// 5. News
// Since news.blade.php is dynamic, we'll modify it with simple str_replace
$newsContent = file_get_contents($viewsPath . 'news.blade.php');
$newsTrans = [
    'Información para la<br>'."\n".'            <span>toma de decisiones.</span>' => '{!! __(\'Información para la<br><span>toma de decisiones.</span>\') !!}',
    'Análisis profundo sobre dinámicas comerciales, geopolíticas y oportunidades de cooperación internacional que impactan en nuestra región.' => '{{ __(\'Análisis profundo sobre dinámicas comerciales, geopolíticas y oportunidades de cooperación internacional que impactan en nuestra región.\') }}',
    '>Todas<' => '>{{ __(\'Todas\') }}<',
    'DESTACADO' => '{{ __(\'DESTACADO\') }}',
    'LEER ANÁLISIS &rarr;' => '{!! __(\'LEER ANÁLISIS &rarr;\') !!}',
    '>Leer más<' => '>{{ __(\'Leer más\') }}<',
    'No hay noticias destacadas por el momento.' => '{{ __(\'No hay noticias destacadas por el momento.\') }}',
    'No hay noticias publicadas por el momento.' => '{{ __(\'No hay noticias publicadas por el momento.\') }}',
    'Reciba nuestros informes' => '{{ __(\'Reciba nuestros informes\') }}',
    'Unite a más de 2,000 líderes que reciben nuestros análisis mensuales sobre inserción global.' => '{{ __(\'Unite a más de 2,000 líderes que reciben nuestros análisis mensuales sobre inserción global.\') }}',
    'placeholder="Su correo electrónico"' => 'placeholder="{{ __(\'Su correo electrónico\') }}"',
    '>Suscribirme<' => '>{{ __(\'Suscribirme\') }}<',
    '<div class="page-kicker fade-up">Perspectivas</div>' => '<div class="page-kicker fade-up">{{ __(\'Perspectivas\') }}</div>',
];
foreach ($newsTrans as $s => $r) {
    $newsContent = str_replace($s, $r, $newsContent);
}
file_put_contents($viewsPath . 'news.blade.php', $newsContent);

echo "Translations and routes successfully applied to Blade files.";

