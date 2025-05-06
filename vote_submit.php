<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Thank You!</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    body {
      font-family: 'Roboto', Arial, sans-serif;
      background: linear-gradient(90deg, #121826 60%, #1c2533 100%);
      color: #e3e8f5;
      min-height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      padding-top: 70px;
      box-sizing: border-box;
    }

    .thankyou-container {
      background: #1c2533;
      border-radius: 18px;
      box-shadow: 0 4px 24px #00d9ff22, 0 1.5px 0 #00d9ff22 inset;
      padding: 48px 36px 38px 36px;
      text-align: center;
      max-width: 410px;
      width: 100%;
      animation: fadeInUp 1s ease forwards;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    @keyframes fadeInUp {
      0% {
        opacity: 0;
        transform: translateY(40px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .thankyou-icon {
      font-size: 3.5rem;
      margin-bottom: 20px;
      color: #ffefc0;
      animation: bounce 1.5s infinite;
      text-shadow: 0 2px 12px #23294688;
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0);}
      50% { transform: translateY(-12px);}
    }

    .thankyou-container h1 {
      font-size: 2.4rem;
      color: #00d9ff;
      margin-bottom: 18px;
      font-weight: 700;
      letter-spacing: 1px;
      text-shadow: 0 2px 8px #23294688, 0 1px 0 #00d9ff;
    }

    .thankyou-container p {
      font-size: 1.15rem;
      color: #e3e8f5;
      margin-bottom: 36px;
      line-height: 1.6;
      letter-spacing: 0.2px;
    }

    .home-btn {
      display: inline-block;
      padding: 14px 36px;
      background: linear-gradient(90deg, #00d9ff, #8268ff 90%);
      color: #121826;
      border: none;
      border-radius: 10px;
      font-size: 1.1rem;
      font-weight: 700;
      text-decoration: none;
      box-shadow: 0 2px 12px #00d9ff44;
      transition: background 0.3s, color 0.3s, transform 0.2s;
      margin-top: 10px;
      letter-spacing: 0.5px;
    }

    .home-btn:hover,
    .home-btn:focus {
      background: linear-gradient(90deg, #8268ff, #00d9ff 90%);
      color: #fff;
      transform: translateY(-2px) scale(1.04);
      box-shadow: 0 8px 28px #00d9ff66;
    }

    @media (max-width: 600px) {
      .thankyou-container {
        padding: 30px 10px 20px 10px;
        max-width: 98vw;
      }
      .thankyou-container h1 {
        font-size: 1.4rem;
      }
      .thankyou-icon {
        font-size: 2.2rem;
      }
    }
  </style>
</head>
<body>
  <div class="thankyou-container">
    <div class="thankyou-icon">🎉</div>
    <h1>Thank You!</h1>
    <p>Your submission has been received.<br>We appreciate your participation.</p>
    <a href="/index.html" class="home-btn">Back to Home</a>
  </div>
</body>
</html>
