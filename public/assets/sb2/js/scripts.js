let $virtualSelect;

window.addEventListener("DOMContentLoaded", (event) => {
    // Activate feather
    feather.replace();

    // Enable tooltips globally
    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Enable popovers globally
    var popoverTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="popover"]')
    );
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector("#sidebarToggle");
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sidenav-toggled');
        // }
        sidebarToggle.addEventListener("click", (event) => {
            event.preventDefault();
            document.body.classList.toggle("sidenav-toggled");
            localStorage.setItem(
                "sb|sidebar-toggle",
                document.body.classList.contains("sidenav-toggled")
            );
        });
    }

    // Close side navigation when width < LG
    const sidenavContent = document.body.querySelector(
        "#layoutSidenav_content"
    );
    if (sidenavContent) {
        sidenavContent.addEventListener("click", (event) => {
            const BOOTSTRAP_LG_WIDTH = 992;
            if (window.innerWidth >= 992) {
                return;
            }
            if (document.body.classList.contains("sidenav-toggled")) {
                document.body.classList.toggle("sidenav-toggled");
            }
        });
    }

    // Add active state to sidbar nav links
    let activatedPath = window.location.pathname.match(/([\w-]+\.html)/, "$1");

    if (activatedPath) {
        activatedPath = activatedPath[0];
    } else {
        activatedPath = "index.html";
    }

    const targetAnchors = document.body.querySelectorAll(
        '[href="' + activatedPath + '"].nav-link'
    );

    targetAnchors.forEach((targetAnchor) => {
        let parentNode = targetAnchor.parentNode;
        while (parentNode !== null && parentNode !== document.documentElement) {
            if (parentNode.classList.contains("collapse")) {
                parentNode.classList.add("show");
                const parentNavLink = document.body.querySelector(
                    '[data-bs-target="#' + parentNode.id + '"]'
                );
                parentNavLink.classList.remove("collapsed");
                parentNavLink.classList.add("active");
            }
            parentNode = parentNode.parentNode;
        }
        targetAnchor.classList.add("active");
    });
});

/*! * custom scripts for this template */

function getStatusBadge(status) {
    if (!status || typeof status !== 'string') return "";

    const normalized = status.trim().toLowerCase();
    let badgeClass = "bg-secondary";
    let textColor = "text-white";

    switch (normalized) {
        case "new":
            badgeClass = "bg-primary";
            break;

        case "contacted":
            badgeClass = "bg-info";
            break;

        case "follow up":
        case "follow-up":
        case "follow-up needed":
            badgeClass = "bg-warning";
            textColor = "text-dark";
            break;

        case "qualified":
            badgeClass = "bg-teal"; // Custom teal class
            break;

        case "converted":
            badgeClass = "bg-success";
            break;

        case "interested":
            badgeClass = "bg-indigo"; // Custom indigo class
            break;

        case "active":
            badgeClass = "bg-success";
            break;

        case "completed":
            badgeClass = "bg-primary";
            break;

        case "not interested":
            badgeClass = "bg-dark";
            break;

        case "no response":
            badgeClass = "bg-warning";
            textColor = "text-dark";
            break;

        case "lost":
            badgeClass = "bg-danger";
            break;

        case "failed":
            badgeClass = "bg-red";
            break;

        case "expired":
            badgeClass = "bg-light";
            textColor = "text-dark";
            break;

        case "pending":
            badgeClass = "bg-warning";
            break;

        case "hold":
            badgeClass = "bg-orange"; // Custom orange class (add in your CSS)
            break;

        case "call":
            badgeClass = "bg-primary";
            break;

        case "email":
            badgeClass = "bg-info";
            break;

        case "proposal":
            badgeClass = "bg-warning";
            textColor = "text-dark";
            break;

        case "meeting":
            badgeClass = "bg-success";
            break;

        case "paid":
            badgeClass = "bg-success";
            break;

        case "unpaid":
            badgeClass = "bg-danger";
            break;

        case "cancelled":
        case "canceled":
            badgeClass = "bg-dark";
            break;

        default:
            badgeClass = "bg-dark";
            textColor = "text-white";
    }

    const displayText = status
        .trim()
        .toLowerCase()
        .replace(/\w\S*/g, (w) => w.charAt(0).toUpperCase() + w.slice(1));

    return `<div class="text-start"><span class="badge ${badgeClass} ${textColor} rounded-pill">${displayText}</span></div>`;
}


// Initialize VirtalSelect
$virtualSelect = VirtualSelect.init({
    ele: ".virtualSelect",
    search: true,
    searchPlaceholder: "Search",
    noOptionsText: "Not found",
    noResultsText: "No results found",
    maxHeight: 300,
    selectedValue: null,
});

