from PIL import Image

img_path = r"C:\Users\HP\.gemini\antigravity\brain\cdddd42e-901a-4137-b8cf-587ce1077af6\uploaded_image_1764564413036.png"
img = Image.open(img_path)
print(f"Format: {img.format}, Size: {img.size}, Mode: {img.mode}")
