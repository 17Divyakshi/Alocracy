import pandas as pd
import nltk
import os
import re
import google.generativeai as genai

nltk.download('punkt')

# Initialize Gemini
genai.configure(api_key="AIzaSyCQsqRKRTkXc4JKNAoNedF40j3TeSobiL4")

model = genai.GenerativeModel('gemini-1.5-pro')

def safe_word_tokenize(text):
    try:
        return nltk.word_tokenize(text)
    except LookupError:
        nltk.download('punkt')
        return nltk.word_tokenize(text)

def load_data():
    parent_dir = os.path.abspath(os.path.join(os.path.dirname(__file__), '..'))
    csv_path = os.path.join(parent_dir, 'voters.csv')
    df = pd.read_csv(csv_path)
    return df

def find_place(df, word):
    city_match = df[df['City'].str.lower() == word.lower()]
    if not city_match.empty:
        return 'city', city_match

    state_match = df[df['State'].str.lower() == word.lower()]
    if not state_match.empty:
        return 'state', state_match

    return None, None

def top_cities(df, top_n=3):
    city_counts = df['City'].value_counts().head(top_n)
    if top_n == 1:
        city, count = city_counts.index[0], city_counts.iloc[0]
        return f"🏆 {city} has the highest number of voters with {count} registered voters!"
    else:
        response = ""
        for i, (city, count) in enumerate(city_counts.items(), start=1):
            response += f"{i}. {city} - {count} voters\n"
        return response.strip()

def chatbot_response(user_input):
    df = load_data()
    tokens = safe_word_tokenize(user_input.lower())
    user_input_lower = user_input.lower()

    if 'top' in tokens and ('city' in tokens or 'cities' in tokens):
        match = re.search(r'\btop\s+(\d+)', user_input_lower)
        if match:
            top_n = int(match.group(1))
        else:
            top_n = 3
        return top_cities(df, top_n=top_n)

    ignore_words = ['city', 'state', 'voters', 'from', 'who', 'in', 'all', 'the', 'are', 'living']

    for word in tokens:
        if word not in ignore_words:
            place_type, results = find_place(df, word)
            if results is not None:
                count = len(results)
                if place_type == 'city':
                    return f"There are {count} registered voters in {word.capitalize()} city."
                elif place_type == 'state':
                    return f"There are {count} registered voters in {word.capitalize()} state."

    # If no city/state match, use Gemini to answer
    try:
        prompt = f"Provide a detailed and up-to-date news summary or explanation about: {user_input}"
        response = model.generate_content(prompt)
        return response.text
    except Exception as e:
        return f"An error occurred while accessing Gemini: {str(e)}"
