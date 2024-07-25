# Sentiment Analysis Web Application

Repositori ini berisi aplikasi web untuk analisis sentimen dengan dukungan untuk input teks dan pengunggahan file audio. Aplikasi ini dibangun menggunakan Laravel untuk frontend dan Flask untuk backend. Backend Flask mencakup model analisis sentimen dan fitur audio-ke-teks menggunakan model Whisper OpenAI. Dengan menggunakan Naive bayes dan Tf-idf

## Table of Contents

- [Features](#features)
- [Prerequisites](#prerequisites)
- [Setup](#setup)
  - [Laravel Setup](#laravel-setup)
  - [Flask Setup](#flask-setup)
- [Usage](#usage)
- [API Endpoints](#api-endpoints)
- [Contributing](#contributing)
- [License](#license)

## Features

- **Text Sentiment Analysis**: Analyze sentiment of provided text.
- **Audio-to-Text Conversion**: Convert audio files to text using OpenAI's Whisper model.
- **Prediction Storage**: Store and view predictions in a Laravel-based database.

## Prerequisites

Before setting up the application, ensure you have the following installed:

- [PHP](https://www.php.net/) (7.4 or later) for Laravel
- [Composer](https://getcomposer.org/) for PHP dependency management
- [Python](https://www.python.org/) (3.6 or later) for Flask
- [Pip](https://pip.pypa.io/en/stable/) for Python dependency management
- [MySQL](https://www.mysql.com/) or another database supported by Laravel
- [OpenAI API Key](https://beta.openai.com/signup/) for using Whisper model

## Setup

### Laravel Setup

1. **Clone the Repository**:

    ```bash
    git clone https://github.com/yourusername/yourrepository.git
    cd yourrepository
    ```

2. **Install PHP Dependencies**:

    ```bash
    composer install
    ```

3. **Set Up Environment File**:

    Copy `.env.example` to `.env`:

    ```bash
    cp .env.example .env
    ```

    Update `.env` with your database credentials and other configuration settings.

4. **Generate Application Key**:

    ```bash
    php artisan key:generate
    ```

5. **Run Database Migrations**:

    ```bash
    php artisan migrate
    ```

6. **Start Laravel Development Server**:

    ```bash
    php artisan serve
    ```

### Flask Setup

1. **Navigate to Flask Directory**:

    ```bash
    cd flask
    ```

2. **Set Up a Virtual Environment**:

    ```bash
    python -m venv venv
    source venv/bin/activate  # On Windows use `venv\Scripts\activate`
    ```

3. **Install Python Dependencies**:

    ```bash
    pip install -r requirements.txt
    ```

4. **Set Up Environment Variables**:

    Create a `.env` file in the `flask` directory with your OpenAI API key:

    ```bash
    OPENAI_API_KEY=your_openai_api_key
    ```

5. **Start Flask Server**:

    ```bash
    python app.py
    ```

## Usage

1. **Open the Laravel Application**:

   Navigate to `http://127.0.0.1:8000` in your web browser to access the Laravel frontend.

2. **Submit Text for Prediction**:

   Enter text into the form and click "Prediksi" to get sentiment analysis results.

3. **Upload Audio File for Conversion**:

   Choose an audio file and click "Prediksi" to convert the audio to text and analyze sentiment.

## API Endpoints

- **Text Prediction**: `POST http://127.0.0.1:5000/predict`
  - **Request**: JSON payload with `{ "text": "your_text_here" }`
  - **Response**: JSON with sentiment prediction and score.

- **Audio-to-Text**: `POST http://127.0.0.1:5000/audio-to-text`
  - **Request**: Form-data with an audio file.
  - **Response**: JSON with the transcribed text from the audio file.

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request with your changes. Ensure that your code adheres to the coding standards and includes appropriate tests.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

