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
  background: linear-gradient(90deg, #121826 60%, #1c2533 100%);
  color: #e3e8f5;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.vote-box {
  background: #1c2533;
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0 8px 32px #00d9ff33, 0 1.5px 0 #00d9ff22 inset;
  text-align: center;
  width: 400px;
  border: 1.5px solid #00d9ff;
}

h2 {
  margin-bottom: 30px;
  color: #00d9ff;
  font-size: 28px;
  letter-spacing: 1px;
  font-weight: 700;
  text-shadow: 0 2px 8px #23294688, 0 1px 0 #00d9ff;
}
  
.party-btn {
  display: flex;
  flex-direction: column;
  gap: 15px;
  margin-bottom: 20px;
}


.party-btn button {
  padding: 8px;
  font-size: 16px;
  font-weight: bold;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.3s, background 0.3s, color 0.3s;
  box-shadow: 0 2px 12px #00d9ff33;
  letter-spacing: 1px;
  outline: none;
  width: 100%;        /* Make buttons full width of parent */
  height: 60px;       /* Fixed height for consistency */
  display: flex;
  align-items: center;
  justify-content: center;
}

.party-btn button:hover {
  transform: scale(1.05);
  box-shadow: 0 6px 18px #8268ff55;
}

.bjp {
  background: linear-gradient(90deg, #ff9933 60%, #ffe29f 100%);
  color: #232946;
  text-shadow: 0 1px 6px #fff2;
}

.congress {
  background: linear-gradient(90deg, #138808 60%, #28e1a7 100%);
  color: #e3e8f5;
  text-shadow: 0 1px 4px #00d9ff44;
}

.aap {
  background: linear-gradient(90deg, #1e90ff 60%, #00d9ff 100%);
  color: #fff;
  text-shadow: 0 1px 4px #8268ff44;
}

.others {
  background: linear-gradient(90deg, #555 60%, #8268ff 100%);
  color: #fff;
  text-shadow: 0 1px 4px #00d9ff44;
}

.submit-btn {
  margin-top: 20px;
  padding: 12px 24px;
  background: linear-gradient(90deg, #00d9ff, #8268ff 90%);
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
  box-shadow: 0 2px 12px #00d9ff44;
  transition: background 0.3s, box-shadow 0.2s;
  letter-spacing: 1px;
}

.submit-btn:hover {
  background: linear-gradient(90deg, #8268ff, #00d9ff 90%);
  color: #fff;
  box-shadow: 0 6px 18px #8268ff44;
}

input[type="radio"] {
  display: none;
}

/* Responsive */
@media (max-width: 500px) {
  .vote-box {
    padding: 20px 8px;
    max-width: 98vw;
    width: 98vw;
  }
  h2 { font-size: 1.3rem; }
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
