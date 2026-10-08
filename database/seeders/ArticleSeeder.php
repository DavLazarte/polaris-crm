<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::create([
            'title' => 'Soft Landing: cómo ingresar a nuevos mercados con bajo riesgo',
            'slug' => Str::slug('Soft Landing: cómo ingresar a nuevos mercados con bajo riesgo'),
            'category' => 'Comercio Exterior',
            'excerpt' => 'Estrategias para acelerar la expansión hacia Europa y EE.UU. reduciendo la incertidumbre operativa y los costos de entrada.',
            'body' => '<p>Entrar a un mercado nuevo sin estructura propia en destino es uno de los mayores riesgos que enfrenta una empresa en su proceso de internacionalización: errores regulatorios, sobrecostos logísticos y decisiones tomadas sin información local pueden frenar un proyecto antes de que arranque.</p><p>El soft landing es la estrategia que resuelve ese problema. Consiste en apoyarse en una estructura ya instalada en el mercado de destino —socios, oficinas, redes comerciales y conocimiento regulatorio— para operar sin necesidad de radicarse de forma permanente desde el primer día. Esto permite validar el mercado, generar las primeras ventas o alianzas, y recién después decidir si la inversión en presencia física está justificada.</p><p>En Polaris trabajamos el soft landing en dos direcciones: acompañamos a empresas y organizaciones de Tucumán y el NOA que buscan proyectar sus productos o servicios hacia Europa y Estados Unidos, y también recibimos actores internacionales que necesitan aterrizar en Argentina y Sudamérica. En ambos casos, el trabajo arranca con inteligencia de mercado y mapeo de actores, y avanza hacia la vinculación concreta con socios estratégicos en destino.</p><p>¿Tu empresa está evaluando dar el salto a un mercado nuevo? <a href="contacto.html">Conversemos</a> sobre cuál es la estrategia de entrada con menor riesgo para tu caso.</p>',
            'is_featured' => true,
            'published_at' => '2026-06-18',
        ]);

        Article::create([
            'title' => 'Misión Comercial: conectando el talento local con hubs de decisión global',
            'slug' => Str::slug('Misión Comercial: conectando el talento local con hubs de decisión global'),
            'category' => 'Casos de Éxito',
            'excerpt' => 'Resultados de nuestra última agenda estratégica organizada en mercados emergentes de alto potencial de crecimiento.',
            'body' => '<p>Una misión comercial bien diseñada no es un viaje institucional: es una agenda de reuniones construida a medida, con objetivos claros y actores previamente validados. Esa es la diferencia entre una misión que genera vínculos reales y una que solo deja tarjetas personales.</p><p>En nuestra última misión, acompañamos a un grupo de organizaciones del NOA en una agenda de encuentros con centros de decisión estratégica en mercados de alto potencial. El trabajo previo —mapeo de actores, validación de intereses mutuos y preparación de cada reunión— fue lo que permitió que cada encuentro tuviera un propósito concreto: desde la búsqueda de financiamiento hasta la identificación de socios comerciales.</p><p>El resultado no se mide en la cantidad de reuniones, sino en la calidad de los vínculos que quedan activos después del viaje. Ese es el estándar con el que diseñamos cada misión comercial: que el talento local llegue a la mesa correcta, con la información correcta, en el momento correcto.</p><p>¿Tu organización está evaluando participar de una misión comercial? <a href="contacto.html">Te contamos</a> cómo diseñamos una agenda a medida de tus objetivos.</p>',
            'is_featured' => false,
            'published_at' => '2026-07-10',
        ]);

        Article::create([
            'title' => 'Nuevos instrumentos de financiamiento de la UE para América Latina 2026–2030',
            'slug' => Str::slug('Nuevos instrumentos de financiamiento de la UE para América Latina 2026–2030'),
            'category' => 'Cooperación Internacional',
            'excerpt' => 'El análisis de los programas Horizonte Europa y CDTI para organizaciones y municipios con proyectos de innovación.',
            'body' => '<p>La Comisión Europea aprobó el nuevo programa de trabajo de Horizonte Europa para el período 2026–2027, con más de 14.000 millones de euros destinados a investigación e innovación. Lo relevante para nuestra región: el programa es, por defecto, abierto al mundo, lo que permite que universidades, empresas, municipios y organizaciones de América Latina participen —principalmente a través de consorcios— en la mayoría de las convocatorias.</p><p>Entre las líneas más activas para la región se destacan los clusters de digitalización e industria, clima y energía, y bioeconomía y recursos naturales, además de programas específicos de cooperación birregional como el EU-LAC Social Accelerator, orientado a innovación social e inclusión. También continúan abiertas las líneas de movilidad y formación de capacidades (Acciones Marie Skłodowska-Curie), clave para fortalecer equipos técnicos locales.</p><p>Para gobiernos subnacionales y organizaciones de la región, el desafío no es la disponibilidad de fondos —hay financiamiento genuino disponible— sino la capacidad de identificar la convocatoria correcta, armar el consorcio adecuado y presentar una postulación competitiva dentro de los plazos, que suelen ser acotados.</p><p>¿Tu organización tiene un proyecto que podría encajar en estas convocatorias? En Polaris <a href="contacto.html">identificamos la línea correcta y gestionamos la postulación</a> de punta a punta.</p>',
            'is_featured' => false,
            'published_at' => '2026-08-03',
        ]);

        Article::create([
            'title' => 'Compliance internacional: lo que deben saber las empresas antes de expandirse a la UE',
            'slug' => Str::slug('Compliance internacional: lo que deben saber las empresas antes de expandirse a la UE'),
            'category' => 'Marco Regulatorio',
            'excerpt' => 'Las nuevas normativas europeas de responsabilidad corporativa y su impacto en empresas de origen latinoamericano.',
            'body' => '<p>En febrero de 2026 la Unión Europea aprobó la Directiva Ómnibus I, que simplifica de forma significativa dos normas clave para cualquier empresa que quiera operar u operar con socios en el mercado europeo: la CSRD (información corporativa en sostenibilidad) y la CSDDD (diligencia debida en sostenibilidad).</p><p>Los umbrales de aplicación subieron considerablemente: la obligación de reportar bajo CSRD ahora alcanza a empresas con más de 1.000 empleados y 450 millones de euros de facturación (aplicable desde ejercicios que comiencen en 2027), mientras que la diligencia debida bajo CSDDD queda reservada a empresas con más de 5.000 empleados y 1.500 millones de euros de facturación mundial, con aplicación recién a partir de julio de 2029.</p><p>También se simplificó el alcance: la evaluación exhaustiva ahora se limita a proveedores de primer nivel, y la frecuencia de revisión pasó de anual a cada cinco años.</p><p>¿Qué significa esto para una pyme argentina que exporta a Europa? En términos directos, la mayoría de las empresas de nuestra región no van a estar obligadas a cumplir estas normas de forma directa. Pero sí es probable que, si formás parte de la cadena de valor de una empresa europea grande, te pidan información alineada a estos estándares como condición para seguir siendo proveedor. Conocer el marco con anticipación es lo que permite negociar esa relación desde una posición informada, en lugar de reaccionar tarde.</p><p>¿Tu empresa exporta o planea exportar a la UE? <a href="contacto.html">Te ayudamos</a> a entender qué te van a pedir tus socios europeos y cómo prepararte con tiempo.</p>',
            'is_featured' => false,
            'published_at' => '2026-09-02',
        ]);
    }
}
