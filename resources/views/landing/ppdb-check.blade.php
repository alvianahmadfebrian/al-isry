<x-layouts.public title="Cek Status Pendaftaran PPDB" :settings="$settings">
    <section class="bg-school-secondary py-12 text-white">
        <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
            <h1 class="text-2xl font-extrabold sm:text-3xl">Cek Status Pendaftaran PPDB</h1>
            <p class="mt-2 text-sm text-slate-300">Masukkan Nomor Pendaftaran Anda (contoh: <span class="font-mono text-lime-300">PPDB-{{ date('Y') }}-0001</span>) untuk melihat hasil verifikasi.</p>

            <form method="GET" action="{{ route('ppdb.check') }}" class="mx-auto mt-6 flex max-w-lg flex-col gap-2 sm:flex-row">
                <input name="nomor" value="{{ request('nomor') }}" required placeholder="Masukkan Nomor Pendaftaran..." class="flex-1 rounded-xl border border-white/20 bg-white/10 px-4 py-3 text-sm text-white placeholder-slate-400 focus:outline-none">
                <button class="rounded-xl bg-school-accent px-6 py-3 text-sm font-bold text-slate-950">Cari Status</button>
            </form>
        </div>
    </section>

    <section class="py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            @if ($searched)
                @if ($registration)
                    <div class="rounded-2xl border border-lime-900/15 bg-white p-6 shadow-sm sm:p-8">
                        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 pb-4">
                            <div>
                                <div class="text-xs text-slate-400">Nomor Pendaftaran</div>
                                <div class="font-mono text-lg font-extrabold text-slate-900">{{ $registration->registration_number }}</div>
                            </div>
                            <span class="rounded-full px-3.5 py-1 text-xs font-bold {{ $registration->statusBadgeClass() }}">
                                {{ $registration->statusLabel() }}
                            </span>
                        </div>

                        <div class="mt-4 grid gap-4 text-sm sm:grid-cols-2">
                            <div>
                                <div class="text-xs text-slate-400">Nama Calon Peserta Didik</div>
                                <div class="font-bold text-slate-900">{{ $registration->child_name }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-slate-400">Kelompok Pilihan</div>
                                <div class="font-semibold text-school-primary">{{ $registration->group_choice }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-slate-400">Orang Tua</div>
                                <div class="text-slate-700">{{ $registration->father_name }} / {{ $registration->mother_name }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-slate-400">Tanggal Mendaftar</div>
                                <div class="text-slate-700">{{ $registration->created_at?->translatedFormat('d F Y') }}</div>
                            </div>
                        </div>

                        @if ($registration->admin_notes)
                            <div class="mt-4 rounded-xl bg-lime-50 p-4 text-sm text-slate-800">
                                <span class="block text-xs font-bold text-school-primary">Catatan Panitia PPDB:</span>
                                {{ $registration->admin_notes }}
                            </div>
                        @endif

                        <div class="mt-6 text-right">
                            <a href="{{ route('ppdb.show', $registration->registration_number) }}" class="inline-flex items-center gap-1 rounded-xl bg-school-primary px-4 py-2 text-xs font-bold text-white">
                                Buka &amp; Cetak Bukti Pendaftaran &rarr;
                            </a>
                        </div>
                    </div>
                @else
                    <div class="rounded-2xl border border-red-200 bg-red-50 p-6 text-center text-sm text-red-800">
                        Nomor pendaftaran <strong>{{ request('nomor') }}</strong> tidak ditemukan. Pastikan penulisan sudah benar atau <a href="{{ route('ppdb.create') }}" class="font-bold underline">daftar baru di sini</a>.
                    </div>
                @endif
            @else
                <div class="rounded-2xl border border-slate-200 bg-white p-8 text-center">
                    <p class="text-sm text-slate-600">Belum melakukan pendaftaran peserta didik baru?</p>
                    <a href="{{ route('ppdb.create') }}" class="mt-3 inline-block rounded-xl bg-school-primary px-5 py-2.5 text-xs font-bold text-white">
                        Isi Formulir Pendaftaran Online
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>
