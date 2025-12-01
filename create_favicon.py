from PIL import Image

input_path = r"c:\laragon\www\tahsionline\public\images\logo.png"
output_path = r"c:\laragon\www\tahsionline\public\favicon.ico"

try:
    img = Image.open(input_path)
    # Resize to standard favicon sizes
    img.save(output_path, format='ICO', sizes=[(16, 16), (32, 32), (48, 48), (64, 64)])
    print(f"Successfully created favicon at {output_path}")
except Exception as e:
    print(f"Error creating favicon: {e}")
