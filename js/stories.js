const videoModal = document.getElementById("video-modal");
const modalVideo = document.getElementById("modal-video");
const videoTitle = document.getElementById("video-title");
const videoDescription = document.getElementById("video-description");

document.querySelectorAll(".play-button").forEach((button) => {
  button.addEventListener("click", (e) => {
    const card = e.target.closest(".group");
    const videoSrc = card.dataset.videoSrc;
    const title = card.querySelector("h3").textContent;
    const description = card.querySelector("p").textContent;

    modalVideo.src = videoSrc;
    videoTitle.textContent = title;
    videoDescription.textContent = description;

    videoModal.classList.remove("hidden");
    document.body.classList.add("overflow-hidden");
    modalVideo.play();
  });
});

document.getElementById("close-modal").addEventListener("click", () => {
  videoModal.classList.add("hidden");
  document.body.classList.remove("overflow-hidden");
  modalVideo.pause();
});

videoModal.addEventListener("click", (e) => {
  if (e.target === videoModal) {
    videoModal.classList.add("hidden");
    document.body.classList.remove("overflow-hidden");
    modalVideo.pause();
  }
});
