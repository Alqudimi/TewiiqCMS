<?php $this->layout('layouts/app', ['title' => $title]) ?>

<style>
.create-reel-container {
    max-width: 600px;
    margin: 2rem auto;
    padding: 2rem;
}

.create-card {
    background-color: var(--card);
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    padding: 2rem;
}

.video-upload-area {
    border: 3px dashed var(--border);
    border-radius: var(--border-radius);
    padding: 3rem;
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
    margin-bottom: 1.5rem;
}

.video-upload-area:hover {
    border-color: var(--primary);
    background-color: var(--input);
}

.video-upload-area.dragover {
    border-color: var(--primary);
    background-color: var(--input);
}

.upload-icon {
    font-size: 3rem;
    color: var(--primary);
    margin-bottom: 1rem;
}

.video-preview {
    width: 100%;
    max-height: 400px;
    border-radius: var(--border-radius);
    margin-bottom: 1rem;
}

.form-floating label {
    color: var(--text);
}

.hashtag-suggestions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.hashtag-btn {
    background-color: var(--input);
    border: 1px solid var(--border);
    color: var(--text);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: var(--transition);
}

.hashtag-btn:hover, .hashtag-btn.active {
    background-color: var(--primary);
    color: white;
    border-color: var(--primary);
}

.progress-container {
    display: none;
    margin-top: 1rem;
}

.upload-progress {
    height: 8px;
    background-color: var(--input);
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(45deg, var(--primary), var(--accent));
    border-radius: 4px;
    transition: width 0.3s ease;
}
</style>

<div class="create-reel-container">
    <div class="create-card">
        <div class="d-flex align-items-center mb-4">
            <a href="/reels" class="btn btn-outline-secondary me-3">
                <i class="bi bi-arrow-right"></i>
            </a>
            <h2 class="mb-0">إنشاء ريل جديد</h2>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" id="reelForm">
            <!-- Video Upload Area -->
            <div class="video-upload-area" id="uploadArea">
                <i class="bi bi-camera-video upload-icon"></i>
                <h4>اسحب الفيديو هنا أو انقر للاختيار</h4>
                <p class="text-muted">يدعم MP4, MOV, AVI (حد أقصى: 100 ميجابايت، 60 ثانية)</p>
                <input type="file" name="video" accept="video/*" class="d-none" id="videoInput" required>
            </div>

            <!-- Video Preview -->
            <div id="videoPreview" style="display: none;">
                <video class="video-preview" controls id="previewVideo"></video>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="removeVideo()">
                    <i class="bi bi-trash"></i> إزالة الفيديو
                </button>
            </div>

            <!-- Upload Progress -->
            <div class="progress-container" id="progressContainer">
                <div class="d-flex justify-content-between mb-2">
                    <span>جاري الرفع...</span>
                    <span id="progressText">0%</span>
                </div>
                <div class="upload-progress">
                    <div class="progress-bar" id="progressBar"></div>
                </div>
            </div>

            <!-- Form Fields -->
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="title" name="title" placeholder="عنوان الريل">
                        <label for="title">عنوان الريل (اختياري)</label>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="form-floating">
                        <textarea class="form-control" id="description" name="description" 
                                  style="height: 120px" placeholder="وصف الريل"></textarea>
                        <label for="description">وصف الريل</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="music_title" name="music_title" 
                               placeholder="عنوان الموسيقى" value="Original Audio">
                        <label for="music_title">عنوان الموسيقى</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="music_artist" name="music_artist" 
                               placeholder="اسم الفنان">
                        <label for="music_artist">اسم الفنان (اختياري)</label>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">الهاشتاجات الشائعة:</label>
                    <div class="hashtag-suggestions">
                        <button type="button" class="hashtag-btn" data-hashtag="#تويق">#تويق</button>
                        <button type="button" class="hashtag-btn" data-hashtag="#ريلز">#ريلز</button>
                        <button type="button" class="hashtag-btn" data-hashtag="#فيديو">#فيديو</button>
                        <button type="button" class="hashtag-btn" data-hashtag="#إبداع">#إبداع</button>
                        <button type="button" class="hashtag-btn" data-hashtag="#تصوير">#تصوير</button>
                        <button type="button" class="hashtag-btn" data-hashtag="#ترفيه">#ترفيه</button>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="hashtags" name="hashtags" 
                               placeholder="الهاشتاجات">
                        <label for="hashtags">الهاشتاجات (مفصولة بمسافات)</label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='/reels'">
                    إلغاء
                </button>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="bi bi-camera-video me-2"></i>
                    نشر الريل
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const uploadArea = document.getElementById('uploadArea');
const videoInput = document.getElementById('videoInput');
const videoPreview = document.getElementById('videoPreview');
const previewVideo = document.getElementById('previewVideo');
const form = document.getElementById('reelForm');
const submitBtn = document.getElementById('submitBtn');
const progressContainer = document.getElementById('progressContainer');

