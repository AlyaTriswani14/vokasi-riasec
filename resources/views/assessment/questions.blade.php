<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tes Minat RIASEC - Pertanyaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Sembunyikan checkbox bawaan browser untuk dikustomisasi */
        .custom-checkbox:checked + div {
            background-color: #0f766e;
            border-color: #0f766e;
        }
        .custom-checkbox:checked + div svg {
            display: block;
        }
    </style>
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex flex-col relative pb-8">

    <div class="sticky top-0 z-50 w-full flex justify-between items-center p-4 md:px-8 bg-white border-b border-gray-200 shadow-sm">
        <div class="flex items-center gap-2 text-[#003366] font-bold text-lg">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Pilih Jalanmu</span>
        </div>
        <div class="bg-[#e0f2fe] text-[#0369a1] px-3 py-1.5 rounded-full text-xs font-bold">
            Instrumen RIASEC
        </div>
    </div>

    <main class="flex-grow w-full max-w-3xl mx-auto px-4 pt-6 pb-12 flex flex-col">
        
        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-[#003366] mb-2">Pernyataan Minat</h1>
            <p class="text-gray-600 text-sm">Berikan tanda centang <i class="fa-regular fa-square-check text-[#0f766e]"></i> pada pernyataan yang <b>sesuai</b> dengan dirimu. Kosongkan jika tidak sesuai.</p>
        </div>

        <form action="{{ route('assessment.submit') }}" method="POST">
            @csrf
            
            <div class="space-y-3 mb-8">
                @php
                    // Daftar 42 Pertanyaan sesuai instrumen PDF
                    $pertanyaan = [
                        1 => 'Saya suka mengulik peralatan',
                        2 => 'Saya suka mengerjakan puzzle',
                        3 => 'Saya suka bekerja mandiri',
                        4 => 'Saya suka bekerja dalam kelompok',
                        5 => 'Saya suka membuat target untuk diri saya sendiri',
                        6 => 'Saya suka merapikan barang-barang (buku, alat tulis, kamar)',
                        7 => 'Saya suka menyusun balok/LEGO',
                        8 => 'Saya suka membaca buku tentang seni dan musik',
                        9 => 'Saya suka mengerjakan hal-hal dengan instruksi yang jelas',
                        10 => 'Saya suka meyakinkan teman untuk mengikuti cara saya',
                        11 => 'Saya suka melakukan percobaan/eksperimen',
                        12 => 'Saya suka menjelaskan sesuatu kepada teman',
                        13 => 'Saya suka membantu orang lain memecahkan persoalan',
                        14 => 'Saya suka memperbaiki alat-alat mekanik (sepeda, dll.)',
                        15 => 'Saya tidak keberatan kalau bekerja melebihi waktu yang ditentukan',
                        16 => 'Saya suka menjual sesuatu',
                        17 => 'Saya suka membuat karya berbentuk tulisan',
                        18 => 'Saya suka sains',
                        19 => 'Saya suka mendapatkan tantangan baru',
                        20 => 'Saya suka menghibur teman',
                        21 => 'Saya suka mencari tahu cara kerja sebuah alat',
                        22 => 'Saya suka merangkai atau merakit benda',
                        23 => 'Saya adalah orang yang kreatif',
                        24 => 'Saya suka memperhatikan detail',
                        25 => 'Saya suka merapikan catatan atau LKS',
                        26 => 'Saya suka mencari tahu penyebab suatu kejadian',
                        27 => 'Saya suka memainkan alat musik atau bernyanyi',
                        28 => 'Saya suka mempelajari budaya berbagai daerah',
                        29 => 'Saya ingin membuka usaha sendiri suatu saat nanti',
                        30 => 'Saya suka memasak',
                        31 => 'Saya suka bermain peran atau drama',
                        32 => 'Saya suka mempraktikkan hal-hal yang sudah dipelajari',
                        33 => 'Saya suka mengerjakan soal matematika atau grafik',
                        34 => 'Saya suka mendiskusikan hal-hal yang terjadi di sekitar saya',
                        35 => 'Saya suka merapikan kamar saya',
                        36 => 'Saya suka memimpin kelompok atau kelas',
                        37 => 'Saya suka berkegiatan di luar ruangan',
                        38 => 'Saya suka berkegiatan di dalam ruangan dengan meja-kursi',
                        39 => 'Saya suka menghitung',
                        40 => 'Saya suka menolong orang',
                        41 => 'Saya suka menggambar',
                        42 => 'Saya suka berbicara di depan umum',
                    ];
                @endphp

                @foreach ($pertanyaan as $id => $teks)
                    <label class="flex items-center justify-between bg-white p-4 rounded-xl border border-gray-200 shadow-sm cursor-pointer hover:border-[#0f766e] hover:bg-[#f0fdfa] transition-all group">
                        <div class="flex gap-4 items-start w-full">
                            <span class="text-gray-400 font-bold min-w-[24px]">{{ $id }}.</span>
                            <span class="text-gray-700 text-sm md:text-base select-none">{{ $teks }}</span>
                        </div>
                        
                        <div class="relative flex items-center ml-4">
                            <input type="checkbox" name="jawaban[]" value="{{ $id }}" class="custom-checkbox absolute opacity-0 w-0 h-0">
                            <div class="w-6 h-6 md:w-7 md:h-7 border-2 border-gray-300 rounded bg-white flex justify-center items-center group-hover:border-[#0f766e] transition-colors">
                                <svg class="hidden w-4 h-4 text-white pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="bg-white p-4 border border-gray-200 rounded-2xl shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4 sticky bottom-4 z-40">
                <p class="text-xs text-gray-500 font-medium">Pastikan semua pernyataan telah dibaca.</p>
                <button type="submit" class="w-full sm:w-auto bg-[#004080] hover:bg-[#003366] text-white font-bold py-3 px-8 rounded-xl flex items-center justify-center gap-2 transition-colors">
                    Selesai & Lihat Hasil
                    <i class="fa-solid fa-flag-checkered"></i>
                </button>
            </div>
        </form>

    </main>

</body>
</html>