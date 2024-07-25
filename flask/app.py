from flask import Flask, request, jsonify
import joblib
from openai import OpenAI
import os

app = Flask(__name__)

# Load model and TF-IDF Vectorizer
model = joblib.load('model/main_0_1.joblib')
tfidf = joblib.load('model/mainTfidf_0_1.joblib')

client = OpenAI(api_key='Masukan_API_KEY_KALIAN_DISINI')

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

        # Return prediction and score in JSON format
        return jsonify({'prediction': prediction, 'score': score})
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
