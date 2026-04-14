<div class="space-y-3">
    @forelse ($versions as $version)
        <div class="flex items-center justify-between p-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <div>
                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                    {{ $version->created_at->format('d/m/Y H:i') }}
                    <span class="text-gray-400 dark:text-gray-500 font-normal">
                        ({{ $version->created_at->diffForHumans() }})
                    </span>
                </div>
                @if ($version->label)
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        {{ $version->label }}
                    </div>
                @endif
                <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                    {{ !empty($version->content['sections']) ? count($version->content['sections']) . ' secciones' : 'Contenido guardado' }}
                </div>
            </div>
            <form method="POST" action="{{ route('builder.sections.restore', ['page' => $page->id, 'version' => $version->id]) }}"
                  onsubmit="return confirm('Restaurar esta version? Se guardara la version actual antes de restaurar.')">
                @csrf
                <button type="submit"
                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-primary-600 bg-primary-50 hover:bg-primary-100 rounded-lg transition dark:text-primary-400 dark:bg-primary-900/20 dark:hover:bg-primary-900/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                    Restaurar
                </button>
            </form>
        </div>
    @empty
        <div class="text-center text-sm text-gray-500 py-4">
            No hay versiones guardadas aun.
        </div>
    @endforelse

    <div class="text-xs text-gray-400 dark:text-gray-500 text-center pt-2">
        Se conservan las ultimas 6 versiones.
    </div>
</div>
