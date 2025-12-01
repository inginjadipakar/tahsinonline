from PIL import Image
import os

input_path = r"C:\Users\HP\.gemini\antigravity\brain\cdddd42e-901a-4137-b8cf-587ce1077af6\tahsinku_logo_v2_1764546288860.png"
output_path = r"C:\Users\HP\.gemini\antigravity\brain\cdddd42e-901a-4137-b8cf-587ce1077af6\tahsinku_logo_transparent.png"

try:
    img = Image.open(input_path)
    img = img.convert("RGBA")
    datas = img.getdata()

    newData = []
    for item in datas:
        # Change all white (also shades of whites) to transparent
        # Threshold can be adjusted. 240 is a good starting point for "white-ish"
        if item[0] > 240 and item[1] > 240 and item[2] > 240:
            newData.append((255, 255, 255, 0))
        else:
            newData.append(item)

    img.putdata(newData)
    img.save(output_path, "PNG")
    print(f"Successfully saved transparent image to {output_path}")
except Exception as e:
    print(f"Error: {e}")
