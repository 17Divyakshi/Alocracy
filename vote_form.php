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

    .party-label {
      display: flex;
      align-items: center;
      cursor: pointer;
      border-radius: 10px;
      box-shadow: 0 2px 12px #00d9ff33;
      transition: box-shadow 0.3s, transform 0.2s;
      height: 60px;
      width: 90%;
      font-weight: bold;
      font-size: 16px;
      letter-spacing: 1px;
      justify-content: flex-start;
      margin: 0;
      padding: 0 18px;
      border: none;
      position: relative;
      gap: 18px;
    }

    .party-label:hover {
      transform: scale(1.03);
      box-shadow: 0 6px 18px #8268ff55;
    }

    /* Hide native radio */
    .party-label input[type="radio"] {
      position: absolute;
      opacity: 0;
      width: 0;
      height: 0;
    }

    /* Custom radio */
    .custom-radio {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      border: 2.5px solid #00d9ff;
      background: #232946;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 10px;
      position: relative;
      transition: border-color 0.2s, box-shadow 0.2s;
      font-size: 22px;
      color: #00d9ff;
      box-shadow: 0 2px 8px #00d9ff22;
    }

    /* Tick hidden by default */
    .custom-radio .tick {
      display: none;
      font-size: 1.2em;
      color: #00d9ff;
      font-weight: bold;
    }

    /* Show tick when checked */
    .party-label input[type="radio"]:checked + .custom-radio .tick {
      display: block;
      color: #fff;
      text-shadow: 0 1px 6px #00d9ff88;
    }

    /* Change border color when checked */
    .party-label input[type="radio"]:checked + .custom-radio {
      border-color: #fff;
      background: #00d9ff;
      color: #fff;
    }

    /* Party-specific backgrounds for label */
    .bjp { background: linear-gradient(90deg, #d97410, #ffb46a 80%); color: #232946;}
    .congress { background: linear-gradient(90deg, #12a005, #67e26a 80%); color: #e3e8f5;}
    .aap { background: linear-gradient(90deg, #0e65bc, #6db6ff 80%); color: #fff;}
    .others { background: linear-gradient(90deg, #555, #aaa 80%); color: #fff;}

    .party-label .party-text {
      flex: 1;
      text-align: left;
      font-size: 1.1em;
      font-weight: 700;
      letter-spacing: 1px;
      text-shadow: 0 1px 4px #23294644;
    }

    .submit-btn {
      margin-top: 20px;
      padding: 12px 24px;
      background: #00d9ff;
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
      background: #20a1f2;
      color: #fff;
      box-shadow: 0 6px 18px #8268ff44;
    }

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
        <label class="party-label bjp">
          <input type="radio" name="party" value="BJP" required>
          <span class="custom-radio"><span class="tick">&#10003;</span></span>
          <span class="party-text">🟧 BJP</span>
        </label>
        <label class="party-label congress">
          <input type="radio" name="party" value="Congress">
          <span class="custom-radio"><span class="tick">&#10003;</span></span>
          <span class="party-text">🟩 Congress</span>
        </label>
        <label class="party-label aap">
          <input type="radio" name="party" value="AAP">
          <span class="custom-radio"><span class="tick">&#10003;</span></span>
          <span class="party-text">🟦 AAP</span>
        </label>
        <label class="party-label others">
          <input type="radio" name="party" value="Others">
          <span class="custom-radio"><span class="tick">&#10003;</span></span>
          <span class="party-text">⬜ Others</span>
        </label>
      </div>
      <input type="hidden" name="selectedParty" id="selectedParty">
      <button type="submit" class="submit-btn">Submit Vote</button>
    </form>
  </div>

  <script>
    // Set hidden field on selection
    document.querySelectorAll('input[name="party"]').forEach(radio => {
      radio.addEventListener('change', function() {
        document.getElementById("selectedParty").value = this.value;
      });
    });

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
