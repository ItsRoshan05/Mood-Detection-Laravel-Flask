@extends('layouts.layouts')

@section('content')
<main id="main" class="main">
    <div class="container mt-5">
        <h1 class="text">Mood Detection Prediction</h1>

        <form method="POST" action="{{ route('sentiment.prediksi') }}" class="mt-4" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="inputText">Masukkan Teks yang Akan Diprediksi:</label>
                <textarea class="form-control" id="inputText" name="text" rows="5" placeholder="Ketik teks di sini..."></textarea>
            </div>
            
            <div class="audio-section mt-5">
                <!-- <h2 class="text-center">Atau Unggah File Audio</h2> -->
                <hr>
                <div class="form-group">
                    <label for="audio" class="form-label">Unggah File Audio:</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="audio" name="audio" accept=".wav, .mp3, .m4a">
                        <label class="custom-file-label" for="audio">Silahkan Pilih file audionya</label>
                    </div>
                    <small class="form-text text-muted">Jenis file yang didukung: .wav, .mp3, .m4a (maksimal 10MB)</small>
                </div>
            </div>

            <div class="text mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Prediksi</button>
            </div>
        </form>

        @if(isset($prediction))
            <div class="result mt-5">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Hasil Prediksi</h3>
                        <p class="card-text"><strong>Teks:</strong> {{ $text }}</p>
                        <p class="card-text"><strong>Prediksi:</strong> <span class="{{ $prediction === 'Positif' ? 'text-success' : 'text-danger' }}">{{ $prediction }}</span></p>
                        <p class="card-text"><strong>Skor:</strong> {{ $score }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</main>
@endsection
