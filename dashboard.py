from flask import Flask, render_template, jsonify
import csv
from collections import Counter

app = Flask(__name__)

@app.route('/')
def dashboard():
    return render_template('dashboard.html')

@app.route('/data')
def get_data():
    state_counts = Counter()
    city_counts = Counter()
    unique_voters = set()
    vote_data = []

    # --- Read from voters.csv ---
    try:
        with open('voters.csv', 'r', encoding='utf-8') as file:
            reader = csv.DictReader(file)
            for row in reader:
                state = row.get('State', '').strip().title()
                city = row.get('City', '').strip().title()
                number = row.get('Number', '').strip()

                if number:
                    unique_voters.add(number)
                if state:
                    state_counts[state] += 1
                if city:
                    city_counts[city] += 1
    except Exception as e:
        print("Error reading voters.csv:", e)

    # --- Read from votes.csv ---
    party_counts = Counter()
    total_votes = 0
    try:
        with open('votes.csv', 'r', encoding='utf-8') as file:
            reader = csv.DictReader(file)
            for row in reader:
                party = row.get('Party', '').strip().upper()
                state = row.get('State', '').strip().title()

                row['Party'] = party
                row['State'] = state
                vote_data.append(row)

                if party:
                    party_counts[party] += 1
                    total_votes += 1
    except Exception as e:
        print("Error reading votes.csv:", e)

    # --- 🧠 Generate Insights ---
    insights = []
    
    if party_counts:
     top_party, top_votes = party_counts.most_common(1)[0]
     insights.append(f"{top_party} is currently leading overall with {top_votes} vote(s).")
    # 1. Leading party across states
    state_party_map = {}  # state -> party counter
    for row in vote_data:
        state = row.get('State')
        party = row.get('Party')
        if state and party:
            if state not in state_party_map:
                state_party_map[state] = Counter()
            state_party_map[state][party] += 1

    party_leads = Counter()
    for state, counter in state_party_map.items():
        if counter:
            top_party = counter.most_common(1)[0][0]
            party_leads[top_party] += 1

    if party_leads:
        leading_party, lead_count = party_leads.most_common(1)[0]
        insights.append(f"{leading_party} is leading in {lead_count} states.")

    # 2. City with most votes
    if city_counts:
        top_city, top_votes = city_counts.most_common(1)[0]
        insights.append(f"Most votes are coming from {top_city} ({top_votes} votes).")

    # 3. Fallback if no insights found
    if not insights:
        insights.append("Waiting for more votes to generate insights.")

    print("Insights Sent to Frontend:", insights)

    # --- JSON Response ---
    return jsonify({
        'total_votes': total_votes,
        'unique_voters': len(unique_voters),
        'state_counts': dict(state_counts),
        'city_counts': dict(city_counts),
        'party_counts': dict(party_counts),
        'insights': insights
    })

if __name__ == '__main__':
    app.run(debug=True)

