    <x-app-layout>
      <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Edit Tugas') }}
        </h2>
      </x-slot>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
              <form method="POST" action="{{ route('tugas.update', $tugas->id) }}">
                @csrf
                @method('PUT')

                {{-- Nama Tugas --}}
                <div>
                  <label for="nama_tugas" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nama
                    Tugas</label>
                  <input id="nama_tugas"
                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 text-gray-900 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    type="text" name="nama_tugas" value="{{ old('nama_tugas', $tugas->nama_tugas) }}" required
                    autofocus />
                  @error('nama_tugas')
                  <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                  @enderror
                </div>

                {{-- Kategori --}}
                <div class="mt-4">
                  <label for="kategori_id"
                    class="block font-medium text-sm text-gray-700 dark:text-gray-300">Kategori</label>
                  <select id="kategori_id" name="kategori_id"
                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" @selected(old('kategori_id', $tugas->kategori_id) ==
                      $kategori->id)>
                      {{ $kategori->nama_kategori }}
                    </option>
                    @endforeach
                  </select>
                  @error('kategori_id')
                  <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                  @enderror
                </div>

                <div class="flex items-center justify-end mt-6">
                  <a href="{{ route('dashboard') }}"
                    class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 mr-4">
                    Batal
                  </a>
                  <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                    Simpan Perubahan
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </x-app-layout>