<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold">
        {{ $slot }}
    </h1>
    <x-back-button :route="$route" />
</div>