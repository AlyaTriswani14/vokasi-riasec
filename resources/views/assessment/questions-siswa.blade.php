<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tes Minat RIASEC - Bakat Minat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex flex-col">

    @php
        $isSmk = (Auth::user()->jenjang ?? 'smp') === 'smk';
        $gradFrom = $isSmk ? '#2F6FED' : '#FF7A45';
        $gradTo = $isSmk ? '#22C1C3' : '#FFB13D';
        $accentText = $isSmk ? 'text-[#2F6FED]' : 'text-[#c2410c]';
        $accentBg = $isSmk ? 'bg-blue-50' : 'bg-orange-50';
        $accentBorder = $isSmk ? 'border-blue-100' : 'border-orange-100';

        $totalSoal = $soalList->count();
        $widthAwal = $totalSoal > 0 ? round(1 / $totalSoal * 100, 2) : 0;

        // Durasi tes (menit) dari pengaturan admin; default 5 kalau tidak dikirim
        $durasiMenit = $durasiMenit ?? 5;
        $timerAwal = str_pad($durasiMenit, 2, '0', STR_PAD_LEFT) . ':00';
    @endphp

    <div class="w-full flex justify-between items-center p-4 md:px-8 bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2 text-[#003366] font-bold text-lg">
            <i class="fa-solid fa-graduation-cap"></i> <span>Bakat Minat</span>
        </div>
        <div class="w-8 h-8 rounded-full bg-[#00558f] text-white flex items-center justify-center font-bold text-xs">
            {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 2)) : 'PP' }}
        </div>
    </div>

    <main class="max-w-xl mx-auto px-4 w-full flex-grow flex flex-col">

        <div class="flex-grow flex flex-col justify-center w-full py-8">

            {{-- ===== Info sebelum mulai ===== --}}
            <div id="intro-step">
                <div class="bg-white p-8 rounded-3xl shadow-lg border {{ $accentBorder }} text-center relative overflow-hidden">
                    <div class="absolute w-28 h-28 rounded-full -top-10 -right-10 opacity-10" style="background: linear-gradient(135deg, {{ $gradFrom }}, {{ $gradTo }});"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 mx-auto rounded-full flex items-center justify-center text-2xl text-white mb-4" style="background: linear-gradient(135deg, {{ $gradFrom }}, {{ $gradTo }});">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <h2 class="text-xl font-extrabold text-gray-800 mb-2">Sebelum Mulai Tes</h2>
                        <p class="text-sm text-gray-500 mb-6">Baca dulu ketentuannya ya, biar hasil tesmu akurat.</p>

                        <div class="flex flex-col gap-3 text-left mb-8">
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 shrink-0 rounded-lg {{ $accentBg }} {{ $accentText }} flex items-center justify-center text-xs mt-0.5"><i class="fa-solid fa-list-ol"></i></div>
                                <p class="text-xs text-gray-600">Ada <span class="font-bold text-gray-800">{{ $totalSoal }} pertanyaan</span>, jawab <span class="font-bold text-gray-800">YA</span> atau <span class="font-bold text-gray-800">TIDAK</span> satu per satu.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 shrink-0 rounded-lg {{ $accentBg }} {{ $accentText }} flex items-center justify-center text-xs mt-0.5"><i class="fa-solid fa-face-smile"></i></div>
                                <p class="text-xs text-gray-600">Tidak ada jawaban benar atau salah — jawab sesuai apa yang kamu rasakan.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 shrink-0 rounded-lg {{ $accentBg }} {{ $accentText }} flex items-center justify-center text-xs mt-0.5"><i class="fa-solid fa-stopwatch"></i></div>
                                <p class="text-xs text-gray-600">Waktu pengerjaan <span class="font-bold text-gray-800">{{ $durasiMenit }} menit</span>. Kalau waktu habis, jawaban yang sudah kamu isi otomatis terkirim.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 shrink-0 rounded-lg {{ $accentBg }} {{ $accentText }} flex items-center justify-center text-xs mt-0.5"><i class="fa-solid fa-triangle-exclamation"></i></div>
                                <p class="text-xs text-gray-600">Jangan tutup atau refresh halaman sampai tesnya selesai.</p>
                            </div>
                        </div>

                        <button type="button" onclick="startTest()"
                            class="w-full text-white font-bold text-sm py-4 rounded-2xl transition-transform active:scale-95 shadow-md"
                            style="background: linear-gradient(135deg, {{ $gradFrom }}, {{ $gradTo }});">
                            Mulai Tes Sekarang
                        </button>
                    </div>
                </div>
            </div>

            {{-- ===== Progress + timer (muncul setelah "Mulai") ===== --}}
            <div id="test-header" class="hidden mb-6 w-full">
                <div class="flex justify-center mb-4">
                    <div id="timer-badge" class="{{ $accentText }} font-extrabold text-2xl flex items-center gap-2 px-5 py-2 rounded-full {{ $accentBg }}">
                        <i class="fa-regular fa-clock"></i>
                        <span id="timer-text">{{ $timerAwal }}</span>
                    </div>
                </div>
                <div class="flex justify-between text-xs font-bold {{ $accentText }} mb-2">
                    <span>Progress Tes</span>
                    <span id="progress-text">Soal 1 dari {{ $totalSoal }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                    <div id="progress-bar" class="h-2.5 rounded-full transition-all duration-300" style="width: {{ $widthAwal }}%; background: linear-gradient(90deg, {{ $gradFrom }}, {{ $gradTo }});"></div>
                </div>
            </div>

            <form id="assessment-form" action="{{ route('assessment.submit') }}" method="POST">
                @csrf
                <div id="question-container" class="relative hidden">

                @foreach ($soalList as $i => $soal)
                    @php $pos = $i + 1; @endphp
                    <div class="question-step {{ $pos > 1 ? 'hidden' : '' }}" data-id="{{ $pos }}">
                        <div class="bg-white p-8 rounded-3xl shadow-lg border {{ $accentBorder }} text-center relative overflow-hidden">
                            <div class="absolute w-24 h-24 rounded-full -top-8 -right-8 opacity-10" style="background: linear-gradient(135deg, {{ $gradFrom }}, {{ $gradTo }});"></div>

                            <div class="relative z-10">
                                <span class="inline-block {{ $accentText }} text-[11px] font-extrabold uppercase tracking-widest px-3 py-1 rounded-full" style="background: linear-gradient(135deg, {{ $gradFrom }}22, {{ $gradTo }}22);">
                                    Pertanyaan {{ $pos }}
                                </span>
                                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 mt-5 mb-10 leading-snug">{{ $soal->pernyataan }}</h2>

                                <div class="grid grid-cols-2 gap-4">
                                    <button type="button" onclick="nextQuestion({{ $pos }}, true)"
                                        class="text-white py-4 rounded-2xl font-bold text-lg transition-transform active:scale-95 shadow-md"
                                        style="background: linear-gradient(135deg, {{ $gradFrom }}, {{ $gradTo }});">
                                        YA
                                    </button>
                                    <button type="button" onclick="nextQuestion({{ $pos }}, false)"
                                        class="bg-white text-gray-400 border-2 border-gray-200 py-4 rounded-2xl font-bold text-lg hover:bg-gray-50 transition-transform active:scale-95">
                                        TIDAK
                                    </button>
                                </div>
                            </div>
                        </div>
                        <input type="checkbox" name="jawaban[]" value="{{ $soal->id }}" id="check-{{ $pos }}" class="hidden">
                    </div>
                @endforeach
            </div>
        </form>
        </div>
    </main>

    <script>
        const totalSoal = {{ $totalSoal }};
        let timeLeft = {{ $durasiMenit * 60 }}; // durasi dari pengaturan admin
        let timerInterval = null;

        function startTest() {
            document.getElementById('intro-step').classList.add('hidden');
            document.getElementById('test-header').classList.remove('hidden');
            document.getElementById('question-container').classList.remove('hidden');
            timerInterval = setInterval(tickTimer, 1000);
        }

        function tickTimer() {
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                document.getElementById('assessment-form').submit();
                return;
            }
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            document.getElementById('timer-text').innerText =
                String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

            if (timeLeft <= 30) {
                const badge = document.getElementById('timer-badge');
                badge.classList.add('bg-red-50', 'text-red-500');
            }
        }

        function nextQuestion(currentId, isYes) {
            if (isYes) document.getElementById('check-' + currentId).checked = true;

            const currentStep = document.querySelector('.question-step[data-id="' + currentId + '"]');
            const nextStep = document.querySelector('.question-step[data-id="' + (currentId + 1) + '"]');

            if (nextStep) {
                currentStep.classList.add('hidden');
                nextStep.classList.remove('hidden');
                document.getElementById('progress-bar').style.width = ((currentId + 1) / totalSoal * 100) + '%';
                document.getElementById('progress-text').innerText = 'Soal ' + (currentId + 1) + ' dari ' + totalSoal;
            } else {
                clearInterval(timerInterval);
                document.getElementById('assessment-form').submit();
            }
        }
    </script>
</body>
</html>