<x-filament::section>
    <x-slot name="heading">
        <div class="flex items-center gap-2">
            <x-heroicon-m-briefcase class="w-5 h-5 text-primary-500" />
            <span class="font-bold text-base">Proyectos Estratégicos & Misiones en Curso</span>
        </div>
    </x-slot>

    <x-slot name="headerEnd">
        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-primary-500/10 text-primary-600 dark:text-primary-400 border border-primary-500/20">
            Vista Previa · Módulo Clientes / Proyectos
        </span>
    </x-slot>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-gray-200 dark:border-white/10 text-xs uppercase text-gray-500 dark:text-gray-400">
                <tr>
                    <th class="py-3 px-4 font-semibold">Proyecto / Iniciativa</th>
                    <th class="py-3 px-4 font-semibold">Organización / Cliente</th>
                    <th class="py-3 px-4 font-semibold">Mercado / Destino</th>
                    <th class="py-3 px-4 font-semibold">Estado</th>
                    <th class="py-3 px-4 font-semibold text-right">Progreso</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/5 transition">
                    <td class="py-3.5 px-4 font-semibold text-gray-900 dark:text-white">
                        Misión Comercial y Vinculación Estratégica
                    </td>
                    <td class="py-3.5 px-4 text-gray-600 dark:text-gray-300">
                        Consorcio Agroindustrial NOA
                    </td>
                    <td class="py-3.5 px-4 text-gray-600 dark:text-gray-300">
                        🇪🇺 Unión Europea (Madrid / Milán)
                    </td>
                    <td class="py-3.5 px-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                            ● En Ejecución
                        </span>
                    </td>
                    <td class="py-3.5 px-4 text-right font-bold text-gray-800 dark:text-gray-200">
                        75%
                    </td>
                </tr>
                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/5 transition">
                    <td class="py-3.5 px-4 font-semibold text-gray-900 dark:text-white">
                        Estructuración de Financiamiento Multilateral
                    </td>
                    <td class="py-3.5 px-4 text-gray-600 dark:text-gray-300">
                        Municipio / Gobierno Local
                    </td>
                    <td class="py-3.5 px-4 text-gray-600 dark:text-gray-300">
                        🌐 Organismos de Crédito (BID / CAF)
                    </td>
                    <td class="py-3.5 px-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20">
                            ● En Evaluación
                        </span>
                    </td>
                    <td class="py-3.5 px-4 text-right font-bold text-gray-800 dark:text-gray-200">
                        45%
                    </td>
                </tr>
                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/5 transition">
                    <td class="py-3.5 px-4 font-semibold text-gray-900 dark:text-white">
                        Soft Landing & Apertura de Operaciones
                    </td>
                    <td class="py-3.5 px-4 text-gray-600 dark:text-gray-300">
                        Fintech Solutions Latam
                    </td>
                    <td class="py-3.5 px-4 text-gray-600 dark:text-gray-300">
                        🇧🇷 São Paulo, Brasil
                    </td>
                    <td class="py-3.5 px-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20">
                            ● Fase Inicial
                        </span>
                    </td>
                    <td class="py-3.5 px-4 text-right font-bold text-gray-800 dark:text-gray-200">
                        20%
                    </td>
                </tr>
                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/5 transition">
                    <td class="py-3.5 px-4 font-semibold text-gray-900 dark:text-white">
                        Agenda de Cooperación Internacional Descentralizada
                    </td>
                    <td class="py-3.5 px-4 text-gray-600 dark:text-gray-300">
                        Agencia de Desarrollo Territorial
                    </td>
                    <td class="py-3.5 px-4 text-gray-600 dark:text-gray-300">
                        🇫🇷 Francia / UE
                    </td>
                    <td class="py-3.5 px-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-500/10 text-purple-600 dark:text-purple-400 border border-purple-500/20">
                            ● Completado
                        </span>
                    </td>
                    <td class="py-3.5 px-4 text-right font-bold text-gray-800 dark:text-gray-200">
                        100%
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</x-filament::section>
