from flask import Flask, render_template, request, jsonify
from chatbot_csv import chatbot_response

app = Flask(__name__)

@app.route('/')
def home():
    return render_template('chat.html')

@app.route('/get_response', methods=['POST'])
def get_bot_response():
    user_message = request.json['message']
    bot_message = chatbot_response(user_message)
    return jsonify({'response': bot_message})

if __name__ == "__main__":
    app.run(debug=True)
