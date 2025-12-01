from PIL import Image

input_path = r"C:\Users\HP\.gemini\antigravity\brain\cdddd42e-901a-4137-b8cf-587ce1077af6\uploaded_image_1764564413036.png"
output_path = r"c:\laragon\www\tahsionline\public\images\online-privat.png"

img = Image.open(input_path)
width, height = img.size

# Crop the right side (approx 55% to be safe and get the photo)
# Adjust these values based on visual estimation of the screenshot
left = int(width * 0.45) 
top = 0
right = width
bottom = height

cropped_img = img.crop((left, top, right, bottom))
cropped_img.save(output_path)
print(f"Saved cropped image to {output_path}")
