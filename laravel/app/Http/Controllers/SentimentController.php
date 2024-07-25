<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Predictions;
use Illuminate\Support\Facades\Auth;

class SentimentController extends Controller
{
    //
    public function index()
    {
        return view('sentiment.sentiment');
    }

    public function predict(Request $request)
    {
        $validatedData = $request->validate([
            'text' => 'nullable|string',
            'audio' => 'nullable|file|mimes:wav,mp3,m4a|max:10240', // Max file size 10MB
        ]);

        $text = $validatedData['text'] ?? '';

        // If an audio file is uploaded, process it
        if ($request->hasFile('audio')) {
            $response = Http::attach(
                'audio', file_get_contents($request->file('audio')->getRealPath()), 'audio.wav'
            )->post('http://127.0.0.1:5000/audio-to-text');

            if ($response->successful()) {
                $text = $response->json()['text'];
            } else {
                return redirect()->back()->with('error', 'Audio-to-text conversion failed.');
            }
        }

        // If text is provided or obtained from audio, process the prediction
        if (!empty($text)) {
            $response = Http::post('http://127.0.0.1:5000/predict', [
                'text' => $text
            ]);

            if ($response->successful()) {
                $prediction = $response->json()['prediction'];
                $score = $response->json()['score'];

                $sentimentPrediction = Predictions::create([
                    'text' => $text,
                    'prediction' => $prediction,
                    'score' => $score,
                    'user_id' => Auth::user()->id,
                ]);

                $sentimentPrediction->save();

                return view('sentiment.sentiment', [
                    'prediction' => $prediction,
                    'score' => $score,
                    'text' => $text,
                ]);
            } else {
                return redirect()->back()->with('error', 'Prediction failed.');
            }
        } else {
            return redirect()->back()->with('error', 'No text provided for prediction.');
        }
    }
}
