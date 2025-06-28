<!-- resources/views/jadwal/edit.blade.php -->
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Edit Tugas') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <form method="POST" action="{{ route('jadwal.update', $tugas->id) }}">
            @csrf
            @method('PUT')
            <!-- Method untuk update -->

            <div>
              <label for="nama_tugas" class="block font-medium text-sm text-gray-700">Nama Tugas</label>
              <input id="nama_tugas" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" type="text"
                name="nama_tugas" value="{{ old('nama_tugas', $tugas->nama_tugas) }}" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
              <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                Batal
              </a>
              <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Simpan Perubahan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>