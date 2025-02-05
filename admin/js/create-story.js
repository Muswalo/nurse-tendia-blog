// Video Upload Elements
const videoInput = document.getElementById("videoFile");
const videoDropRegion = document.getElementById("video-drop-region");
const videoPreviewContainer = document.getElementById("video-preview");
const removeVideoButton = document.getElementById("remove-video");
const videoPreviewElement = videoPreviewContainer.querySelector("video");
const videoForm = document.getElementById("videoForm");
const videoSubmitButton = videoForm.querySelector("button[type='submit']");
const videoTitle = document.getElementById("videoTitle");
const videoDescription = document.getElementById("videoDescription");

// Handle Video File Selection
videoInput.addEventListener("change", handleVideoSelect);
videoDropRegion.addEventListener("click", () => videoInput.click());

function handleVideoSelect(event) {
  const file = event.target.files[0];
  if (file && file.type.startsWith("video/")) {
    const url = URL.createObjectURL(file);
    videoPreviewElement.src = url;
    videoPreviewContainer.classList.remove("hidden");
    videoDropRegion.classList.add("hidden");
  } else {
    showToast("Please select a valid video file", "error");
  }
}

// Handle Video Removal
removeVideoButton.addEventListener("click", () => {
  videoInput.value = "";
  videoPreviewElement.src = "";
  videoPreviewContainer.classList.add("hidden");
  videoDropRegion.classList.remove("hidden");
});

// Drag & Drop Handlers for Video
videoDropRegion.addEventListener("dragover", (e) => {
  e.preventDefault();
  videoDropRegion.classList.add("border-purple-500", "bg-purple-100");
});

videoDropRegion.addEventListener("dragleave", () => {
  videoDropRegion.classList.remove("border-purple-500", "bg-purple-100");
});

videoDropRegion.addEventListener("drop", (e) => {
  e.preventDefault();
  videoDropRegion.classList.remove("border-purple-500", "bg-purple-100");
  const file = e.dataTransfer.files[0];

  if (file && file.type.startsWith("video/")) {
    const url = URL.createObjectURL(file);
    videoPreviewElement.src = url;
    videoPreviewContainer.classList.remove("hidden");
    videoDropRegion.classList.add("hidden");
    videoInput.files = e.dataTransfer.files;
  } else {
    showToast("Please upload a video file", "error");
  }
});

function updateProgress(percentage, message = "Uploading...") {
  const progressBar = document.getElementById("progress-bar");
  const progressPercentage = document.getElementById("progress-percentage");
  const uploadStatus = document.getElementById("upload-status");

  progressBar.style.width = `${percentage}%`;
  progressPercentage.textContent = `${Math.round(percentage)}%`;
  uploadStatus.textContent = message;
}

videoForm.addEventListener("submit", async (event) => {
  event.preventDefault();
  const uploadProgress = document.getElementById("upload-progress");
  const submitButton = videoForm.querySelector('button[type="submit"]');
  const uploadText = submitButton.querySelector(".upload-text");
  const spinner = submitButton.querySelector("svg");

  try {
    const titleValue = videoTitle.value.trim();
    const descriptionValue = videoDescription.value.trim();
    const MAX_VIDEO_SIZE_MB = 500;

    // Validation
    if (!titleValue) {
      showToast("Video title is required", "error");
      return;
    }

    if (!descriptionValue) {
      showToast("Description is required", "error");
      return;
    }

    if (!videoInput.files.length) {
      showToast("Please select a video file", "error");
      return;
    }

    const videoFile = videoInput.files[0];
    if (videoFile.size > MAX_VIDEO_SIZE_MB * 1024 * 1024) {
      showToast(`Video size must be less than ${MAX_VIDEO_SIZE_MB}MB`, "error");
      return;
    }

    uploadProgress.classList.remove("hidden");

    submitButton.disabled = true;
    uploadText.classList.add("opacity-0");
    spinner.classList.remove("hidden");

    // Load FFMPEG
    updateProgress(0, "Loading FFMPEG...");
    const { createFFmpeg, fetchFile } = FFmpeg;
    const ffmpeg = createFFmpeg({ log: true });
    await ffmpeg.load();

    updateProgress(0, "Generating thumbnail...");

    // Write the video file to ffmpeg FS
    ffmpeg.FS("writeFile", "input.mp4", await fetchFile(videoFile));

    // Extract thumbnail at 5 seconds
    const thumbnailTime = "00:00:05";
    await ffmpeg.run(
      "-ss",
      thumbnailTime,
      "-i",
      "input.mp4",
      "-frames:v",
      "1",
      "thumbnail.png"
    );
    const thumbData = ffmpeg.FS("readFile", "thumbnail.png");
    const thumbnailBlob = new Blob([thumbData.buffer], { type: "image/png" });

    const duration = videoPreviewElement.duration;

    const formData = new FormData();
    formData.append("videoFile", videoFile);
    formData.append("thumbnail", thumbnailBlob, "thumbnail.png");
    formData.append("title", videoTitle.value.trim());
    formData.append("description", videoDescription.value.trim());
    formData.append("duration", duration);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/admin/upload-video.php", true);

    xhr.upload.addEventListener("progress", (e) => {
      const percent = (e.loaded / e.total) * 100;
      updateProgress(percent, "Uploading video...");
    });

    xhr.addEventListener("loadstart", () => {
      updateProgress(0, "Starting upload...");
    });

    xhr.addEventListener("load", async () => {
      if (xhr.status >= 200 && xhr.status < 300) {
        updateProgress(100, "Processing video...");
        const result = JSON.parse(xhr.response);
        uploadProgress.classList.add("hidden");

        showToast("Video uploaded successfully", "success");
        videoForm.reset();
        videoPreviewElement.src = "";
      } else {
        throw new Error(xhr.statusText);
      }
    });

    xhr.addEventListener("error", () => {
      throw new Error("Upload failed");
    });

    xhr.send(formData);
  } catch (error) {
    updateProgress(0, "Upload failed");
    showToast(error.message, "error");
  } finally {
    submitButton.disabled = false;
    uploadText.classList.remove("opacity-0");
    spinner.classList.add("hidden");
  }
});

function showToast(message, type = "success") {
  const toast = document.createElement("div");
  toast.innerText = message;
  toast.className = `toast ${type}`;
  toast.style.position = "fixed";
  toast.style.top = "20px";
  toast.style.right = "20px";
  toast.style.padding = "20px 40px";
  toast.style.borderRadius = "10px";
  toast.style.backgroundColor = type === "success" ? "#4CAF50" : "#f44336";
  toast.style.color = "#fff";
  toast.style.fontSize = "18px";
  toast.style.boxShadow = "0 4px 8px rgba(0, 0, 0, 0.3)";
  toast.style.zIndex = "1000";

  document.body.appendChild(toast);

  setTimeout(() => {
    toast.remove();
  }, 10000);
}

function resetSubmitButton() {
  submitButton.disabled = false;
  submitButton.classList.remove("cursor-not-allowed", "opacity-50");
  submitButton.innerText = "Create Post";
}

function removeImage() {
  fileInput.value = "";
  previewImage.src = "";
  previewContainer.classList.add("hidden");
  dropRegion.classList.remove("hidden");
}