// $virtualSelect.forEach(select => select.$ele.setValue(''));

// Brothers and Sisters logic
$("#brothers").on("change", function () {
    let number = parseInt($(this).val());
    let $wrapper = $(".married_brothers");
    let $select = $("#married_brothers");

    if (isNaN(number) || number <= 0) {
        $wrapper.addClass("d-none");
        $select
            .empty()
            .append('<option value="" selected disabled>-- Select --</option>');
    } else {
        let options =
            '<option value="" selected disabled>-- Select --</option>';
        for (let i = 0; i <= number; i++) {
            options += `<option value="${i}">${i}</option>`;
        }
        $select.empty().append(options);
        $wrapper.removeClass("d-none");
    }
});

$("#sisters").on("change", function () {
    let number = parseInt($(this).val());
    let $wrapper = $(".married_sisters");
    let $select = $("#married_sisters");

    if (isNaN(number) || number <= 0) {
        $wrapper.addClass("d-none");
        $select
            .empty()
            .append('<option value="" selected disabled>-- Select --</option>');
    } else {
        let options =
            '<option value="" selected disabled>-- Select --</option>';
        for (let i = 0; i <= number; i++) {
            options += `<option value="${i}">${i}</option>`;
        }
        $select.empty().append(options);
        $wrapper.removeClass("d-none");
    }
});

function truncateWords(text, wordLimit = 3 ) {
    const words = text.trim().split(/\s+/);
    if (words.length <= wordLimit) return text;
    return words.slice(0, wordLimit).join(" ") + "...";
}

$(document).on('click', '.copy-link-btn', function () {
    const link = $(this).data('link');
    navigator.clipboard.writeText(link)
        .then(() => {
             showSuccessToast("Success!", "Link copied to clipboard!");
        })
        .catch(() => {
                showDangerToast("Error!", "Failed to copy link.");
        });
});


document.addEventListener('DOMContentLoaded', function () {
    const limits = {
        govt_id: [],
        photo: []
    };

    const maxLimit = 5;

    function handleUpload(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);

        input.addEventListener('change', function () {
            const files = Array.from(input.files);

            if (limits[inputId].length + files.length > maxLimit) {
                showDangerToast("Error!", `You can upload a maximum of ${maxLimit} files.`);
                return;
            }

            files.forEach(file => {
                // Allow images and PDFs for govt_id, images only for photo
                const validTypes = inputId === 'govt_id' 
                    ? ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf']
                    : ['image/jpeg', 'image/png', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    showDangerToast("Error!", `Invalid file type for ${file.name}.`);
                    return;
                }

                limits[inputId].push({ file, dataURL: null });
                const reader = new FileReader();
                reader.onload = function (e) {
                    limits[inputId].find(item => item.file === file).dataURL = e.target.result;
                    renderPreview(inputId, preview, limits[inputId]);
                };
                // Generate dataURL only for images (not PDFs)
                if (file.type.startsWith('image/')) {
                    reader.readAsDataURL(file);
                } else {
                    // For PDFs, use a placeholder or skip preview
                    renderPreview(inputId, preview, limits[inputId]);
                }
            });

            // Do NOT clear input: input.value = '';
            updateFileInput(inputId, input);
        });
    }

    function renderPreview(inputId, container, items) {
        container.innerHTML = '';
        items.forEach((item, index) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'preview-container';

            if (item.dataURL && item.file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = item.dataURL;
                wrapper.appendChild(img);
            } else {
                // Placeholder for non-image files (e.g., PDFs)
                const placeholder = document.createElement('div');
                placeholder.textContent = item.file.name;
                placeholder.style.textAlign = 'center';
                placeholder.style.fontSize = '12px';
                wrapper.appendChild(placeholder);
            }

            const delBtn = document.createElement('span');
            delBtn.className = 'delete-icon';
            delBtn.innerHTML = '&times;';
            delBtn.addEventListener('click', () => {
                limits[inputId].splice(index, 1);
                renderPreview(inputId, container, limits[inputId]);
                updateFileInput(inputId, document.getElementById(inputId));
            });

            wrapper.appendChild(delBtn);
            container.appendChild(wrapper);
        });
    }

    function updateFileInput(inputId, input) {
        // Rebuild the file list for the input
        const dataTransfer = new DataTransfer();
        limits[inputId].forEach(item => dataTransfer.items.add(item.file));
        input.files = dataTransfer.files;
    }

    handleUpload('govt_id', 'preview-govt');
    handleUpload('photo', 'preview-photo');
});