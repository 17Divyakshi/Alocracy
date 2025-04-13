<?php
session_start();
if (!isset($_SESSION['aadhar'])) {
    header("Location: authenticate.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Vote Now</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(to right, #74ebd5, #ACB6E5);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .vote-box {
      background: #fff;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 15px 30px rgba(0,0,0,0.1);
      text-align: center;
      width: 400px;
    }

    h2 {
      margin-bottom: 30px;
      color: #333;
      font-size: 28px;
    }

    .party-btn {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-bottom: 20px;
    }

    .party-btn button {
      padding: 15px;
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: transform 0.2s, background-color 0.3s;
    }

    .party-btn button:hover {
      transform: scale(1.05);
    }

    .bjp { background-color: #ff9933; color: white; }
    .congress { background-color: #138808; color: white; }
    .aap { background-color: #1e90ff; color: white; }
    .others { background-color: #999; color: white; }

    .submit-btn {
      margin-top: 20px;
      padding: 12px 24px;
      background-color: #222;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }

    .submit-btn:hover {
      background-color: #000;
    }

    input[type="radio"] {
      display: none;
    }
  </style>
</head>
<body>
  <div class="vote-box">
    <h2>Cast Your Vote</h2>
    <form action="vote_submit.php" method="POST" id="voteForm">
      <div class="party-btn">
        <label><input type="radio" name="party" value="BJP" required><button class="bjp" type="button" onclick="selectParty('BJP')">🟧 BJP</button></label>
        <label><input type="radio" name="party" value="Congress"><button class="congress" type="button" onclick="selectParty('Congress')">🟩 Congress</button></label>
        <label><input type="radio" name="party" value="AAP"><button class="aap" type="button" onclick="selectParty('AAP')">🟦 AAP</button></label>
        <label><input type="radio" name="party" value="Others"><button class="others" type="button" onclick="selectParty('Others')">⬜ Others</button></label>
      </div>
      <input type="hidden" name="selectedParty" id="selectedParty">
      <button type="submit" class="submit-btn">Submit Vote</button>
    </form>
  </div>

  <script>
    function selectParty(party) {
      const radios = document.getElementsByName('party');
      for (let radio of radios) {
        if (radio.value === party) {
          radio.checked = true;
          document.getElementById("selectedParty").value = party;
          break;
        }
      }
    }

    document.getElementById("voteForm").addEventListener("submit", function(e) {
      const selected = document.querySelector('input[name="party"]:checked');
      if (!selected) {
        alert("Please select a party before submitting.");
        e.preventDefault();
      }
    });
  </script>
</body>
</html>

