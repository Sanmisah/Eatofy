<x-layout.default>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-4 gap-4">
                        <?php for($i=1;$i<=10;$i++) { ?>
                            <a href="/table">
                                <div class="bg-sky-500 px-8 py-8 rounded-md">Table <?php echo $i; ?></div>
                            </a>
                        <?php } ?>
                        <!-- ... -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.default>
