
<div>
    @if($header)
        <header class="mb-8 p-8 bg-gradient-to-r from-orange-50 to-yellow-50 dark:from-slate-800 dark:to-slate-900 rounded-4xl shadow-xl border border-orange-200 dark:border-slate-700">
            {{ $header }}
        </header>
    @endif
    
    {{ $slot }}
</div>

