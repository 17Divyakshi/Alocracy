import json
import cv2
from deepface import DeepFace

img1_path = "uploads/live_capture.jpeg"
img2_path = "uploads/voter_card.jpeg"

try:
    # Check if images exist and can be read
    img1 = cv2.imread(img1_path)
    img2 = cv2.imread(img2_path)

    if img1 is None:
        raise Exception(f"Cannot read {img1_path}")
    if img2 is None:
        raise Exception(f"Cannot read {img2_path}")

    # Run DeepFace verification
    result = DeepFace.verify(img1_path, img2_path)
    response = {
        "verified": result["verified"],
        "distance": result["distance"]
    }
except Exception as e:
    response = {"verified": False, "error": str(e)}

# Always return JSON
print(json.dumps(response))
