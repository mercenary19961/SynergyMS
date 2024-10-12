<!-- Display Validation Errors-->
@if($errors->any())
    <div x-data="{ show: true }" x-show="show" class="bg-red-100 border border-red-400 text-red-700 hover:text-orange-600 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Whoops!</strong>
        <span class="block sm:inline">There were some problems with your input.</span>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-700 focus:outline-none">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif