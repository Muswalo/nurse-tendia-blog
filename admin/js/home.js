const toggleFeatured = async (postId, status) => {
  try {
    // Show a confirmation prompt before proceeding
    const userConfirmed = await showPrompt(
      `Are you sure you want to ${
        status ? "remove" : "add"
      } this post from featured?`,
      {
        confirmText: "Yes",
        cancelText: "No",
      }
    );

    // If the user cancels, exit the function
    if (!userConfirmed) {
      console.log("User canceled the action.");
      return;
    }
    const formData = new FormData();
    formData.append("postId", postId);
    formData.append("isFeatured", status ? 0 : 1);

    // Proceed with the toggle action
    const response = await fetch("/admin/featured_toggle.php", {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      throw new Error("Could not update the featured status");
    }

    const data = await response.json();

    // Update the button UI
    const button = document.getElementById(postId);
    if (status) {
      button.classList.remove("text-gray-400");
      button.classList.add("text-yellow-500");

      button.classList.remove("text-yellow-500");
      button.classList.add("text-gray-400");
    } else {
      button.classList.remove("text-yellow-500");
      button.classList.add("text-gray-400");
    }

    showToast(`${data.message}. Please reload the page to see updates.`);
  } catch (error) {
    console.log(error);
    showToast("An error occurred. Please try again.", "error");
  }
};

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
