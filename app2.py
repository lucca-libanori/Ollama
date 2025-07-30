from flask import Flask, request, jsonify, send_from_directory
from flask_cors import CORS
from ollama import chat
from pydantic import BaseModel


app = Flask(__name__, static_folder='static') 
CORS(app) 

class TeamStats(BaseModel):
    name: str
    country: str
    foundation: str
    stadium: str
    titles: list[str]
    sport: str = "Football"

@app.route('/api/ask', methods=['POST', 'OPTIONS'])
def ask_team():
    data = request.get_json()

    if not data or 'message' not in data:
        return jsonify({'error': 'Missing "message" field'}), 400

    team_name = data['message']

    system_prompt = "You are an expert football club database assistant. Return only football club information."

    user_message = f"""
Give me detailed information about the football club {team_name}, including:
- Name
- Country
- Foundation year
- Stadium
- A list of main titles won (with name and quantity if possible)

Return the answer strictly in JSON format, matching this structure:
{{
  "name": "...",
  "country": "...",
  "foundation": "...",
  "stadium": "...",
  "titles": ["title1", "title2", "title3"],
  "sport": "Football"
}}
"""

    try:
        response = chat(
            messages=[
                {"role": "system", "content": system_prompt},
                {"role": "user", "content": user_message}
            ],
            model='gemma3:4b', 
            format=TeamStats.model_json_schema()
        )
        team = TeamStats.model_validate_json(response.message.content)

        return jsonify(team.model_dump())

    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/')
def index():
    return send_from_directory(app.static_folder, 'principal.html')

if __name__ == '__main__':
    app.run(debug=True, port=5000)
