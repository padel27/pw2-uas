{{-- resources/views/kategori/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Kategori Tugas') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

      <!-- Form untuk Tambah Kategori Baru -->
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <h3 class="text-lg font-medium mb-4">Tambah Kategori Baru</h3>

          @if (session('success'))
          <div
            class="bg-green-100 dark:bg-green-900/50 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 mb-6 rounded-md"
            role="alert">
            <p>{{ session('success') }}</p>
          </div>
          @endif

          <form method="POST" action="{{ route('kategori.store') }}">
            @csrf
            <div class="flex flex-col sm:flex-row sm:items-end sm:space-x-4 space-y-4 sm:space-y-0">
              <div class="flex-grow">
                <label for="nama_kategori" class="sr-only">Nama Kategori</label>
                <input id="nama_kategori"
                  class="block w-full rounded-md shadow-sm border-gray-300 text-gray-900 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                  type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" required
                  placeholder="Contoh: Pekerjaan Kantor">
                @error('nama_kategori')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
              </div>
              <button type="submit"
                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                Simpan
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Tabel Daftar Kategori -->
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <h3 class="text-lg font-medium mb-4">Daftar Kategori</h3>
          <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Nama Kategori</th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Jumlah Tugas</th>
                  <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($kategoris as $kategori)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                    {{ $kategori->nama_kategori }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    {{ $kategori->tugas->count() }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end space-x-4">
                      <a href="{{ route('kategori.edit', $kategori->id) }}"
                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                      <form method="POST" action="{{ route('kategori.destroy', $kategori->id) }}"
                        onsubmit="return confirm('Menghapus kategori akan membuat semua tugas terkait menjadi tidak berkategori. Anda yakin?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                          class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="3" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                    Belum ada kategori yang dibuat.
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>