from fastapi import FastAPI, File, UploadFile, HTTPException
import torch
import torch.nn as nn
from torchvision import models, transforms
from PIL import Image
import io

app = FastAPI(title="Skin Cancer Classification API")

# 1. تحديد المعالج
device = torch.device('cuda' if torch.cuda.is_available() else 'cpu')

# 2. أسماء الفئات بالترتيب
CLASS_NAMES = [
    'akiec (سرطان حرشفي)',
    'bcc (سرطان قاعدة)',
    'bkl (ورم حميد)',
    'df (ألياف جلدية)',
    'mel (ورم ميلانيني خبيث)',
    'nv (شامة عادية)',
    'vasc (أوعية دموية)'
]

# 3. تحميل أوزان نموذج EfficientNet-B2
def load_model():
    model = models.efficientnet_b2(weights=None)
    model.classifier[1] = nn.Linear(model.classifier[1].in_features, len(CLASS_NAMES))
    
    state_dict = torch.load('models/efficientnet_ham10000_best.pth', map_location=device)
    model.load_state_dict(state_dict)
    
    model = model.to(device)
    model.eval()
    return model

model = load_model()

# 4. المعالجة المسبقة (طابق تماماً val_transforms بحجم 300x300)
IMAGE_SIZE = 300
transform_pipeline = transforms.Compose([
    transforms.Resize((IMAGE_SIZE, IMAGE_SIZE)),
    transforms.ToTensor(),
    transforms.Normalize(mean=[0.485, 0.456, 0.406], std=[0.229, 0.224, 0.225])
])

# 5. الـ Endpoint (مطابق لاسم البرامتر 'image' الموجود بالـ Service)
@app.post("/predict")
async def predict(image: UploadFile = File(...)):  # هنا تم ضبط الاسم ليكون image
    if not image.content_type.startswith("image/"):
        raise HTTPException(status_code=400, detail="Uploaded file is not an image.")

    try:
        # قراءة الصورة وتجهيزها
        contents = await image.read()
        pil_img = Image.open(io.BytesIO(contents)).convert('RGB')
        
        # تحويل الصورة إلى Tensor وإضافة batch dimension
        tensor_image = transform_pipeline(pil_img).unsqueeze(0).to(device)
        
        # التنبؤ
        with torch.no_grad():
            outputs = model(tensor_image)
            probabilities = torch.softmax(outputs, dim=1)[0]
            confidence, predicted_idx = torch.max(probabilities, 0)

        predicted_class = CLASS_NAMES[predicted_idx.item()]
        
        # حساب النسب المئوية لكافة الأمراض
        all_probabilities = {
            CLASS_NAMES[i]: round(probabilities[i].item() * 100, 2)
            for i in range(len(CLASS_NAMES))
        }

        # النتيجة التي ستستلمها الـ Service كـ JSON
        return {
            "success": True,
            "prediction": predicted_class,
            "confidence": round(confidence.item() * 100, 2),
            "all_probabilities": all_probabilities
        }

    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Prediction error: {str(e)}")