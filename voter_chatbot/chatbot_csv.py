import google.generativeai as genai

# Initialize Gemini
genai.configure(api_key="AIzaSyCQsqRKRTkXc4JKNAoNedF40j3TeSobiL4")
model = genai.GenerativeModel('gemini-1.5-pro')

def chatbot_response(user_input):
    try:
        # Use Gemini to generate a response
        response = model.generate_content(user_input)
        return response.text
    except Exception as e:
        return f"Sorry, I encountered an error: {str(e)}"
