from flask import Flask, request, jsonify
import joblib
import random
from openai import OpenAI
import os

app = Flask(__name__)

# Load model and TF-IDF Vectorizer
model = joblib.load('model/main_0_1.joblib')
tfidf = joblib.load('model/mainTfidf_0_1.joblib')

client = OpenAI(api_key='Masukan_API_KEY_KALIAN_DISINI')

# Dictionary containing suggestions for each class
suggestions_dict = {
    'Love': [
        "Lanjutkan untuk menunjukkan kasih sayang kepada orang-orang terdekat.",
        "Ungkapkan rasa cinta Anda dengan cara yang kreatif.",
        "Berikan perhatian lebih kepada orang yang Anda cintai.",
        "Jangan ragu untuk mengungkapkan perasaan Anda.",
        "Cobalah untuk merencanakan waktu berkualitas bersama orang yang Anda cintai."
    ],
    'Anger': [
        "Coba tenangkan diri dengan mengambil napas dalam-dalam.",
        "Mengalihkan pikiran ke aktivitas yang menyenangkan bisa membantu.",
        "Hindari keputusan impulsif saat marah.",
        "Cobalah untuk berbicara dengan seseorang yang Anda percayai.",
        "Jika kemarahan berlanjut, mungkin baik untuk mencari bantuan profesional."
    ],
    'Joy': [
        "Bagikan kebahagiaan Anda dengan orang lain.",
        "Terus lakukan hal-hal yang membuat Anda bahagia.",
        "Jadikan momen ini sebagai pengingat untuk mensyukuri hal-hal baik dalam hidup.",
        "Kebahagiaan Anda bisa menjadi inspirasi bagi orang lain.",
        "Nikmati momen ini sepenuhnya."
    ],
    'Fear': [
        "Coba hadapi ketakutan Anda secara perlahan dan bertahap.",
        "Berbicara dengan teman atau keluarga dapat memberikan ketenangan.",
        "Mencari informasi lebih lanjut bisa membantu mengurangi rasa takut.",
        "Jika ketakutan terus berlanjut, pertimbangkan untuk berkonsultasi dengan profesional.",
        "Fokus pada apa yang dapat Anda kendalikan."
    ],
    'Sad': [
        "Jangan ragu untuk berbagi perasaan dengan seseorang yang Anda percayai.",
        "Cobalah untuk melakukan aktivitas yang biasanya Anda nikmati.",
        "Terkadang, istirahat sejenak dari rutinitas bisa membantu.",
        "Jika kesedihan berlanjut, pertimbangkan untuk mencari bantuan profesional.",
        "Ingatlah bahwa tidak apa-apa untuk merasa sedih."
    ],
    'Neutral': [
        "Lanjutkan aktivitas Anda dan tetaplah fokus.",
        "Tidak ada yang salah dengan merasa netral, teruslah melangkah.",
        "Gunakan waktu ini untuk refleksi diri.",
        "Terkadang, perasaan netral adalah bagian dari proses.",
        "Fokus pada tujuan Anda dan teruslah berusaha."
    ]
}

@app.route('/predict', methods=['POST'])
def predict():
    data = request.json
    text = data.get('text')

    if text:
        # Transform text using TF-IDF Vectorizer
        text_tfidf = tfidf.transform([text])

        # Predict sentiment and score
        prediction = model.predict(text_tfidf)[0]
        score = model.predict_proba(text_tfidf)[0].max()  # Get the probability of the predicted class

        # Select one suggestion based on the predicted sentiment
        suggestions = suggestions_dict.get(prediction, ["Tidak ada saran yang tersedia"])
        suggestion = random.choice(suggestions)

        # Recommend consulting a professional if the prediction is fear, anger, or sad with a high score
        if score > 0.7 and prediction in ['Fear', 'Anger', 'Sad']:
            suggestion += " pertimbangkan untuk berkonsultasi dengan psikolog atau psikiater."

        # Return prediction, score, and suggestion in JSON format
        return jsonify({'prediction': prediction, 'score': score, 'suggestions': [suggestion]})
    else:
        return jsonify({'error': 'No text provided'}), 400

@app.route('/audio-to-text', methods=['POST'])
def audio_to_text():
    if 'audio' not in request.files:
        return jsonify({'error': 'No audio file provided'}), 400

    audio = request.files['audio']
    audio.save('temp_audio.wav')  # Save the audio file temporarily

    # Send audio file to OpenAI's Whisper model
    with open('temp_audio.wav', 'rb') as audio_file:
        response = client.audio.transcriptions.create(
            model="whisper-1",
            file=audio_file
        )

    os.remove('temp_audio.wav')  # Clean up temporary file

    text = response.text
    return jsonify({'text': text})

if __name__ == '__main__':
    app.run(debug=True)
