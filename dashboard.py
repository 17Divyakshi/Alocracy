from flask import Flask, render_template, jsonify
import csv
from collections import Counter

app = Flask(__name__)

@app.route('/')
def dashboard():
    return render_template('dashboard.html')

@app.route('/data')
def get_data():
    # ----- Read from voters.csv -----
    state_counts = Counter()
    city_counts = Counter()
    unique_voters = set()
    try:
        with open('voters.csv', 'r', encoding='utf-8') as file:
            reader = csv.DictReader(file)
            for row in reader:
                state = row.get('State')
                city = row.get('City')
                number = row.get('Number')

                if number:
                    unique_voters.add(number)
                if state:
                    state_counts[state] += 1
                if city:
                    city_counts[city] += 1
    except Exception as e:
        print("Error reading voters.csv:", e)

    # ----- Read from votes.csv -----
    party_counts = Counter()
    total_votes = 0
    try:
        with open('votes.csv', 'r', encoding='utf-8') as file:
            reader = csv.DictReader(file)
            for row in reader:
                party = row.get('Party')
                if party:
                    party_counts[party] += 1
                    total_votes += 1
    except Exception as e:
        print("Error reading votes.csv:", e)

    # ----- JSON Response -----
    return jsonify({
        'total_votes': total_votes,
        'unique_voters': len(unique_voters),
        'state_counts': dict(state_counts),
        'city_counts': dict(city_counts),
        'party_counts': dict(party_counts),
        
    })
   

if __name__ == '__main__':
    app.run(debug=True)