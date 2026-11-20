<x-layouts.app :title="$title">
    <p>Selamat datang, {{ auth()->user()->name }} ({{ auth()->user()->role->label() }}).</p>
</x-layouts.app>
