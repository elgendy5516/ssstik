<x-theme::layout>
    <x-slot:title>
        @lang('Popular videos')
    </x-slot:title>
    <x-theme::splash/>
    <x-theme::section.popular-videos :videos="$videos" />
</x-theme::layout>
