document.addEventListener('DOMContentLoaded', () => {
    const steps = [
        {
        selector: '.regular p:first-child',
        message: 'Welcome! If you are a new student enrolling for the first time, click here to begin your Freshmen application.',
        },
        {
        selector: '.regular a:nth-child(2) p',
        message: 'Previously enrolled at another school? Select this to apply as a Transferee.',
        },
        {
        selector: '.regular a:nth-child(3) p',
        message: 'Returning after a break from Oxford Academe? This is the Returnee application.',
        },
        {
        selector: '.regular a:nth-child(4) p',
        message: 'For students who didn’t follow the regular curriculum sequence, choose this Non-Sequential option.',
        }
    ];

let currentStep = 0;
const tooltip = document.getElementById('onboarding-tooltip');
const text = document.getElementById('onboarding-text');
const overlay = document.getElementById('onboarding-overlay');

function showStep(index) {
    const step = steps[index];
    const target = document.querySelector(step.selector);
    if (!target) return;

    const rect = target.getBoundingClientRect();
    tooltip.style.top = `${rect.bottom + window.scrollY + 10}px`;
    tooltip.style.left = `${rect.left + window.scrollX}px`;
    text.textContent = step.message;
}

document.getElementById('onboarding-next').addEventListener('click', () => {
    currentStep++;
    if (currentStep >= steps.length) {
    overlay.style.display = 'none';
    } else {
    showStep(currentStep);
    }
});

overlay.style.display = 'block';
showStep(currentStep);
});
 const data = {
    "Cavite": {
        "Bacoor": "4102",
        "Dasmariñas": "4114",
        "Imus": "4103",
        "Tagaytay": "4120",
        "Tanza": "4108",
        "Trece Martires": "4109"
    },
    "Laguna": {
        "Calamba": "4027",
        "San Pablo": "4000",
        "Santa Rosa": "4026",
        "Biñan": "4024",
        "Los Baños": "4030"
    },
    "Batangas": {
        "Batangas City": "4200",
        "Lipa": "4217",
        "Tanauan": "4232"
    }
};

const provinceSelect = document.getElementById("province");
const citySelect = document.getElementById("city");
const zipInput = document.getElementById("zip-code");

// Populate provinces
Object.keys(data).forEach(province => {
    const option = document.createElement("option");
    option.value = province;
    option.textContent = province;
    provinceSelect.appendChild(option);
});

// When province changes
provinceSelect.addEventListener("change", function () {
    const selectedProvince = this.value;

    // Clear city and zip
    citySelect.innerHTML = '<option value="">Select a city</option>';
    zipInput.value = "";

    if (selectedProvince && data[selectedProvince]) {
    Object.keys(data[selectedProvince]).forEach(city => {
        const option = document.createElement("option");
        option.value = city;
        option.textContent = city;
        citySelect.appendChild(option);
    });
    }
});

// When city changes
citySelect.addEventListener("change", function () {
    const selectedCity = this.value;
    const selectedProvince = provinceSelect.value;

    if (data[selectedProvince] && data[selectedProvince][selectedCity]) {
    zipInput.value = data[selectedProvince][selectedCity];
    } else {
    zipInput.value = "";
    }
});

function handlePreview(inputId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(`preview-${inputId}`);
  
    input.addEventListener("change", function () {
      const file = this.files[0];
      if (!file) return;
  
      const fileType = file.type;
      const fileSizeMB = file.size / (1024 * 1024);
      preview.innerHTML = "";
  
      if (fileSizeMB > 5) {
        preview.innerHTML = "<p style='color:red;'>File exceeds 5MB.</p>";
        return;
      }
  
      const clickable = document.createElement("a");
      clickable.href = "#";
      clickable.textContent = file.name;
      clickable.style.color = "#007bff";
      clickable.style.textDecoration = "underline";
  
      clickable.onclick = function (e) {
        e.preventDefault();
        showPreview(file);
      };
  
      preview.appendChild(clickable);
    });
  }
  
  function showPreview(file) {
    const modal = document.getElementById("file-preview-modal");
    const content = document.getElementById("file-preview-content");
    content.innerHTML = "";
  
    const fileType = file.type;
  
    if (fileType.startsWith("image/")) {
      const img = document.createElement("img");
      img.src = URL.createObjectURL(file);
      img.style.maxWidth = "100%";
      img.style.maxHeight = "80vh";
      content.appendChild(img);
    } else if (fileType === "application/pdf") {
      const iframe = document.createElement("iframe");
      iframe.src = URL.createObjectURL(file);
      iframe.style.width = "80vw";
      iframe.style.height = "80vh";
      iframe.style.border = "none";
      content.appendChild(iframe);
    } else {
      content.innerHTML = "<p style='color:white;'>Preview not supported for this file type.</p>";
    }
  
    modal.style.display = "flex";
  }
  
  function closePreview() {
    document.getElementById("file-preview-modal").style.display = "none";
  }
  
  handlePreview("form-137");
  handlePreview("form-138");
  handlePreview("picture");