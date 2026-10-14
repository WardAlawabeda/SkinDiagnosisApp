# 🩺 Skin Diagnosis App

An AI-powered skin lesion classification system developed as a university project. The application combines a **Laravel backend** with a **Python deep learning pipeline** and a **prediction API** to analyze skin lesion images and classify them into one of seven diagnostic categories.

> **Project Status:** In Development

---

## 📌 Overview

The Skin Diagnosis App is designed to provide an automated analysis of dermoscopic skin lesion images using deep learning.

The system consists of three main components:

* **Laravel Backend** — Handles the application backend, users, requests, and communication with the prediction service.
* **Deep Learning Pipeline** — Responsible for preprocessing, training, evaluation, and experimentation with deep learning models.
* **Prediction API** — Provides an interface for the Laravel backend to send an image to the trained model and receive a prediction.

The current deep learning approach uses **EfficientNet** for skin lesion classification.

---

## 🧠 Supported Classes

The model is trained to classify skin lesions into seven classes from the **HAM10000 dataset**:

| Code    | Disease                             |
| ------- | ----------------------------------- |
| `akiec` | Actinic keratoses / Bowen's disease |
| `bcc`   | Basal cell carcinoma                |
| `bkl`   | Benign keratosis-like lesions       |
| `df`    | Dermatofibroma                      |
| `mel`   | Melanoma                            |
| `nv`    | Melanocytic nevi                    |
| `vasc`  | Vascular lesions                    |

---

## 🏗️ System Architecture

```text
                 ┌─────────────────────┐
                 │   Client / Frontend │
                 └──────────┬──────────┘
                            │
                            ▼
                 ┌─────────────────────┐
                 │   Laravel Backend   │
                 │       (PHP)         │
                 └──────────┬──────────┘
                            │
                     HTTP / REST API
                            │
                            ▼
                 ┌─────────────────────┐
                 │   Python Prediction │
                 │         API         │
                 └──────────┬──────────┘
                            │
                            ▼
                 ┌─────────────────────┐
                 │ EfficientNet Model  │
                 │   Deep Learning     │
                 └──────────┬──────────┘
                            │
                            ▼
                 ┌─────────────────────┐
                 │ Prediction +        │
                 │ Confidence Score    │
                 └─────────────────────┘
```

---

## 📂 Project Structure

```text
SkinDiagnosisApp/
│
├── Backend/
│   └── Laravel application
│
├── DL/
│   ├── preprocessing/
│   ├── training/
│   ├── prediction/
│   ├── models/
│   └── ...
│
├── .gitignore
└── README.md
```

---

## 🔬 Deep Learning Pipeline

The deep learning component follows an iterative development process:

1. Dataset preparation
2. Image preprocessing
3. Data cleaning
4. Data augmentation
5. Model training
6. Validation
7. Model evaluation
8. Hyperparameter experimentation
9. Model selection
10. Deployment through the prediction API

The main deep learning model currently being investigated is **EfficientNet**, with experiments focused on improving generalization and classification performance across the seven classes.

---

## 📊 Dataset

This project uses the **HAM10000 (Human Against Machine with 10000 training images)** dataset for skin lesion classification.

The dataset contains dermoscopic images belonging to seven diagnostic categories.

The original dataset is **not included in this repository**.

Dataset:

> Tschandl, P., Rosendahl, C., Kittler, H.
> The HAM10000 dataset, a large collection of multi-source dermatoscopic images of common pigmented skin lesions.

---

## ⚙️ Technologies

### Backend

* PHP
* Laravel
* REST API
* Composer

### Deep Learning

* Python
* PyTorch
* EfficientNet
* NumPy
* Pandas
* Scikit-learn
* OpenCV
* Matplotlib

### API

* Python
* FastAPI
* Uvicorn

---

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/WardAlawabeda/SkinDiagnosisApp.git
cd SkinDiagnosisApp
```

---

### 2. Backend Setup

Navigate to the Laravel backend:

```bash
cd Backend
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies if required:

```bash
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

Configure the database and other environment variables inside `.env`.

Run migrations:

```bash
php artisan migrate
```

Start the Laravel development server:

```bash
php artisan serve
```

---

### 3. Deep Learning Setup

Navigate to the deep learning directory:

```bash
cd DL
```

Create a Python virtual environment:

```bash
python -m venv venv
```

Activate it on Windows:

```powershell
venv\Scripts\activate
```

Install dependencies:

```bash
pip install -r requirements.txt
```

---

## 🤖 Training

The training pipeline can be used to preprocess the dataset, train the EfficientNet model, and evaluate its performance.

Training data and generated model weights are intentionally excluded from the Git repository.

Example:

```bash
python training/train.py
```

> Training commands may change as the deep learning pipeline is updated.

---

## 🔮 Prediction API

The Python API exposes the trained model for image prediction.

Example:

```bash
python -m uvicorn api.predict_api:app --reload --port 8001
```

The API receives a skin lesion image and returns the predicted class and associated prediction information.

The Laravel backend communicates with this API to integrate the deep learning model into the application.

---

## 📦 Files Not Included in Git

Large datasets and trained models are excluded from the repository.

These include:

* HAM10000 images
* Processed images
* Segmentation masks
* Extracted feature datasets
* Trained model weights
* Checkpoints
* Python virtual environments
* Laravel dependencies
* Node.js dependencies

See `.gitignore` for the complete list.

---

## 🎯 Project Goals

The main goals of the project are:

* Build a complete skin lesion classification pipeline.
* Investigate deep learning approaches for skin lesion classification.
* Improve classification performance across the seven HAM10000 classes.
* Develop a lightweight prediction API.
* Integrate the AI model with a Laravel backend.
* Create a complete application capable of receiving an image and returning an AI-based prediction.

---
