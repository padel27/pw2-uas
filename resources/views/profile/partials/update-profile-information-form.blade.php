{{-- resources/views/profile/partials/update-profile-information-form.blade.php --}}
<section>
  <header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
      {{ __('Informasi Profil') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
      {{ __("Perbarui informasi profil akun dan alamat email Anda.") }}
    </p>
  </header>

  <form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
  </form>

  <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('patch')

    {{-- Input untuk Nama --}}
    <div>
      <x-input-label for="name" :value="__('Nama')" />
      <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
        required autofocus autocomplete="name" />
      <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    {{-- Input untuk Email --}}
    <div>
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
        required autocomplete="username" />
      <x-input-error class="mt-2" :messages="$errors->get('email')" />

      @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
      <div>
        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
          {{ __('Alamat email Anda belum terverifikasi.') }}

          <button form="send-verification"
            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
          </button>
        </p>

        @if (session('status') === 'verification-link-sent')
        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
          {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
        </p>
        @endif
      </div>
      @endif
    </div>

    {{-- =================================================== --}}
    {{--          KODE BARU DITAMBAHKAN DI SINI           --}}
    {{-- =================================================== --}}

    <!-- Input untuk No. HP -->
    <div>
      <x-input-label for="no_hp" :value="__('No. HP')" />
      <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full" :value="old('no_hp', $user->no_hp)"
        autofocus autocomplete="tel" />
      <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
    </div>

    <!-- Input untuk Status -->
    <div>
      <x-input-label for="status" :value="__('Status')" />
      <select id="status" name="status"
        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
        <option value="">-- Pilih Status --</option>
        <option value="Pelajar" @selected(old('status', $user->status) == 'Pelajar')>Pelajar</option>
        <option value="Mahasiswa" @selected(old('status', $user->status) == 'Mahasiswa')>Mahasiswa</option>
        <option value="Pekerja" @selected(old('status', $user->status) == 'Pekerja')>Pekerja</option>
        <option value="Lainnya" @selected(old('status', $user->status) == 'Lainnya')>Lainnya</option>
      </select>
      <x-input-error class="mt-2" :messages="$errors->get('status')" />
    </div>


    {{-- Tombol Simpan --}}
    <div class="flex items-center gap-4">
      <x-primary-button>{{ __('Simpan') }}</x-primary-button>

      @if (session('status') === 'profile-updated')
      <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
        class="text-sm text-gray-600 dark:text-gray-400">{{ __('Tersimpan.') }}</p>
      @endif
    </div>
  </form>
</section>