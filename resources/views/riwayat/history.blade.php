<!-- resources/views/tugas/history.blade.php -->
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Riwayat Tugas Selesai') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
            Daftar semua tugas yang telah diselesaikan.
          </h3>
          <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    No</th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Nama Tugas</th>

                  {{-- KOLOM BARU: Hanya tampil untuk Admin --}}
                  @if(auth()->user()->isAdmin())
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Pemilik</th>
                  @endif

                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Tanggal Selesai</th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($semua_tugas_selesai as $tugas)
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    {{ $loop->iteration }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                    {{ $tugas->nama_tugas }}</td>

                  {{-- DATA BARU: Hanya tampil untuk Admin --}}
                  @if(auth()->user()->isAdmin())
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    {{ $tugas->user->name }}
                  </td>
                  @endif

                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    {{ $tugas->updated_at->format('d F Y, H:i') }}</td>
                </tr>
                @empty
                <tr>
                  {{-- Ubah colspan secara dinamis --}}
                  <td colspan="{{ auth()->user()->isAdmin() ? '4' : '3' }}"
                    class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                    Belum ada tugas yang selesai.
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