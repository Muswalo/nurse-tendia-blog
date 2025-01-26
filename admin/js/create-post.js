const fileInput = document.getElementById("image");
const dropRegion = document.getElementById("drop-region");
const previewContainer = document.getElementById("image-preview");
const removeButton = document.getElementById("remove-image");
const previewImage = previewContainer.querySelector("img");
const form = document.getElementById("form");
const submitButton = document.getElementById("submit");
const title = document.getElementById("title");
const featured = document.getElementById("featured");
const author = document.getElementById("author");
// Handle file selection
fileInput.addEventListener("change", handleFileSelect);
dropRegion.addEventListener("click", () => fileInput.click());

function handleFileSelect(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      previewImage.src = e.target.result;
      previewContainer.classList.remove("hidden");
      dropRegion.classList.add("hidden");
    };
    reader.readAsDataURL(file);
  }
}

// Handle image removal
removeButton.addEventListener("click", () => {
    removeImage();
});

dropRegion.addEventListener("dragover", (e) => {
  e.preventDefault();
  dropRegion.classList.add("border-purple-500", "bg-purple-100");
});

dropRegion.addEventListener("dragleave", () => {
  dropRegion.classList.remove("border-purple-500", "bg-purple-100");
});

dropRegion.addEventListener("drop", (e) => {
  e.preventDefault();
  dropRegion.classList.remove("border-purple-500", "bg-purple-100");
  const file = e.dataTransfer.files[0];

  if (file && file.type.startsWith("image/")) {
    const reader = new FileReader();
    reader.onload = (e) => {
      previewImage.src = e.target.result;
      previewContainer.classList.remove("hidden");
      dropRegion.classList.add("hidden");
    };

    reader.readAsDataURL(file);
    fileInput.files = e.dataTransfer.files;
  } else {
    showToast("Please upload an image.", "error");
  }
});


form.addEventListener("submit", async (event) => {
  event.preventDefault();
  submitButton.disabled = true;
  submitButton.classList.add("cursor-not-allowed", "opacity-50");
  submitButton.innerText = "Creating post...";

  try {
    const titleValue = title.value.trim();
    const contentValue = quill.root.innerHTML;
    const MAX_FILE_SIZE_MB = 5;
    const authorValue = author.value.trim();

    if (!titleValue) {
      showToast("Title is required.", "error");
      resetSubmitButton();
      return;
    }

    if (!authorValue) {
      showToast("Author is required.", "error");
      resetSubmitButton();
      return;
    }

    if (!contentValue) {
      showToast("Content cannot be empty.", "error");
      resetSubmitButton();
      return;
    }

    if (fileInput.files.length > 0) {
      const file = fileInput.files[0];
      if (file.size > MAX_FILE_SIZE_MB * 1024 * 1024) {
        showToast(
          `Image size must be less than ${MAX_FILE_SIZE_MB}MB.`,
          "error"
        );
        resetSubmitButton();
        return;
      }
    }
    const formData = new FormData();
    formData.append("title", titleValue);
    formData.append("author", authorValue);
    formData.append("content", contentValue);
    formData.append("featured", featured.checked ? 1 : 0);

    if (fileInput.files.length > 0) {
      formData.append("image", fileInput.files[0]);
    }

    const response = await fetch("/admin/write-post-to-db.php", {
      method: "POST",
      body: formData,
    });

    const result = await response.json();

    if (response.ok) {
      showToast("Post created successfully!", "success");
      form.reset();
      quill.root.innerHTML = "";
      removeImage();
    } else {
      showToast(result.message || "An error occurred.", "error");
    }
  } catch (error) {
    showToast("Failed to create post. Please try again.", "error");
  } finally {
    resetSubmitButton();
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

function removeImage () {
    fileInput.value = "";
    previewImage.src = "";
    previewContainer.classList.add("hidden");
    dropRegion.classList.remove("hidden");  
}