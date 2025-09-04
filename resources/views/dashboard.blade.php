    <x-app-layout>
      <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Daftar Tugas') }}
        </h2>
      </x-slot>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

          <!-- BAGIAN 1: KARTU STATISTIK -->
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-5">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Tugas</p>
                <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $semua_tugas->count() }}</p>
              </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-5">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Tugas Selesai</p>
                <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">
                  {{ $semua_tugas->where('selesai', true)->count() }}</p>
              </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-5">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Belum Selesai</p>
                <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">
                  {{ $semua_tugas->where('selesai', false)->count() }}</p>
              </div>
            </div>
          </div>

          <!-- BAGIAN 2: CONTAINER UTAMA (FORM & TABEL) -->
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

              @if (session('success'))
              <div
                class="bg-green-100 dark:bg-green-900/50 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 mb-6 rounded-md"
                role="alert">
                <p>{{ session('success') }}</p>
              </div>
              @endif

              <details class="mb-6 group">
                <summary
                  class="flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                  <h3 class="text-lg font-medium">Tambah Tugas Baru</h3>
                  <svg class="w-5 h-5 group-open:rotate-180 transition-transform" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                  </svg>
                </summary>
                <div class="mt-4 border-t dark:border-gray-700 pt-4">
                  <form method="POST" action="{{ route('tugas.store') }}">
                    @csrf
                    <div class="flex flex-col sm:flex-row sm:items-end sm:space-x-4 space-y-4 sm:space-y-0">
                      <div class="flex-grow">
                        <label for="nama_tugas" class="sr-only">Nama Tugas</label>
                        <input id="nama_tugas"
                          class="block w-full rounded-md shadow-sm border-gray-300 text-gray-900 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                          type="text" name="nama_tugas" value="{{ old('nama_tugas') }}" required
                          placeholder="Tulis nama tugas di sini...">
                        @error('nama_tugas')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                      </div>

                      <div class="flex-grow">
                        <label for="kategori_id" class="sr-only">Kategori</label>
                        <select name="kategori_id" id="kategori_id"
                          class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                          <option value="">-- Pilih Kategori --</option>
                          @foreach($semua_kategori as $kategori)
                          <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                          @endforeach
                        </select>
                      </div>

                      <div class="flex-grow">
  <label for="prioritas" class="sr-only">Prioritas</label>
  <select name="prioritas" id="prioritas"
    class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    <option value="Rendah">Prioritas Rendah</option>
    <option value="Sedang">Prioritas Sedang</option>
    <option value="Tinggi">Prioritas Tinggi</option>
  </select>
</div>

<div class="flex-grow">
  <label for="tenggat_waktu" class="sr-only">Deadline</label>
  <input type="date" name="tenggat_waktu" id="tenggat_waktu"
    class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
</div>


                      @if(auth()->user()->isAdmin())
                      <div class="flex-grow">
                        <label for="user_id" class="sr-only">Tugaskan ke</label>
                        <select name="user_id" id="user_id"
                          class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                          <option value="">Tugaskan ke...</option>
                          @foreach($semua_pengguna as $pengguna)
                          <option value="{{ $pengguna->id }}">{{ $pengguna->name }}</option>
                          @endforeach
                        </select>
                        @error('user_id')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                      </div>
                      @endif

                      <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                        Simpan
                      </button>
                    </div>
                  </form>
                </div>
              </details>

              <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                  <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                      <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Status</th>
                      <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Nama Tugas</th>
                      <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Kategori</th>
                      <th scope="col"
  class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
  Prioritas</th>
<th scope="col"
  class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
  Deadline</th>


                      @if(auth()->user()->isAdmin())
                      <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Pemilik</th>
                      @endif

                      <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Aksi</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($semua_tugas as $tugas)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                      <td class="px-6 py-4 whitespace-nowrap">
                        @if ($tugas->selesai)
                        <span
                          class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                        @else
                        <form method="POST" action="{{ route('tugas.updateStatus', $tugas->id) }}">
                          @csrf
                          @method('PATCH')
                          <button type="submit"
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition"
                            title="Tandai Selesai">Belum Selesai</button>
                        </form>
                        @endif
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ $tugas->nama_tugas }}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $tugas->kategori->nama_kategori ?? '-' }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm">
  @if($tugas->prioritas == 'Tinggi')
    <span class="px-2 py-1 text-xs font-semibold rounded bg-red-600 text-white">Tinggi</span>
  @elseif($tugas->prioritas == 'Sedang')
    <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-500 text-black">Sedang</span>
  @else
    <span class="px-2 py-1 text-xs font-semibold rounded bg-green-600 text-white">Rendah</span>
  @endif
</td>

<td class="px-6 py-4 whitespace-nowrap text-sm">
  @if($tugas->tenggat_waktu)
    {{ \Carbon\Carbon::parse($tugas->tenggat_waktu)->format('d M Y') }}

    @if(\Carbon\Carbon::parse($tugas->tenggat_waktu)->isPast())
      <span class="ml-2 px-2 py-1 bg-red-700 text-white text-xs rounded">Lewat</span>
    @elseif(\Carbon\Carbon::parse($tugas->tenggat_waktu)->diffInDays(now()) <= 2)
      <span class="ml-2 px-2 py-1 bg-yellow-600 text-black text-xs rounded">Mendekati</span>
    @endif
  @else
    -
  @endif
</td>


                      @if(auth()->user()->isAdmin())
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $tugas->user->name }}
                      </td>
                      @endif

                      <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-4">
                          <a href="{{ route('tugas.edit', $tugas->id) }}"
                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                          <form method="POST" action="{{ route('tugas.destroy', $tugas->id) }}"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');">
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
                      <td colspan="{{ auth()->user()->isAdmin() ? '7' : '6' }}"
                        class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                        🎉 Semua tugas selesai! Silakan tambah tugas baru.
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