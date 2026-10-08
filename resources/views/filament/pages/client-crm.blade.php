<x-filament-panels::page>
<style>
    /* ═════════════════════════════════════════════════════════════
       ESTILOS DEDICADOS PARA EL CRM DE CLIENTES (POLARIS THEME)
       ═════════════════════════════════════════════════════════════ */
    .crm-container {
        font-family: 'Montserrat', sans-serif;
        color: #ffffff;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .crm-banner {
        background: linear-gradient(135deg, #02071a 0%, #050d2a 50%, #0a1d48 100%);
        border: 1px solid rgba(116, 172, 223, 0.3);
        border-radius: 18px;
        padding: 22px 26px;
        box-shadow: 0 12px 35px rgba(0, 4, 18, 0.6);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .crm-toolbar {
        background: #050d2a;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 16px;
        padding: 14px 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 20px rgba(0, 4, 18, 0.4);
    }
    .crm-input {
        background: #000412;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        color: #ffffff;
        padding: 9px 14px;
        font-size: 0.82rem;
        outline: none;
        min-width: 240px;
        font-family: inherit;
        transition: border-color 0.2s;
    }
    .crm-input:focus { border-color: #74acdf; }
    .crm-select {
        background: #000412;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        color: #ffffff;
        padding: 9px 14px;
        font-size: 0.82rem;
        outline: none;
        font-family: inherit;
        cursor: pointer;
    }
    .crm-select option { background: #050d2a; color: #ffffff; }

    .crm-view-switcher {
        display: flex;
        gap: 6px;
        background: #000412;
        padding: 4px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .crm-btn-view {
        background: transparent;
        border: none;
        color: rgba(255, 255, 255, 0.6);
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        font-family: inherit;
    }
    .crm-btn-view.active {
        background: #3057be;
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(48, 87, 190, 0.4);
    }

    /* Tabla */
    .crm-table-box {
        background: #050d2a;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0, 4, 18, 0.6);
    }
    .crm-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.82rem;
    }
    .crm-table thead th {
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
    .crm-table tbody tr {
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        cursor: pointer;
        transition: background 0.2s;
    }
    .crm-table tbody tr:hover {
        background: rgba(48, 87, 190, 0.18);
    }
    .crm-table tbody td {
        padding: 16px 20px;
        vertical-align: middle;
        color: #e2e8f0;
    }

    .crm-client-title {
        font-weight: 800;
        color: #ffffff;
        font-size: 0.9rem;
    }
    .crm-client-sub {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 3px;
        font-weight: 500;
    }

    /* Badges de Actor */
    .crm-actor {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .actor-public  { background: rgba(59, 130, 246, 0.18); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.35); }
    .actor-private { background: rgba(16, 185, 129, 0.18); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.35); }
    .actor-camara  { background: rgba(245, 158, 11, 0.18); color: #fde68a; border: 1px solid rgba(245, 158, 11, 0.35); }
    .actor-mixto   { background: rgba(139, 92, 246, 0.18); color: #c4b5fd; border: 1px solid rgba(139, 92, 246, 0.35); }

    /* Badges de Etapa Pipeline */
    .crm-stage {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 800;
        white-space: nowrap;
    }
    .stage-diagnostico { background: rgba(48, 87, 190, 0.25); color: #74acdf; border: 1px solid rgba(116, 172, 223, 0.4); }
    .stage-estrategia  { background: rgba(56, 189, 248, 0.2);  color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.4); }
    .stage-gestion     { background: rgba(245, 158, 11, 0.2);  color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.45); }
    .stage-ejecucion   { background: rgba(16, 185, 129, 0.2);  color: #34d399; border: 1px solid rgba(16, 185, 129, 0.45); }
    .stage-completado  { background: rgba(168, 85, 247, 0.2);  color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.45); }

    .stage-dot { width: 7px; height: 7px; border-radius: 50%; }

    .crm-budget {
        font-weight: 800;
        color: #ffffff;
        font-size: 0.88rem;
    }
    .crm-lead-box {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        color: #ffffff;
    }
    .crm-avatar {
        width: 24px; height: 24px;
        border-radius: 50%;
        background: #3057be;
        color: #ffffff;
        font-size: 0.7rem;
        font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 0 8px rgba(48, 87, 190, 0.5);
    }

    .crm-btn-action {
        background: rgba(48, 87, 190, 0.25);
        color: #74acdf;
        border: 1px solid rgba(116, 172, 223, 0.35);
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.74rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
        font-family: inherit;
    }
    .crm-btn-action:hover {
        background: #3057be;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(48, 87, 190, 0.4);
    }

    /* Tablero Kanban */
    .crm-kanban-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
    }
    .crm-column {
        background: #050d2a;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 16px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        min-height: 480px;
    }
    .crm-col-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        font-size: 0.78rem;
        font-weight: 800;
    }
    .crm-card {
        background: #081438;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .crm-card:hover {
        border-color: #3057be;
        box-shadow: 0 10px 25px rgba(0, 4, 18, 0.7);
        transform: translateY(-2px);
    }

    /* Modal */
    .crm-modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0, 4, 18, 0.85);
        backdrop-filter: blur(12px);
        z-index: 99999;
        display: flex; align-items: center; justify-content: center;
        padding: 20px;
    }
    .crm-modal-box {
        background: #050d2a;
        border: 1px solid rgba(116, 172, 223, 0.35);
        border-radius: 20px;
        max-width: 720px; width: 100%;
        max-height: 90vh; overflow-y: auto;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8);
        color: #ffffff;
        display: flex; flex-direction: column;
    }
    .crm-modal-head {
        padding: 20px 26px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        background: #081438;
        display: flex; align-items: center; justify-content: space-between;
    }
    .crm-modal-body {
        padding: 26px;
        display: flex; flex-direction: column; gap: 20px;
        font-size: 0.85rem;
    }
    .crm-modal-foot {
        padding: 18px 26px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        background: #081438;
        display: flex; align-items: center; justify-content: space-between;
    }

    @media (max-width: 1100px) {
        .crm-kanban-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="crm-container" x-data="{
    viewMode: 'table',
    search: '',
    filterActor: 'all',
    filterStage: 'all',
    selectedProject: null,
    showNewModal: false,
    toastMsg: '',
    showToast(msg) {
        this.toastMsg = msg;
        setTimeout(() => { this.toastMsg = ''; }, 3500);
    },
    projects: [
        {
            id: 1,
            name: 'Consorcio Agroindustrial NOA',
            contactName: 'Ing. Martín Zavaleta (Presidente)',
            contactEmail: 'mzavaleta@agronoa.org.ar',
            actor: 'Sector Privado',
            actorKey: 'private',
            service: 'Misión Comercial & Vinculación',
            destination: '🇪🇺 España & Italia',
            stage: 'En Ejecución',
            stageKey: 'ejecucion',
            lead: 'Andrés M.',
            budget: 'USD 65.000',
            progress: 75,
            nextMilestone: 'Ronda de Negocios B2B en Madrid',
            nextDate: '15 Nov 2026',
            notes: 'Agenda validada con agregaduría comercial en embajada. 8 empresas participantes listas.',
            timeline: [
                { date: '10 Ago', title: 'Diagnóstico de oferta exportable', done: true },
                { date: '02 Sep', title: 'Validación de contrapartes europeas', done: true },
                { date: '28 Sep', title: 'Confirmación de agenda B2B Madrid', done: true },
                { date: '15 Nov', title: 'Viaje y reuniones de alto nivel', done: false },
                { date: '05 Dic', title: 'Evaluación y acuerdos de provisión', done: false }
            ]
        },
        {
            id: 2,
            name: 'Municipio de San Miguel',
            contactName: 'Lic. Clara Benítez (Sec. Hacienda)',
            contactEmail: 'cooperacion@smt.gob.ar',
            actor: 'Sector Público',
            actorKey: 'public',
            service: 'Financiamiento Multilateral',
            destination: '🌐 Organismos de Crédito (BID / CAF)',
            stage: 'En Negociación',
            stageKey: 'gestion',
            lead: 'Giuliano V.',
            budget: 'USD 450.000',
            progress: 50,
            nextMilestone: 'Entrega de Pliego Técnico para Precalificación',
            nextDate: '24 Oct 2026',
            notes: 'Proyecto de modernización urbana y movilidad sustentable con tasa subsidiada.',
            timeline: [
                { date: '15 Jul', title: 'Relevamiento y perfil de proyecto', done: true },
                { date: '20 Ago', title: 'Presentación de nota de prioridad', done: true },
                { date: '24 Oct', title: 'Pliego técnico y matriz de riesgo', done: false },
                { date: '15 Dic', title: 'Comité de aprobación multilateral', done: false }
            ]
        },
        {
            id: 3,
            name: 'Fintech Solutions Latam',
            contactName: 'Rodrigo Albarracín (CEO)',
            contactEmail: 'rodrigo@fintechlatam.io',
            actor: 'Sector Privado',
            actorKey: 'private',
            service: 'Soft Landing & Apertura de Filial',
            destination: '🇧🇷 São Paulo, Brasil',
            stage: 'Diseño Estratégico',
            stageKey: 'estrategia',
            lead: 'Sofía R.',
            budget: 'USD 35.000',
            progress: 30,
            nextMilestone: 'Selección de Estudio Jurídico y Tributario local',
            nextDate: '02 Nov 2026',
            notes: 'Estructuración societaria para operar en el hub financiero paulista sin sobrecosto de entrada.',
            timeline: [
                { date: '01 Sep', title: 'Benchmark regulatorio fintech Brasil', done: true },
                { date: '02 Nov', title: 'Selección de partners de compliance', done: false },
                { date: '20 Dic', title: 'Apertura de cuenta corporativa', done: false }
            ]
        },
        {
            id: 4,
            name: 'Agencia Provincial de Innovación',
            contactName: 'Dra. Elena Rossi (Directora Ejecutiva)',
            contactEmail: 'erossi@innovacionprovincial.gob.ar',
            actor: 'Sector Público',
            actorKey: 'public',
            service: 'Cooperación Descentralizada',
            destination: '🇫🇷 Francia (Región Occitania)',
            stage: 'Completado',
            stageKey: 'completado',
            lead: 'Andrés M.',
            budget: 'EUR 120.000',
            progress: 100,
            nextMilestone: 'Rendición final y caso de estudio publicado',
            nextDate: 'Finalizado',
            notes: 'Convenio de cooperación técnica birregional firmado con fondos no reembolsables.',
            timeline: [
                { date: '10 Feb', title: 'Contacto y firma de carta de intención', done: true },
                { date: '15 May', title: 'Misión técnica francesa en territorio', done: true },
                { date: '20 Jul', title: 'Desembolso y ejecución de capacitaciones', done: true },
                { date: '30 Sep', title: 'Informe de impacto y cierre', done: true }
            ]
        },
        {
            id: 5,
            name: 'Cámara Vitivinícola de Altura',
            contactName: 'Federico Montero (Gerente General)',
            contactEmail: 'gerencia@vinosdealtura.com.ar',
            actor: 'Cámara Empresarial',
            actorKey: 'camara',
            service: 'Inteligencia Comercial & Expansión',
            destination: '🇺🇸 Estados Unidos (Costa Este)',
            stage: 'Diagnóstico Inicial',
            stageKey: 'diagnostico',
            lead: 'Giuliano V.',
            budget: 'USD 28.000',
            progress: 15,
            nextMilestone: 'Taller de autodiagnóstico de exportabilidad',
            nextDate: '28 Oct 2026',
            notes: 'Consolidación de 6 bodegas boutique para compartir contenedor y distribuidor común.',
            timeline: [
                { date: '25 Sep', title: 'Reunión inicial con comisión directiva', done: true },
                { date: '28 Oct', title: 'Taller de madurez exportadora', done: false },
                { date: '20 Nov', title: 'Mapeo de importadores en NY y Miami', done: false }
            ]
        },
        {
            id: 6,
            name: 'Hub Biotecnológico BioNOA',
            contactName: 'Dr. Lucas Mansilla (Investigador Principal)',
            contactEmail: 'lmansilla@bionoa.org',
            actor: 'Consorcio Mixto',
            actorKey: 'mixto',
            service: 'Programa Horizonte Europa',
            destination: '🇪🇺 Bruselas / Alemania',
            stage: 'En Negociación',
            stageKey: 'gestion',
            lead: 'Andrés M.',
            budget: 'EUR 280.000',
            progress: 60,
            nextMilestone: 'Carta de acuerdo con consorcio líder en Múnich',
            nextDate: '10 Nov 2026',
            notes: 'Participación confirmada en consorcio europeo de bioeconomía circular.',
            timeline: [
                { date: '14 Jun', title: 'Identificación de convocatoria Horizonte Europa', done: true },
                { date: '12 Ago', title: 'Pitch deck y vinculación con líder alemán', done: true },
                { date: '10 Nov', title: 'Firma de consorcio y submission', done: false },
                { date: '15 Ene', title: 'Dictamen de la Comisión Europea', done: false }
            ]
        }
    ],
    get filteredProjects() {
        return this.projects.filter(p => {
            const matchesSearch = !this.search || 
                p.name.toLowerCase().includes(this.search.toLowerCase()) ||
                p.service.toLowerCase().includes(this.search.toLowerCase()) ||
                p.destination.toLowerCase().includes(this.search.toLowerCase());
            
            const matchesActor = this.filterActor === 'all' || p.actorKey === this.filterActor;
            const matchesStage = this.filterStage === 'all' || p.stageKey === this.filterStage;
            
            return matchesSearch && matchesActor && matchesStage;
        });
    },
    getStageProjects(stageKey) {
        return this.filteredProjects.filter(p => p.stageKey === stageKey);
    }
}">

    <!-- ═════════════════════════════════════════════════════════════
         BANNER EXPLICATIVO
         ═════════════════════════════════════════════════════════════ -->
    <div class="crm-banner">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px;">
            <div style="display:flex; align-items:center; gap:12px;">
                <span style="font-size:1.8rem;">✨</span>
                <div>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <h3 style="font-size:1.05rem; font-weight:800; color:#ffffff; margin:0;">Prototipo Interactivo · Módulo CRM & Clientes (Reemplazo de Airtable)</h3>
                        <span style="background:rgba(245,158,11,0.2); color:#fbbf24; border:1px solid rgba(245,158,11,0.4); font-size:0.65rem; font-weight:800; padding:2px 8px; border-radius:50px;">EN SIMULACIÓN</span>
                    </div>
                    <p style="font-size:0.78rem; color:#94a3b8; margin:4px 0 0; line-height:1.5;">
                        Esta vista replica el flujo operativo de Polaris. Podés conmutar entre <strong>Vista Tabla (estilo Airtable)</strong> y <strong>Tablero Kanban</strong>, filtrar en tiempo real, abrir el <strong>expediente completo</strong> de cada cliente o probar el formulario de alta.
                    </p>
                </div>
            </div>
            <button type="button" @click="showNewModal = true" style="background:linear-gradient(135deg, #3057be 0%, #1e3a8a 100%); color:white; border:none; padding:10px 20px; border-radius:10px; font-weight:800; font-size:0.75rem; letter-spacing:0.05em; text-transform:uppercase; cursor:pointer; box-shadow:0 6px 18px rgba(48,87,190,0.4); font-family:inherit;">
                + Nuevo Cliente / Proyecto
            </button>
        </div>
    </div>

    <!-- ═════════════════════════════════════════════════════════════
         BARRA DE HERRAMIENTAS & CONMUTADOR
         ═════════════════════════════════════════════════════════════ -->
    <div class="crm-toolbar">
        <div style="display:flex; flex-wrap:wrap; gap:10px; align-items:center; flex:1;">
            <input type="text" x-model="search" placeholder="Buscar por cliente, destino o servicio..." class="crm-input">
            
            <select x-model="filterActor" class="crm-select">
                <option value="all">Todos los Actores</option>
                <option value="public">Sector Público</option>
                <option value="private">Sector Privado</option>
                <option value="camara">Cámaras Empresariales</option>
                <option value="mixto">Consorcios Mixtos</option>
            </select>

            <select x-model="filterStage" class="crm-select">
                <option value="all">Todas las Etapas</option>
                <option value="diagnostico">1. Diagnóstico Inicial</option>
                <option value="estrategia">2. Diseño Estratégico</option>
                <option value="gestion">3. En Negociación</option>
                <option value="ejecucion">4. En Ejecución</option>
                <option value="completado">5. Completado</option>
            </select>
        </div>

        <div class="crm-view-switcher">
            <button type="button" class="crm-btn-view" :class="{ 'active': viewMode === 'table' }" @click="viewMode = 'table'">
                <span>📋</span>
                <span>Tabla (Airtable)</span>
            </button>
            <button type="button" class="crm-btn-view" :class="{ 'active': viewMode === 'kanban' }" @click="viewMode = 'kanban'">
                <span>📊</span>
                <span>Tablero Pipeline</span>
            </button>
        </div>
    </div>

    <!-- ═════════════════════════════════════════════════════════════
         VISTA 1: TABLA (GRID AIRTABLE STYLE)
         ═════════════════════════════════════════════════════════════ -->
    <div x-show="viewMode === 'table'" class="crm-table-box">
        <table class="crm-table">
            <thead>
                <tr>
                    <th>Organización / Cliente</th>
                    <th>Tipo de Actor</th>
                    <th>Servicio Polaris</th>
                    <th>Mercado Objetivo</th>
                    <th>Etapa Pipeline</th>
                    <th>Líder</th>
                    <th>Presupuesto</th>
                    <th>Próximo Hito / Fecha</th>
                    <th style="text-align:right;">Acción</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="p in filteredProjects" :key="p.id">
                    <tr @click="selectedProject = p">
                        <td>
                            <div class="crm-client-title" x-text="p.name"></div>
                            <div class="crm-client-sub" x-text="p.contactName"></div>
                        </td>
                        <td>
                            <span class="crm-actor" 
                                  :class="{
                                      'actor-public': p.actorKey === 'public',
                                      'actor-private': p.actorKey === 'private',
                                      'actor-camara': p.actorKey === 'camara',
                                      'actor-mixto': p.actorKey === 'mixto'
                                  }" 
                                  x-text="p.actor"></span>
                        </td>
                        <td style="color:#ffffff; font-weight:600;" x-text="p.service"></td>
                        <td style="color:#cbd5e1; font-weight:700;" x-text="p.destination"></td>
                        <td>
                            <span class="crm-stage" 
                                  :class="{
                                      'stage-diagnostico': p.stageKey === 'diagnostico',
                                      'stage-estrategia': p.stageKey === 'estrategia',
                                      'stage-gestion': p.stageKey === 'gestion',
                                      'stage-ejecucion': p.stageKey === 'ejecucion',
                                      'stage-completado': p.stageKey === 'completado'
                                  }">
                                <span class="stage-dot" 
                                      :style="{
                                          background: p.stageKey === 'diagnostico' ? '#74acdf' : 
                                                     (p.stageKey === 'estrategia' ? '#38bdf8' : 
                                                     (p.stageKey === 'gestion' ? '#fbbf24' : 
                                                     (p.stageKey === 'ejecucion' ? '#34d399' : '#c084fc')))
                                      }"></span>
                                <span x-text="p.stage"></span>
                            </span>
                        </td>
                        <td>
                            <div class="crm-lead-box">
                                <div class="crm-avatar" x-text="p.lead.substring(0, 1)"></div>
                                <span x-text="p.lead"></span>
                            </div>
                        </td>
                        <td>
                            <span class="crm-budget" x-text="p.budget"></span>
                        </td>
                        <td>
                            <div style="font-weight:700; color:#ffffff;" x-text="p.nextMilestone"></div>
                            <div style="font-size:0.72rem; color:#94a3b8; margin-top:2px;" x-text="p.nextDate"></div>
                        </td>
                        <td style="text-align:right;">
                            <button type="button" class="crm-btn-action">Ver Ficha →</button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <!-- ═════════════════════════════════════════════════════════════
         VISTA 2: TABLERO KANBAN
         ═════════════════════════════════════════════════════════════ -->
    <div x-show="viewMode === 'kanban'" class="crm-kanban-grid">
        
        <!-- Columna 1 -->
        <div class="crm-column">
            <div class="crm-col-header" style="color:#74acdf;">
                <span style="display:flex; align-items:center; gap:6px;">
                    <span style="width:8px; height:8px; border-radius:50%; background:#74acdf;"></span>
                    <span>1. Diagnóstico</span>
                </span>
                <span style="background:rgba(116,172,223,0.2); padding:2px 8px; border-radius:50px;" x-text="getStageProjects('diagnostico').length"></span>
            </div>
            <template x-for="p in getStageProjects('diagnostico')" :key="p.id">
                <div class="crm-card" @click="selectedProject = p">
                    <div style="display:flex; justify-content:space-between; font-size:0.7rem; color:#94a3b8;">
                        <span x-text="p.actor"></span>
                        <strong style="color:#ffffff;" x-text="p.budget"></strong>
                    </div>
                    <div style="font-weight:800; font-size:0.85rem; color:#ffffff;" x-text="p.name"></div>
                    <div style="font-size:0.75rem; color:#cbd5e1;" x-text="p.service"></div>
                    <div style="display:flex; justify-content:space-between; font-size:0.72rem; border-top:1px solid rgba(255,255,255,0.08); padding-top:8px; margin-top:4px;">
                        <span style="color:#74acdf;" x-text="p.destination"></span>
                        <span style="font-weight:700; color:#ffffff;" x-text="p.lead"></span>
                    </div>
                </div>
            </template>
        </div>

        <!-- Columna 2 -->
        <div class="crm-column">
            <div class="crm-col-header" style="color:#38bdf8;">
                <span style="display:flex; align-items:center; gap:6px;">
                    <span style="width:8px; height:8px; border-radius:50%; background:#38bdf8;"></span>
                    <span>2. Estrategia</span>
                </span>
                <span style="background:rgba(56,189,248,0.2); padding:2px 8px; border-radius:50px;" x-text="getStageProjects('estrategia').length"></span>
            </div>
            <template x-for="p in getStageProjects('estrategia')" :key="p.id">
                <div class="crm-card" @click="selectedProject = p">
                    <div style="display:flex; justify-content:space-between; font-size:0.7rem; color:#94a3b8;">
                        <span x-text="p.actor"></span>
                        <strong style="color:#ffffff;" x-text="p.budget"></strong>
                    </div>
                    <div style="font-weight:800; font-size:0.85rem; color:#ffffff;" x-text="p.name"></div>
                    <div style="font-size:0.75rem; color:#cbd5e1;" x-text="p.service"></div>
                    <div style="display:flex; justify-content:space-between; font-size:0.72rem; border-top:1px solid rgba(255,255,255,0.08); padding-top:8px; margin-top:4px;">
                        <span style="color:#38bdf8;" x-text="p.destination"></span>
                        <span style="font-weight:700; color:#ffffff;" x-text="p.lead"></span>
                    </div>
                </div>
            </template>
        </div>

        <!-- Columna 3 -->
        <div class="crm-column">
            <div class="crm-col-header" style="color:#fbbf24;">
                <span style="display:flex; align-items:center; gap:6px;">
                    <span style="width:8px; height:8px; border-radius:50%; background:#fbbf24;"></span>
                    <span>3. Negociación</span>
                </span>
                <span style="background:rgba(245,158,11,0.2); padding:2px 8px; border-radius:50px;" x-text="getStageProjects('gestion').length"></span>
            </div>
            <template x-for="p in getStageProjects('gestion')" :key="p.id">
                <div class="crm-card" @click="selectedProject = p">
                    <div style="display:flex; justify-content:space-between; font-size:0.7rem; color:#94a3b8;">
                        <span x-text="p.actor"></span>
                        <strong style="color:#ffffff;" x-text="p.budget"></strong>
                    </div>
                    <div style="font-weight:800; font-size:0.85rem; color:#ffffff;" x-text="p.name"></div>
                    <div style="font-size:0.75rem; color:#cbd5e1;" x-text="p.service"></div>
                    <div style="display:flex; justify-content:space-between; font-size:0.72rem; border-top:1px solid rgba(255,255,255,0.08); padding-top:8px; margin-top:4px;">
                        <span style="color:#fbbf24;" x-text="p.destination"></span>
                        <span style="font-weight:700; color:#ffffff;" x-text="p.lead"></span>
                    </div>
                </div>
            </template>
        </div>

        <!-- Columna 4 -->
        <div class="crm-column">
            <div class="crm-col-header" style="color:#34d399;">
                <span style="display:flex; align-items:center; gap:6px;">
                    <span style="width:8px; height:8px; border-radius:50%; background:#34d399;"></span>
                    <span>4. En Ejecución</span>
                </span>
                <span style="background:rgba(16,185,129,0.2); padding:2px 8px; border-radius:50px;" x-text="getStageProjects('ejecucion').length"></span>
            </div>
            <template x-for="p in getStageProjects('ejecucion')" :key="p.id">
                <div class="crm-card" @click="selectedProject = p">
                    <div style="display:flex; justify-content:space-between; font-size:0.7rem; color:#94a3b8;">
                        <span x-text="p.actor"></span>
                        <strong style="color:#ffffff;" x-text="p.budget"></strong>
                    </div>
                    <div style="font-weight:800; font-size:0.85rem; color:#ffffff;" x-text="p.name"></div>
                    <div style="font-size:0.75rem; color:#cbd5e1;" x-text="p.service"></div>
                    <div style="display:flex; justify-content:space-between; font-size:0.72rem; border-top:1px solid rgba(255,255,255,0.08); padding-top:8px; margin-top:4px;">
                        <span style="color:#34d399;" x-text="p.destination"></span>
                        <span style="font-weight:700; color:#ffffff;" x-text="p.lead"></span>
                    </div>
                </div>
            </template>
        </div>

        <!-- Columna 5 -->
        <div class="crm-column">
            <div class="crm-col-header" style="color:#c084fc;">
                <span style="display:flex; align-items:center; gap:6px;">
                    <span style="width:8px; height:8px; border-radius:50%; background:#c084fc;"></span>
                    <span>5. Completado</span>
                </span>
                <span style="background:rgba(168,85,247,0.2); padding:2px 8px; border-radius:50px;" x-text="getStageProjects('completado').length"></span>
            </div>
            <template x-for="p in getStageProjects('completado')" :key="p.id">
                <div class="crm-card" @click="selectedProject = p">
                    <div style="display:flex; justify-content:space-between; font-size:0.7rem; color:#94a3b8;">
                        <span x-text="p.actor"></span>
                        <strong style="color:#ffffff;" x-text="p.budget"></strong>
                    </div>
                    <div style="font-weight:800; font-size:0.85rem; color:#ffffff;" x-text="p.name"></div>
                    <div style="font-size:0.75rem; color:#cbd5e1;" x-text="p.service"></div>
                    <div style="display:flex; justify-content:space-between; font-size:0.72rem; border-top:1px solid rgba(255,255,255,0.08); padding-top:8px; margin-top:4px;">
                        <span style="color:#c084fc;" x-text="p.destination"></span>
                        <span style="font-weight:700; color:#ffffff;" x-text="p.lead"></span>
                    </div>
                </div>
            </template>
        </div>

    </div>

    <!-- ═════════════════════════════════════════════════════════════
         MODAL: EXPEDIENTE COMPLETO DEL CLIENTE
         ═════════════════════════════════════════════════════════════ -->
    <div class="crm-modal-overlay" x-show="selectedProject" x-cloak @keydown.escape.window="selectedProject = null">
        <div class="crm-modal-box" @click.away="selectedProject = null">
            
            <div class="crm-modal-head">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="width:40px; height:40px; border-radius:10px; background:#3057be; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:1.1rem; color:#ffffff;">
                        <span x-text="selectedProject ? selectedProject.name.charAt(0) : ''"></span>
                    </div>
                    <div>
                        <div style="font-size:1.1rem; font-weight:800; color:#ffffff;" x-text="selectedProject ? selectedProject.name : ''"></div>
                        <div style="font-size:0.75rem; color:#74acdf;" x-text="selectedProject ? selectedProject.service + ' · ' + selectedProject.destination : ''"></div>
                    </div>
                </div>
                <button type="button" @click="selectedProject = null" style="background:none; border:none; color:#94a3b8; font-size:1.3rem; cursor:pointer;">✕</button>
            </div>

            <div class="crm-modal-body">
                
                <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:12px; background:#081438; border:1px solid rgba(255,255,255,0.08); border-radius:14px; padding:16px;">
                    <div>
                        <div style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase; font-weight:700;">Presupuesto / Fondos</div>
                        <div style="font-size:1rem; font-weight:900; color:#ffffff; margin-top:3px;" x-text="selectedProject ? selectedProject.budget : ''"></div>
                    </div>
                    <div>
                        <div style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase; font-weight:700;">Líder Asignado</div>
                        <div style="font-size:1rem; font-weight:800; color:#74acdf; margin-top:3px;" x-text="selectedProject ? selectedProject.lead : ''"></div>
                    </div>
                    <div>
                        <div style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase; font-weight:700;">Avance General</div>
                        <div style="font-size:1rem; font-weight:900; color:#34d399; margin-top:3px;" x-text="selectedProject ? selectedProject.progress + '%' : ''"></div>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div style="background:#081438; border:1px solid rgba(255,255,255,0.08); border-radius:12px; padding:14px;">
                        <div style="font-size:0.7rem; font-weight:800; text-transform:uppercase; color:#74acdf; margin-bottom:4px;">Contacto Institucional</div>
                        <div style="font-weight:700; color:#ffffff;" x-text="selectedProject ? selectedProject.contactName : ''"></div>
                        <div style="font-size:0.75rem; color:#94a3b8;" x-text="selectedProject ? selectedProject.contactEmail : ''"></div>
                    </div>
                    <div style="background:#081438; border:1px solid rgba(255,255,255,0.08); border-radius:12px; padding:14px;">
                        <div style="font-size:0.7rem; font-weight:800; text-transform:uppercase; color:#74acdf; margin-bottom:4px;">Próximo Hito Crítico</div>
                        <div style="font-weight:700; color:#ffffff;" x-text="selectedProject ? selectedProject.nextMilestone : ''"></div>
                        <div style="font-size:0.75rem; color:#94a3b8;">Fecha: <strong style="color:#ffffff;" x-text="selectedProject ? selectedProject.nextDate : ''"></strong></div>
                    </div>
                </div>

                <div>
                    <h5 style="font-size:0.8rem; font-weight:800; text-transform:uppercase; color:#ffffff; margin:0 0 10px;">Línea de Tiempo de Ejecución</h5>
                    <div style="display:flex; flex-direction:column; gap:8px;">
                        <template x-for="item in (selectedProject ? selectedProject.timeline : [])" :key="item.title">
                            <div style="display:flex; align-items:center; gap:10px; padding:10px 14px; background:#081438; border-radius:8px; border:1px solid rgba(255,255,255,0.06);">
                                <span style="font-weight:900;" :style="{ color: item.done ? '#34d399' : '#94a3b8' }" x-text="item.done ? '✓' : '○'"></span>
                                <span style="flex:1; font-weight:600;" :style="{ color: item.done ? '#94a3b8' : '#ffffff', textDecoration: item.done ? 'line-through' : 'none' }" x-text="item.title"></span>
                                <span style="font-size:0.72rem; color:#94a3b8; font-weight:700;" x-text="item.date"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <div style="background:rgba(48,87,190,0.15); border:1px solid rgba(116,172,223,0.3); border-radius:12px; padding:16px;">
                    <div style="font-size:0.72rem; font-weight:800; text-transform:uppercase; color:#74acdf; margin-bottom:4px;">Bitácora Interna Polaris</div>
                    <p style="margin:0; font-size:0.8rem; line-height:1.6; color:#e2e8f0;" x-text="selectedProject ? selectedProject.notes : ''"></p>
                </div>

            </div>

            <div class="crm-modal-foot">
                <span style="font-size:0.75rem; color:#94a3b8;">Expediente Polaris #POL-0<span x-text="selectedProject ? selectedProject.id : '1'"></span></span>
                <div style="display:flex; gap:10px;">
                    <button type="button" @click="selectedProject = null" style="background:none; border:1px solid rgba(255,255,255,0.2); color:#ffffff; padding:8px 18px; border-radius:8px; font-weight:700; font-size:0.75rem; cursor:pointer;">
                        Cerrar
                    </button>
                    <button type="button" @click="selectedProject = null; showToast('¡Expediente actualizado con éxito en la simulación!')" style="background:#3057be; border:none; color:#ffffff; padding:8px 20px; border-radius:8px; font-weight:800; font-size:0.75rem; cursor:pointer; box-shadow:0 4px 15px rgba(48,87,190,0.4);">
                        Guardar Cambios
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- ═════════════════════════════════════════════════════════════
         MODAL: NUEVO REGISTRO
         ═════════════════════════════════════════════════════════════ -->
    <div class="crm-modal-overlay" x-show="showNewModal" x-cloak @keydown.escape.window="showNewModal = false">
        <div class="crm-modal-box" style="max-width:580px;" @click.away="showNewModal = false">
            <div class="crm-modal-head">
                <div>
                    <h3 style="font-size:1.05rem; font-weight:800; color:#ffffff; margin:0;">Nuevo Cliente / Proyecto Internacional</h3>
                    <p style="font-size:0.72rem; color:#94a3b8; margin:2px 0 0;">Ingreso de registro al flujo de gestión Polaris</p>
                </div>
                <button type="button" @click="showNewModal = false" style="background:none; border:none; color:#94a3b8; font-size:1.3rem; cursor:pointer;">✕</button>
            </div>

            <div class="crm-modal-body">
                <div>
                    <label style="display:block; font-size:0.75rem; font-weight:800; color:#ffffff; margin-bottom:6px;">Organización / Cliente</label>
                    <input type="text" placeholder="Ej: Cámara de Comercio / Municipio de Yerba Buena" class="crm-input" style="width:100%;">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div>
                        <label style="display:block; font-size:0.75rem; font-weight:800; color:#ffffff; margin-bottom:6px;">Tipo de Actor</label>
                        <select class="crm-select" style="width:100%;">
                            <option>Sector Público (Subnacional)</option>
                            <option>Sector Privado (Empresa / Pyme)</option>
                            <option>Cámara Empresarial</option>
                            <option>Consorcio Mixto</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:0.75rem; font-weight:800; color:#ffffff; margin-bottom:6px;">Línea de Servicio</label>
                        <select class="crm-select" style="width:100%;">
                            <option>Misión Comercial</option>
                            <option>Financiamiento Multilateral</option>
                            <option>Soft Landing & Expansión</option>
                            <option>Cooperación Descentralizada</option>
                        </select>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div>
                        <label style="display:block; font-size:0.75rem; font-weight:800; color:#ffffff; margin-bottom:6px;">Mercado Objetivo</label>
                        <input type="text" placeholder="Ej: 🇪🇺 España, 🇧🇷 Brasil, 🌐 BID" class="crm-input" style="width:100%;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.75rem; font-weight:800; color:#ffffff; margin-bottom:6px;">Presupuesto Estimado</label>
                        <input type="text" placeholder="Ej: USD 50.000" class="crm-input" style="width:100%;">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div>
                        <label style="display:block; font-size:0.75rem; font-weight:800; color:#ffffff; margin-bottom:6px;">Etapa Inicial</label>
                        <select class="crm-select" style="width:100%;">
                            <option>1. Diagnóstico Inicial</option>
                            <option>2. Diseño Estratégico</option>
                            <option>3. En Negociación</option>
                            <option>4. En Ejecución</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:0.75rem; font-weight:800; color:#ffffff; margin-bottom:6px;">Líder Asignado</label>
                        <select class="crm-select" style="width:100%;">
                            <option>Andrés M.</option>
                            <option>Giuliano V.</option>
                            <option>Sofía R.</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="crm-modal-foot">
                <button type="button" @click="showNewModal = false" style="background:none; border:1px solid rgba(255,255,255,0.2); color:#ffffff; padding:8px 18px; border-radius:8px; font-weight:700; font-size:0.75rem; cursor:pointer;">
                    Cancelar
                </button>
                <button type="button" @click="showNewModal = false; showToast('¡Nuevo cliente registrado con éxito en la simulación!')" style="background:#3057be; border:none; color:#ffffff; padding:8px 20px; border-radius:8px; font-weight:800; font-size:0.75rem; cursor:pointer; box-shadow:0 4px 15px rgba(48,87,190,0.4);">
                    Crear en Prototipo
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Flotante -->
    <div x-show="toastMsg" x-cloak 
         style="position:fixed; bottom:24px; right:24px; z-index:999999; background:#10b981; color:#ffffff; padding:12px 20px; border-radius:12px; font-weight:800; font-size:0.8rem; box-shadow:0 10px 30px rgba(0,0,0,0.5); display:flex; align-items:center; gap:8px;">
        <span>✓</span>
        <span x-text="toastMsg"></span>
    </div>

</div>
</x-filament-panels::page>
