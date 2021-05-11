<x-guest-layout>

    <x-alert />

    <div class="min-h-auto md:min-h-screen bg-gray-100 flex flex-col items-center justify-center relative">

        <div class="container mx-auto">

            <section class="flex flex-col max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 md:flex-row md:h-48">
                <div class="md:flex md:items-center md:justify-center md:w-1/2 md:bg-gray-700 md:dark:bg-gray-800">
                    <div class="px-6 py-6 md:px-8 md:py-0">
                        <h2 class="text-lg font-bold text-gray-700 dark:text-white md:text-gray-100">Subscribete para recibir actualizaciones del <span class="text-blue-600 dark:text-blue-400 md:text-blue-300">Proyecto</span></h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 md:text-gray-400">Recibe tips, noticias y snippets de Laravel.</p>
                    </div>
                </div>

                <div class="flex items-center justify-center pb-6 md:py-0 md:w-1/2 px-10">
                    <form method="POST" action="{{ route('newsletter.store') }}">
                        @method('POST') @csrf
                        <div class="flex flex-col overflow-hidden border rounded-lg dark:border-gray-600 lg:flex-row">
                            <input class="px-6 py-3 text-gray-700 placeholder-gray-500 bg-white outline-none dark:bg-gray-800 dark:placeholder-gray-400 focus:placeholder-transparent dark:focus:placeholder-transparent border-4 border-gray-700 focus:border-gray-700" type="text" name="email" placeholder="Ingresa tu email" aria-label="Ingresa tu email">
                            <input type="hidden" name="hp_newsletter">
                            <button class="px-4 py-3 text-sm font-medium tracking-wider text-gray-100 uppercase transition-colors duration-200 transform bg-gray-700 hover:bg-gray-600 focus:bg-gray-600 focus:outline-none">subscribete</button>
                        </div>
                    </form>
                </div>
            </section>

        </div>

    </div>

</x-guest-layout>
