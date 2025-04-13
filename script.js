document.addEventListener("DOMContentLoaded", function () {
    const uploadInput = document.getElementById("voterIDUpload");
    const uploadBtn = document.getElementById("uploadBtn");
    const uploadStatus = document.getElementById("uploadStatus");
    const authBtn = document.getElementById("authBtn");
    const authStatus = document.getElementById("auth-status");
    const proceedBtn = document.getElementById("proceedBtn");
    const video = document.getElementById("video");
  
    let uploadedFileName = "";
  
    // Start camera
    function startCamera() {
      navigator.mediaDevices
        .getUserMedia({ video: true })
        .then((stream) => {
          video.srcObject = stream;
          video.play();
          authStatus.innerText = "✅ Camera Started!";
        })
        .catch((error) => {
          console.error("❌ Camera access error:", error);
          authStatus.innerText = "❌ Cannot access camera!";
        });
    }
  
    // Upload voter ID
    uploadBtn.addEventListener("click", function () {
      const file = uploadInput.files[0];
  
      if (!file) {
        uploadStatus.innerHTML = "❌ No file selected!";
        return;
      }
  
      const formData = new FormData();
      formData.append("voterID", file);
  
      fetch("upload.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "success") {
            uploadStatus.innerHTML = "✅ " + data.message;
            uploadedFileName = data.filename;
            startCamera();
          } else {
            uploadStatus.innerHTML = "❌ " + data.message;
          }
        })
        .catch((error) => {
          console.error("❌ Upload error:", error);
          uploadStatus.innerHTML = "❌ Error uploading file!";
        });
    });
  
    // Authenticate face
    authBtn.addEventListener("click", function () {
      if (!uploadedFileName) {
        authStatus.innerText = "❌ Upload a Voter ID first!";
        return;
      }
  
      captureAndSendFrame();
    });
  
    function captureAndSendFrame() {
      const canvas = document.createElement("canvas");
      const context = canvas.getContext("2d");
  
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      context.drawImage(video, 0, 0, canvas.width, canvas.height);
  
      canvas.toBlob((blob) => {
        const formData = new FormData();
        formData.append("liveCapture", blob, "live_capture.jpg");
        formData.append("voterFileName", uploadedFileName);
  
        fetch("authenticate.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            console.log("Auth Response:", data);
            if (data.verified) {
              authStatus.innerText = "✅ Face Matched! Proceed to Voting.";
              proceedBtn.style.display = "inline-block";
            } else {
              authStatus.innerText =
                "❌ Face Not Matched! " + (data.error || "Try Again.");
              proceedBtn.style.display = "none";
            }
          })
          .catch((error) => {
            console.log("❌ Face authentication error:", error);
            authStatus.innerText = "❌ Error authenticating face!";
            proceedBtn.style.display = "none";
          });
      }, "image/jpeg");
    }
  
    // Proceed to Voting
    proceedBtn.addEventListener("click", function () {
      window.location.href = "authenticate.html";
    });
  });
  