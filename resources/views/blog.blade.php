<x-guest-layout>

    <div class="bg-gray-100 min-h-auto md:min-h-screen">

        <h1 class="pt-4 text-center text-5xl font-semibold text-gray-800 dark:text-white">Blog</h1>

        <hr class="mt-4">

        <div class="py-10">

            <x-blogpost :title="'OOP with PHP'" :category="'PHP'" />

            <x-blogpost :title="'Laravel tutorial'" :category="'Laravel'" />

            <x-blogpost :title="'Create an SPA with Vue'" :category="'VueJS'" />

        </div>

    </div>

</x-guest-layout>
