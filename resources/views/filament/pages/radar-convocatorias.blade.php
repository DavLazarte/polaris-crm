<x-filament-panels::page>
<style>
    .radar-admin-box {
        font-family: 'Montserrat', sans-serif;
        color: #ffffff;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .radar-admin-table-box {
        background: #050d2a;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0, 4, 18, 0.6);
    }
    .radar-admin-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.82rem;
    }
    .radar-admin-table thead th {
        background: #081438;
        color: #94a3b8;
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 16px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        white-space: nowrap;
    }
    .radar-admin-table tbody tr {
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        transition: background 0.2s;
    }
    .radar-admin-table tbody tr:hover {
        background: rgba(48, 87, 190, 0.15);
    }
    .radar-admin-table tbody td {
        padding: 16px 20px;
        vertical-align: middle;
        color: #e2e8f0;
    }
</style>

<div class="radar-admin-box" x-data="{
    showPayloadModal: false,
    toastMsg: '',
    showToast(msg) {
        this.toastMsg = msg;
        setTimeout(() => { this.toastMsg = ''; }, 3000);
    },
    items: [
        {
            id: 1,
            titulo: 'Adaptación climática en América Latina y el Caribe (AFCIA)',
            organismo: 'UN CTCN · Fondo de Adaptación',
            plazo: 'Cierra en 6 días',
            plazoStatus: 'urge',
            argentina: false,
            ods: 'ODS 13',
            sector: 'Universidades / I+D',
            modo: 'Asistencia técnica',
            monto: 'USD 250.000',
            fuente: 'Agente IA (Crawler Web ONU)'
        },
        {
            id: 2,
            titulo: 'I+D+i agroalimentaria — Convocatoria regional 2026',
            organismo: 'FONTAGRO',
            plazo: 'Cierra en 22 días',
            plazoStatus: 'pronto',
            argentina: false,
            ods: 'ODS 2, ODS 9',
            sector: 'Universidades / I+D',
            modo: 'Fondo Concursable',
            monto: 'USD 400.000',
            fuente: 'API FONTAGRO RSS'
        },
        {
            id: 3,
            titulo: 'Cooperación científica Argentina–Francia (ECOS-Sud)',
            organismo: 'Secretaría de Ciencia y Tecnología · Embajada de Francia',
            plazo: 'Cierra en 60 días',
            plazoStatus: 'amplio',
            argentina: true,
            ods: 'ODS 9, ODS 17',
            sector: 'Universidades / I+D',
            modo: 'Bilateral',
            monto: 'Movilidad & Estadías',
            fuente: 'Agente IA (MinCyT)'
        },
        {
            id: 4,
            titulo: 'Pequeñas subvenciones sobre género y ambiente',
            organismo: 'ONU Mujeres',
            plazo: 'Cierra en 18 días',
            plazoStatus: 'pronto',
            argentina: false,
            ods: 'ODS 5, ODS 13',
            sector: 'ONG / Tercer sector',
            modo: 'No reembolsable',
            monto: 'USD 15.000',
            fuente: 'Agente IA (UN Grants)'
        },
        {
            id: 5,
            titulo: 'Infraestructura climática y transición ecológica subnacional',
            organismo: 'Programa de cooperación descentralizada UE-América Latina',
            plazo: 'Convocatoria abierta',
            plazoStatus: 'abierta',
            argentina: true,
            ods: 'ODS 7, ODS 11',
            sector: 'Gobierno subnacional',
            modo: 'No reembolsable',
            monto: 'USD 75.000',
            fuente: 'Agente IA (Euroclima)'
        }
    ]
}">

    <!-- Banner de Estado de Integración API -->
    <div style="background:linear-gradient(135deg, #02071a 0%, #050d2a 50%, #0a1d48 100%); border:1px solid rgba(116,172,223,0.3); border-radius:18px; padding:22px 26px; box-shadow:0 12px 35px rgba(0,4,18,0.6);">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
            <div style="display:flex; align-items:center; gap:14px;">
                <span style="font-size:2rem;">🛰️</span>
                <div>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <h3 style="font-size:1.1rem; font-weight:800; color:#ffffff; margin:0;">Radar de Convocatorias · Flujo de Ingesta API</h3>
                        <span style="background:rgba(16,185,129,0.2); color:#34d399; border:1px solid rgba(16,185,129,0.4); font-size:0.65rem; font-weight:800; padding:3px 10px; border-radius:50px;">
                            ● SINCRONIZACIÓN ACTIVA
                        </span>
                    </div>
                    <p style="font-size:0.8rem; color:#94a3b8; margin:4px 0 0; line-height:1.5;">
                        Este módulo recibe automáticamente las oportunidades de financiamiento internacional detectadas por el agente de IA externo. Los registros validados se publican en tiempo real en la web pública (<strong>/radar</strong>).
                    </p>
                </div>
            </div>

            <div style="display:flex; align-items:center; gap:10px;">
                <button type="button" @click="showPayloadModal = true" style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.2); color:#ffffff; padding:9px 16px; border-radius:10px; font-size:0.75rem; font-weight:700; cursor:pointer; font-family:inherit;">
                    Ver Formato JSON de API {}
                </button>
                <a href="{{ route('radar') }}" target="_blank" style="background:#3057be; color:#ffffff; text-decoration:none; padding:9px 18px; border-radius:10px; font-size:0.75rem; font-weight:800; cursor:pointer; font-family:inherit; box-shadow:0 4px 15px rgba(48,87,190,0.4);">
                    Ver en Web Pública ↗
                </a>
            </div>
        </div>

        <!-- Métricas Rápidas -->
        <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:14px; margin-top:20px; padding-top:16px; border-top:1px solid rgba(255,255,255,0.08);">
            <div>
                <span style="font-size:0.68rem; color:#94a3b8; text-transform:uppercase; font-weight:700;">Oportunidades Activas</span>
                <div style="font-size:1.1rem; font-weight:800; color:#ffffff; margin-top:2px;">18 detectadas</div>
            </div>
            <div>
                <span style="font-size:0.68rem; color:#94a3b8; text-transform:uppercase; font-weight:700;">Último Ping del Agente</span>
                <div style="font-size:1.1rem; font-weight:800; color:#34d399; margin-top:2px;">Hace 14 min</div>
            </div>
            <div>
                <span style="font-size:0.68rem; color:#94a3b8; text-transform:uppercase; font-weight:700;">Publicadas en Web</span>
                <div style="font-size:1.1rem; font-weight:800; color:#74acdf; margin-top:2px;">6 destacadas</div>
            </div>
            <div>
                <span style="font-size:0.68rem; color:#94a3b8; text-transform:uppercase; font-weight:700;">Endpoint de Ingesta</span>
                <div style="font-size:0.8rem; font-family:monospace; color:#cbd5e1; margin-top:4px;">POST /api/v1/convocatorias</div>
            </div>
        </div>
    </div>

    <!-- Tabla Administrativa de Oportunidades -->
    <div class="radar-admin-table-box">
        <div style="padding:16px 22px; border-bottom:1px solid rgba(255,255,255,0.08); display:flex; justify-content:space-between; align-items:center; background:#081438;">
            <div>
                <span style="font-weight:800; color:#ffffff; font-size:0.9rem;">Convocatorias Sincronizadas</span>
                <span style="font-size:0.75rem; color:#94a3b8; margin-left:8px;">(Estructura idéntica a la maqueta de referencia)</span>
            </div>
            <button type="button" @click="showToast('Simulando consulta... ¡5 convocatorias sincronizadas!')" style="background:none; border:none; color:#74acdf; font-weight:700; font-size:0.75rem; cursor:pointer; font-family:inherit;">
                ↻ Forzar Sincronización
            </button>
        </div>

        <table class="radar-admin-table">
            <thead>
                <tr>
                    <th>Título Convocatoria</th>
                    <th>Organismo Emisor</th>
                    <th>Plazo Restante</th>
                    <th>Alcance</th>
                    <th>Monto / Modalidad</th>
                    <th>Fuente Ingesta</th>
                    <th style="text-align:right;">Estado</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="item in items" :key="item.id">
                    <tr>
                        <td>
                            <div style="font-weight:800; color:#ffffff; font-size:0.88rem;" x-text="item.titulo"></div>
                            <div style="font-size:0.72rem; color:#94a3b8; margin-top:2px;" x-text="item.sector + ' · ' + item.ods"></div>
                        </td>
                        <td style="font-weight:700; color:#74acdf;" x-text="item.organismo"></td>
                        <td>
                            <span style="padding:4px 10px; border-radius:50px; font-size:0.72rem; font-weight:800;"
                                  :style="{
                                      background: item.plazoStatus === 'urge' ? 'rgba(239,68,68,0.2)' : 
                                                 (item.plazoStatus === 'pronto' ? 'rgba(245,158,11,0.2)' : 
                                                 (item.plazoStatus === 'amplio' ? 'rgba(16,185,129,0.2)' : 'rgba(56,189,248,0.2)')),
                                      color: item.plazoStatus === 'urge' ? '#f87171' : 
                                             (item.plazoStatus === 'pronto' ? '#fbbf24' : 
                                             (item.plazoStatus === 'amplio' ? '#34d399' : '#38bdf8'))
                                  }"
                                  x-text="item.plazo"></span>
                        </td>
                        <td>
                            <template x-if="item.argentina">
                                <span style="background:#000412; color:#74acdf; border:1px solid rgba(116,172,223,0.3); padding:3px 8px; border-radius:4px; font-size:0.7rem; font-weight:800;">Argentina 🇦🇷</span>
                            </template>
                            <template x-if="!item.argentina">
                                <span style="color:#94a3b8; font-size:0.75rem;">Global / Regional 🌐</span>
                            </template>
                        </td>
                        <td>
                            <div style="font-weight:800; color:#ffffff;" x-text="item.monto"></div>
                            <div style="font-size:0.72rem; color:#94a3b8;" x-text="item.modo"></div>
                        </td>
                        <td style="font-family:monospace; font-size:0.72rem; color:#94a3b8;" x-text="item.fuente"></td>
                        <td style="text-align:right;">
                            <span style="background:rgba(16,185,129,0.2); color:#34d399; border:1px solid rgba(16,185,129,0.3); padding:3px 10px; border-radius:50px; font-size:0.7rem; font-weight:800;">
                                ● Publicado
                            </span>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <!-- Modal Formato JSON API -->
    <div x-show="showPayloadModal" x-cloak style="position:fixed; inset:0; z-index:999999; background:rgba(0,4,18,0.85); backdrop-filter:blur(10px); display:flex; align-items:center; justify-content:center; padding:20px;">
        <div @click.away="showPayloadModal = false" style="background:#050d2a; border:1px solid rgba(116,172,223,0.35); border-radius:18px; max-width:600px; width:100%; padding:24px; box-shadow:0 25px 60px rgba(0,0,0,0.8); color:#ffffff;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; padding-bottom:12px; border-bottom:1px solid rgba(255,255,255,0.08);">
                <h3 style="font-size:1rem; font-weight:800; color:#ffffff; margin:0;">Estructura del Payload API (POST /api/v1/convocatorias)</h3>
                <button type="button" @click="showPayloadModal = false" style="background:none; border:none; color:#94a3b8; font-size:1.3rem; cursor:pointer;">✕</button>
            </div>
            <p style="font-size:0.78rem; color:#cbd5e1; margin-bottom:12px; line-height:1.5;">
                Esquema JSON que debe enviar el agente de IA externo para inyectar oportunidades detectadas:
            </p>
            <pre style="background:#000412; color:#34d399; padding:16px; border-radius:12px; font-family:monospace; font-size:0.75rem; overflow-x:auto; border:1px solid rgba(255,255,255,0.1); line-height:1.6;">{
  "titulo": "Adaptación climática en América Latina y el Caribe (AFCIA)",
  "organismo": "UN CTCN · Fondo de Adaptación",
  "fecha_limite": "2026-10-14",
  "alcance_argentina": true,
  "resumen": "Asistencia técnica para soluciones innovadoras...",
  "ods": ["ODS 13"],
  "sector_elegible": "Universidades / I+D",
  "modalidad": "Asistencia técnica",
  "monto_estimado": "USD 250.000",
  "url_original": "https://www.ctc-n.org/grants",
  "requisitos": "Postulación en consorcio con aval de la entidad nacional..."
}</pre>
            <div style="display:flex; justify-content:flex-end; margin-top:16px;">
                <button type="button" @click="showPayloadModal = false" style="background:#3057be; color:white; border:none; padding:8px 18px; border-radius:8px; font-weight:700; font-size:0.75rem; cursor:pointer;">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div x-show="toastMsg" x-cloak style="position:fixed; bottom:24px; right:24px; z-index:999999; background:#10b981; color:#ffffff; padding:12px 20px; border-radius:12px; font-weight:800; font-size:0.8rem; box-shadow:0 10px 30px rgba(0,0,0,0.5);">
        <span>✓</span>
        <span x-text="toastMsg"></span>
    </div>

</div>
</x-filament-panels::page>
