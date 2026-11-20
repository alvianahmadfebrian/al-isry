<x-layouts.public :title="'Bukti Pendaftaran '.$registration->registration_number" :settings="$settings">
    <section class="py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-lime-300 bg-lime-100 p-4 text-sm font-semibold text-lime-900">
                    {{ session('status') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-3xl border border-lime-900/15 bg-white shadow-lg">
                <!-- Header Kartu -->
                <div class="flex flex-wrap items-center justify-between gap-4 bg-school-secondary p-6 text-white sm:p-8">
                    <div class="flex items-center gap-3.5">
                        <img src="{{ $settings['logo_url'] ?? '/images/logo-sekolah.png' }}" alt="Logo" class="h-14 w-14 rounded-full bg-white object-contain p-1">
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-wider text-lime-300">Bukti Pendaftaran Peserta Didik Baru</div>
                            <h1 class="text-lg font-extrabold sm:text-xl">{{ $settings['school_name'] }}</h1>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-slate-300">Nomor Pendaftaran</div>
                        <div class="font-mono text-lg font-extrabold text-lime-300">{{ $registration->registration_number }}</div>
                    </div>
                </div>

                <!-- Isi Kartu -->
                <div class="space-y-6 p-6 sm:p-8">
                    <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl bg-[#f8faf5] p-4">
                        <div>
                            <div class="text-xs text-slate-500">Status Pendaftaran Saat Ini</div>
                            <span class="mt-1 inline-block rounded-full px-3 py-1 text-xs font-bold {{ $registration->statusBadgeClass() }}">
                                {{ $registration->statusLabel() }}
                            </span>
                        </div>
                        <div class="text-xs text-slate-500">
                            Tanggal Daftar: <strong>{{ $registration->created_at?->translatedFormat('d F Y, H:i') }} WIB</strong>
                        </div>
                    </div>

                    @if ($registration->admin_notes)
                        <div class="rounded-2xl border border-lime-300 bg-lime-50 p-4 text-sm text-slate-800">
                            <div class="text-xs font-bold uppercase text-school-primary">Catatan Panitia PPDB:</div>
                            <p class="mt-1">{{ $registration->admin_notes }}</p>
                        </div>
                    @endif

                    <div class="grid gap-4 text-sm sm:grid-cols-2">
                        <div>
                            <div class="text-xs text-slate-400">Nama Lengkap Anak</div>
                            <div class="font-bold text-slate-900">{{ $registration->child_name }} {{ $registration->nickname ? '('.$registration->nickname.')' : '' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400">Kelompok Pilihan</div>
                            <div class="font-bold text-school-primary">{{ $registration->group_choice }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400">Jenis Kelamin</div>
                            <div class="font-medium text-slate-800">{{ $registration->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400">Tempat, Tanggal Lahir</div>
                            <div class="font-medium text-slate-800">{{ $registration->birth_place }}, {{ $registration->birth_date?->translatedFormat('d F Y') }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400">Nama Ayah &amp; Ibu</div>
                            <div class="font-medium text-slate-800">{{ $registration->father_name }} &amp; {{ $registration->mother_name }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400">Nomor WhatsApp Orang Tua</div>
                            <div class="font-medium text-slate-800">{{ $registration->parent_phone }}</div>
                        </div>
                        <div class="sm:col-span-2">
                            <div class="text-xs text-slate-400">Alamat Rumah</div>
                            <div class="font-medium text-slate-800">{{ $registration->address }}</div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 pt-6">
                        <a href="{{ route('home') }}" class="text-xs font-semibold text-slate-500 hover:text-school-primary">&larr; Kembali ke Beranda</a>
                        <div class="flex gap-2">
                            <button onclick="window.print()" type="button" class="rounded-xl border border-slate-300 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50">
                                Cetak Bukti Pendaftaran
                            </button>
                            <a href="{{ route('ppdb.check', ['nomor' => $registration->registration_number]) }}" class="rounded-xl bg-school-primary px-4 py-2 text-xs font-bold text-white">
                                Cek Status Terbaru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
