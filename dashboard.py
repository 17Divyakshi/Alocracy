from flask import Flask, render_template, jsonify
import csv
from collections import Counter
from datetime import datetime

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
    number_to_location = {}
    age_groups = Counter()


    # --- Step 1: Read voters.csv (to map Number -> State and City) ---
    try:
        with open('voters.csv', 'r', encoding='utf-8') as file:
            reader = csv.DictReader(file)
            for row in reader:
                number = row.get('Number', '').strip()
                state = row.get('State', '').strip().title()
                city = row.get('City', '').strip().title()
                dob = row.get('DOB', '').strip()


                if number:
                    if number not in number_to_location:
                        number_to_location[number] = {
                            'State': state,
                            'City': city
                        }
                    if number not in unique_voters:
                        unique_voters.add(number)
                        if state:
                            state_counts[state] += 1
                        if city:
                            city_counts[city] += 1
                    dob = row.get('DOB','').strip()
                    if dob:
                        try:
                            birth_date = datetime.strptime(dob,"%Y-%m-%d")
                            age =(datetime.now() - birth_date).days//365
                            print(f"Number: {number}, DOB: {dob}, Age: {age}") 
                            if age < 18:
                              age_groups['Under 18'] += 1
                            elif age < 30:
                              age_groups['18-29'] += 1
                            elif age < 45:
                              age_groups['30-44'] += 1
                            elif age < 60:
                              age_groups['45-59'] += 1
                            else:
                              age_groups['60+'] += 1
                        except ValueError:
                            pass

    except Exception as e:
        print("Error reading voters.csv:", e)

    # --- Step 2: Read votes.csv ---
    party_counts = Counter()
    total_votes = 0
    try:
        with open('votes.csv', 'r', encoding='utf-8') as file:
            reader = csv.DictReader(file)
            for row in reader:
                number = row.get('Number', '').strip()
                party = row.get('Party', '').strip().upper()

                if number and party:
                    party_counts[party] += 1
                    total_votes += 1

                    # Find state using voter's number
                    location = number_to_location.get(number, {})
                    state = location.get('State', '')

                    vote_data.append({
                        'Party': party,
                        'State': state
                    })

    except Exception as e:
        print("Error reading votes.csv:", e)

    # --- Step 3: Generate Insights ---
    insights = []

    # Leading party across states
    state_party_map = {}
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
            top_party = counter.most_common(1)[0]
            party_leads[top_party[0]] += 1

    if party_leads:
        leading_party, lead_count = party_leads.most_common(1)[0]
        insights.append(f"{leading_party} is leading in {lead_count} state.")

    # City with most votes
    if city_counts:
        top_city, top_votes = city_counts.most_common(1)[0]
        insights.append(f"Most votes are coming from {top_city} ({top_votes} votes).")

    # Fallback if no insights
    if not insights:
        insights.append("Waiting for more votes to generate insights.")

    print("Insights Sent to Frontend:", insights)

    return jsonify({
        'total_votes': total_votes,
        'unique_voters': len(unique_voters),
        'state_counts': dict(state_counts),
        'city_counts': dict(city_counts),
        'party_counts': dict(party_counts),
         'age_groups': dict(age_groups),

        'insights': insights
    })

if __name__ == '__main__':
    app.run(debug=True)












