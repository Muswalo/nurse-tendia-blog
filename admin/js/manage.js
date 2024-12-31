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
const id = document.getElementById("id");

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

  const confirmation = await showPrompt(
    "Are you sure you want to update the post?",
    {
      confirmText: "Yes",
      cancelText: "No",
    }
  );

  if (confirmation === null) {
    return;
  }

  submitButton.disabled = true;
  submitButton.classList.add("cursor-not-allowed", "opacity-50");
  submitButton.innerText = "Updating post...";

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
    formData.append("id", id.value);
    formData.append("title", titleValue);
    formData.append("author", authorValue);
    formData.append("content", contentValue);
    formData.append("featured", featured.checked ? 1 : 0);

    if (fileInput.files.length > 0) {
      formData.append("image", fileInput.files[0]);
    }

    const response = await fetch("/admin/update_article.php", {
      method: "POST",
      body: formData,
    });

    const result = await response.json();

    if (response.ok) {
      showToast("Post updated successfully!", "success");
      window.location.reload();
    } else {
      showToast(result.message || "An error occurred.", "error");
    }
  } catch (error) {
    console.error(error);
    showToast("Failed to update post. Please try again.", "error");
  } finally {
    resetSubmitButton();
  }
});

async function handleDelete(id) {
  const confirmation = await showPrompt(
    "Are you sure you want to delete this post?",
    {
      confirmText: "Yes",
      cancelText: "No",
    }
  );

  if (confirmation === null) {
    return;
  }

  const icon = document.getElementById("icon");

  icon.innerHTML = `
      <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
    `;

    const formData = new FormData ();
    formData.append("id", id);
  try {
    const response = await fetch("/admin/delete.php", {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      throw new Error("Failed to delete the post");
    }

    const result = await response.json();
    showToast("Post deleted succesfully, redirecting in 3 second");
    setTimeout(() => {
      window.location.href = "/admin/articles";
    }, 3000);
  } catch (error) {
    console.log(error)
    showToast(error, "error");
    icon.innerHTML =
      '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 mr-2"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>';
  }
}

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
  submitButton.innerText = "Save changes";
}

function removeImage() {
  fileInput.value = "";
  previewImage.src = "";
  previewContainer.classList.add("hidden");
  dropRegion.classList.remove("hidden");
}

function showPrompt(message, options = {}) {
  return new Promise((resolve) => {
    const overlay = document.createElement("div");
    overlay.className = "custom-prompt-overlay";
    overlay.style.position = "fixed";
    overlay.style.top = "0";
    overlay.style.left = "0";
    overlay.style.width = "100%";
    overlay.style.height = "100%";
    overlay.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
    overlay.style.display = "flex";
    overlay.style.justifyContent = "center";
    overlay.style.alignItems = "center";
    overlay.style.zIndex = "1000";

    const promptBox = document.createElement("div");
    promptBox.className = "custom-prompt-box";
    promptBox.style.backgroundColor = "#fff";
    promptBox.style.padding = "20px";
    promptBox.style.borderRadius = "8px";
    promptBox.style.boxShadow = "0 4px 8px rgba(0, 0, 0, 0.2)";

    const messageElement = document.createElement("p");
    messageElement.className = "text-gray-700 mb-8";
    messageElement.style.textAlign = "center";
    messageElement.textContent = message;

    const inputContainer = document.createElement("div");
    const buttonsContainer = document.createElement("div");

    let inputElement = null;

    if (options.input) {
      inputElement = document.createElement("input");
      inputElement.type = options.input.type || "text";
      inputElement.placeholder = options.input.placeholder || "";
      inputElement.className = "border rounded p-2 mb-4 w-full";
      inputContainer.appendChild(inputElement);
    }

    const confirmButton = document.createElement("button");
    confirmButton.textContent = options.confirmText || "OK";
    confirmButton.className =
      "bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4";
    confirmButton.addEventListener("click", () => {
      const inputValue = inputElement ? inputElement.value : true;
      resolve(inputValue);
      overlay.remove();
    });

    buttonsContainer.appendChild(confirmButton);

    if (options.cancelText) {
      const cancelButton = document.createElement("button");
      cancelButton.textContent = options.cancelText || "Cancel";
      cancelButton.className =
        "bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded";
      cancelButton.addEventListener("click", () => {
        resolve(null);
        overlay.remove();
      });
      buttonsContainer.appendChild(cancelButton);
    }

    promptBox.appendChild(messageElement);
    promptBox.appendChild(inputContainer);
    promptBox.appendChild(buttonsContainer);
    overlay.appendChild(promptBox);
    document.body.appendChild(overlay);

    if (inputElement) {
      inputElement.focus();
    }
  });
}
