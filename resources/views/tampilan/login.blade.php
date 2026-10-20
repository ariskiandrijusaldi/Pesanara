<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login — HQ Coffee & Bites</title>

        <script>document.documentElement.classList.add('js');</script>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="grid min-h-screen place-items-center bg-[#FAFAFC] px-5 py-10 font-sans text-slate-600 antialiased">

        <main class="reveal w-full max-w-md rounded-3xl border border-[#ECE9F6] bg-white p-6 shadow-[0_16px_40px_rgba(49,24,107,0.08)] sm:p-8">

            {{-- Badge brand --}}
            <div class="flex justify-center">
                <span class="inline-flex items-center gap-2 rounded-full border border-[#E4DFF3] bg-[#F3F0FD] px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-[#6D28D9]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 8h12v5a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4V8Z" />
                        <path d="M16 9h1.5a2.5 2.5 0 0 1 0 5H16" />
                    </svg>
                    HQ Coffee &amp; Bites
                </span>
            </div>

            {{-- Judul --}}
            <h1 id="login-title" class="mt-5 text-center text-4xl font-bold tracking-tight text-[#1B1338]">Login Owner</h1>
            <p class="mt-2 text-center text-sm text-slate-500">
                Belum terdaftar sebagai <span id="login-role-text">owner</span>?
                <a href="#" class="font-semibold text-[#7C3AED] hover:text-[#6D28D9]">Hubungi Admin</a>
            </p>

            {{-- Tab Kasir / Owner --}}
            <div class="mt-6 grid grid-cols-2 gap-1 rounded-2xl bg-[#F3F0FD] p-1" role="tablist" aria-label="Pilih peran">
                <button type="button" role="tab" data-role="kasir" aria-selected="false"
                    class="role-tab rounded-xl py-2.5 text-xs font-semibold text-slate-600 transition">Kasir</button>
                <button type="button" role="tab" data-role="owner" aria-selected="true"
                    class="role-tab rounded-xl py-2.5 text-xs font-semibold text-[#6D28D9] shadow-sm transition bg-white">Owner</button>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label for="role" class="text-sm font-semibold text-[#1B1338]">Masuk Sebagai</label>
                    <select id="role" name="role"
                        class="mt-2 w-full rounded-xl border border-[#E4DFF3] bg-white px-4 py-3 text-sm text-[#1B1338] focus:border-[#7C3AED] focus:outline-none focus:ring-2 focus:ring-[#7C3AED]/30">
                        <option value="owner" selected>Owner</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </div>

                <div>
                    <label for="email" class="text-sm font-semibold text-[#1B1338]">E-Mail</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        placeholder="owner@hqcoffee.com"
                        class="mt-2 w-full rounded-xl border border-[#E4DFF3] bg-white px-4 py-3 text-sm text-[#1B1338] placeholder:text-slate-400 focus:border-[#7C3AED] focus:outline-none focus:ring-2 focus:ring-[#7C3AED]/30">
                    @error('email')
                        <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="text-sm font-semibold text-[#1B1338]">Password</label>
                    <div class="relative mt-2">
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            placeholder="Password"
                            class="w-full rounded-xl border border-[#E4DFF3] bg-white py-3 pl-4 pr-12 text-sm text-[#1B1338] placeholder:text-slate-400 focus:border-[#7C3AED] focus:outline-none focus:ring-2 focus:ring-[#7C3AED]/30">
                        <button id="toggle-password" type="button" aria-label="Tampilkan password"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 transition hover:text-[#6D28D9]">
                            <svg id="eye-open" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg id="eye-closed" class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M3 3l18 18M10.6 5.1A9.7 9.7 0 0 1 12 5c6.5 0 10 7 10 7a17 17 0 0 1-3.2 4.1M6.6 6.6A16.6 16.6 0 0 0 2 12s3.5 7 10 7a9.7 9.7 0 0 0 4.2-.9M9.9 9.9a3 3 0 0 0 4.2 4.2" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Verifikasi Cloudflare Turnstile --}}
                {{--
                    Ganti kotak statis di bawah dengan widget asli:
                    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.key') }}"></div>
                --}}
                <div class="flex items-center justify-between rounded-xl border border-[#E4DFF3] bg-[#FAFAFC] px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span class="grid h-7 w-7 place-items-center rounded-full bg-green-500 text-white">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 5 5 9-10" /></svg>
                        </span>
                        <span class="text-sm font-semibold text-[#1B1338]">Berhasil!</span>
                    </div>
                    <div class="text-right leading-tight">
                        <p class="text-[11px] font-extrabold tracking-wide text-slate-700">
                            <span class="text-orange-500">☁</span> CLOUDFLARE
                        </p>
                        <p class="text-[9px] text-slate-500">Privasi • Bantuan</p>
                    </div>
                </div>

                <button id="submit-btn" type="submit"
                    class="w-full rounded-xl bg-[#7C3AED] px-5 py-3.5 text-sm font-semibold text-white shadow-md shadow-[#7C3AED]/30 transition hover:bg-[#6D28D9] focus:outline-none focus:ring-2 focus:ring-[#7C3AED]/40">
                    Masuk ke Dashboard Owner
                </button>
            </form>

            @if (Route::has('password.request'))
                <p class="mt-5 text-center">
                    <a href="{{ route('password.request') }}" class="text-sm font-semibold text-[#7C3AED] hover:text-[#6D28D9]">Lupa Password?</a>
                </p>
            @endif
        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tabs = document.querySelectorAll('.role-tab');
                const select = document.getElementById('role');
                const title = document.getElementById('login-title');
                const roleText = document.getElementById('login-role-text');
                const email = document.getElementById('email');
                const submit = document.getElementById('submit-btn');

                const labels = {
                    owner: { name: 'Owner', text: 'owner', placeholder: 'owner@hqcoffee.com', btn: 'Masuk ke Dashboard Owner' },
                    kasir: { name: 'Kasir', text: 'kasir', placeholder: 'kasir@hqcoffee.com', btn: 'Masuk ke Terminal Kasir' },
                };

                function setRole(role) {
                    const l = labels[role];
                    select.value = role;
                    title.textContent = 'Login ' + l.name;
                    roleText.textContent = l.text;
                    email.placeholder = l.placeholder;
                    submit.textContent = l.btn;

                    tabs.forEach((t) => {
                        const on = t.dataset.role === role;
                        t.setAttribute('aria-selected', on ? 'true' : 'false');
                        t.classList.toggle('bg-white', on);
                        t.classList.toggle('shadow-sm', on);
                        t.classList.toggle('text-[#6D28D9]', on);
                        t.classList.toggle('text-slate-600', !on);
                    });
                }

                tabs.forEach((t) => t.addEventListener('click', () => setRole(t.dataset.role)));
                select.addEventListener('change', () => setRole(select.value));

                // Tampilkan / sembunyikan password
                const pwd = document.getElementById('password');
                document.getElementById('toggle-password').addEventListener('click', function () {
                    const show = pwd.type === 'password';
                    pwd.type = show ? 'text' : 'password';
                    document.getElementById('eye-open').classList.toggle('hidden', show);
                    document.getElementById('eye-closed').classList.toggle('hidden', !show);
                    this.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
                });

                setRole(select.value);
            });
        </script>
    </body>
</html>