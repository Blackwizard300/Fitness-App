// Age controls
const ageValue = document.querySelector(".age-value");
const increaseAge = document.querySelector(".increase");
const decreaseAge = document.querySelector(".decrease");

let currentAge = 19;

increaseAge.addEventListener("click", () => {
  if (currentAge < 100) {
    currentAge++;
    ageValue.textContent = currentAge;
  }
});

decreaseAge.addEventListener("click", () => {
  if (currentAge > 1) {
    currentAge--;
    ageValue.textContent = currentAge;
  }
});

// Weight slider
const slider = document.querySelector(".slider-handle");
const sliderProgress = document.querySelector(".slider-progress");
const weightValue = document.querySelector(".weight-value");
const weightSelector = document.querySelector(".weight-selector");

let isDragging = false;
let startX;
let sliderLeft;

function updateSlider(e) {
  if (!isDragging) return;

  e.preventDefault();
  const x = e.type === "touchmove" ? e.touches[0].clientX : e.clientX;
  const walk = x - startX;
  let newLeft = sliderLeft + walk;

  // Calculate boundaries
  const sliderRect = weightSelector.getBoundingClientRect();
  const minLeft = 171; // Minimum left position
  const maxLeft = sliderRect.width - 53; // Maximum left position

  // Constrain the slider within boundaries
  newLeft = Math.max(minLeft, Math.min(maxLeft, newLeft));

  // Update slider position
  slider.style.left = `${newLeft}px`;
  sliderProgress.style.right = `${sliderRect.width - newLeft}px`;

  // Calculate and update weight value (assuming 30-150kg range)
  const range = maxLeft - minLeft;
  const percentage = (newLeft - minLeft) / range;
  const weight = Math.round(30 + percentage * 120);
  weightValue.textContent = weight;
}

slider.addEventListener("mousedown", (e) => {
  isDragging = true;
  startX = e.clientX;
  sliderLeft = parseInt(getComputedStyle(slider).left);
  document.addEventListener("mousemove", updateSlider);
  document.addEventListener("mouseup", () => {
    isDragging = false;
    document.removeEventListener("mousemove", updateSlider);
  });
});

// Touch events for mobile
slider.addEventListener("touchstart", (e) => {
  isDragging = true;
  startX = e.touches[0].clientX;
  sliderLeft = parseInt(getComputedStyle(slider).left);
  document.addEventListener("touchmove", updateSlider);
  document.addEventListener("touchend", () => {
    isDragging = false;
    document.removeEventListener("touchmove", updateSlider);
  });
});

// Gender selection
const genderOptions = document.querySelectorAll(".gender-option");

genderOptions.forEach((option) => {
  option.addEventListener("click", () => {
    const gender = option.dataset.gender;
    // Remove selected class from all options
    genderOptions.forEach((opt) => {
      opt.classList.remove("selected");
      opt.setAttribute("aria-selected", "false");
    });
    // Add selected class to clicked option
    option.classList.add("selected");
    option.setAttribute("aria-selected", "true");

    // Add ripple effect
    const ripple = document.createElement("div");
    ripple.classList.add("ripple");
    option.appendChild(ripple);

    // Remove ripple after animation
    setTimeout(() => {
      ripple.remove();
    }, 1000);
  });
});