// Upload area click handler
uploadArea.addEventListener('click', () => videoInput.click());

// Drag and drop handlers
uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('dragover');
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('dragover');
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0 && files[0].type.startsWith('video/')) {
        videoInput.files = files;
        handleVideoSelect(files[0]);
    }
});

// Video input change handler
videoInput.addEventListener('change', (e) => {
    if (e.target.files.length > 0) {
        handleVideoSelect(e.target.files[0]);
    }
});

function handleVideoSelect(file) {
    // Validate file size (100MB max)
    if (file.size > 100 * 1024 * 1024) {
        alert('حجم الملف كبير جداً. الحد الأقصى 100 ميجابايت.');
        return;
    }
    
    // Show preview
    const url = URL.createObjectURL(file);
    previewVideo.src = url;
    
    uploadArea.style.display = 'none';
    videoPreview.style.display = 'block';
    
    // Check video duration
    previewVideo.addEventListener('loadedmetadata', () => {
        if (previewVideo.duration > 60) {
            alert('مدة الفيديو طويلة جداً. الحد الأقصى 60 ثانية.');
            removeVideo();
        }
    });
}

function removeVideo() {
    videoInput.value = '';
    previewVideo.src = '';
    uploadArea.style.display = 'block';
    videoPreview.style.display = 'none';
}

// Hashtag suggestions
document.querySelectorAll('.hashtag-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const hashtag = btn.dataset.hashtag;
        const hashtagsInput = document.getElementById('hashtags');
        const currentValue = hashtagsInput.value;
        
        if (currentValue.includes(hashtag)) {
            // Remove hashtag
            hashtagsInput.value = currentValue.replace(hashtag, '').replace(/\s+/g, ' ').trim();
            btn.classList.remove('active');
        } else {
            // Add hashtag
            hashtagsInput.value = currentValue ? currentValue + ' ' + hashtag : hashtag;
            btn.classList.add('active');
        }
    });
});

// Form submission with progress
form.addEventListener('submit', (e) => {
    e.preventDefault();
    
    if (!videoInput.files.length) {
        alert('يرجى اختيار ملف فيديو');
        return;
    }
    
    const formData = new FormData(form);
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>جاري الرفع...';
    progressContainer.style.display = 'block';
    
    // Simulate progress (in real app, use XMLHttpRequest for real progress)
    let progress = 0;
    const progressInterval = setInterval(() => {
        progress += Math.random() * 15;
        if (progress > 95) progress = 95;
        
        document.getElementById('progressBar').style.width = progress + '%';
        document.getElementById('progressText').textContent = Math.round(progress) + '%';
    }, 300);
    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        clearInterval(progressInterval);
        document.getElementById('progressBar').style.width = '100%';
        document.getElementById('progressText').textContent = '100%';
        
        if (response.ok) {
            window.location.reload();
        } else {
            throw new Error('Upload failed');
        }
    })
    .catch(error => {
        clearInterval(progressInterval);
        alert('حدث خطأ أثناء رفع الفيديو');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-camera-video me-2"></i>نشر الريل';
        progressContainer.style.display = 'none';
    });
});
</script>