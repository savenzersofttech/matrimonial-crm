
let  $virtualSelect;

    window.addEventListener('DOMContentLoaded', event => {
    // Activate feather
    feather.replace();

    // Enable tooltips globally
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Enable popovers globally
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sidenav-toggled'));
        });
    }

    // Close side navigation when width < LG
    const sidenavContent = document.body.querySelector('#layoutSidenav_content');
    if (sidenavContent) {
        sidenavContent.addEventListener('click', event => {
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
    let activatedPath = window.location.pathname.match(/([\w-]+\.html)/, '$1');

    if (activatedPath) {
        activatedPath = activatedPath[0];
    } else {
        activatedPath = 'index.html';
    }

    const targetAnchors = document.body.querySelectorAll('[href="' + activatedPath + '"].nav-link');

    targetAnchors.forEach(targetAnchor => {
        let parentNode = targetAnchor.parentNode;
        while (parentNode !== null && parentNode !== document.documentElement) {
            if (parentNode.classList.contains('collapse')) {
                parentNode.classList.add('show');
                const parentNavLink = document.body.querySelector(
                    '[data-bs-target="#' + parentNode.id + '"]'
                );
                parentNavLink.classList.remove('collapsed');
                parentNavLink.classList.add('active');
            }
            parentNode = parentNode.parentNode;
        }
        targetAnchor.classList.add('active');
    });
});




/*! * custom scripts for this template */

function getStatusBadge(status) {
    if (!status) return ''; // handle empty/null values

    const normalized = status.trim().toLowerCase();
    let badgeClass = 'bg-secondary';
    let textColor = 'text-white';

    switch (normalized) {
        case 'completed':
        case 'active':
        case 'interested':
            badgeClass = 'bg-success';
            break;
        case 'pending':
        case 'follow-up needed':
            badgeClass = 'bg-warning';
            textColor = 'text-dark';
            break;
        case 'failed':
        case 'expired':
            badgeClass = 'bg-danger';
            break;
        case 'not interested':
        case 'no response':
            badgeClass = 'bg-dark';
            break;
    }

    // Capitalize first letter of each word
    const displayText = status.replace(/\w\S*/g, w => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase());

    return `<div class="badge ${badgeClass} ${textColor} rounded-pill">${displayText}</div>`;
}

 // Initialize VirtalSelect
            $virtualSelect = VirtualSelect.init({
                ele: '.virtualSelect',
                search: true,
                searchPlaceholder: 'Search',
                noOptionsText: 'Not found',
                noResultsText: 'No results found',
                maxHeight: 300,
                selectedValue: null
            });

            // $virtualSelect.forEach(select => select.$ele.setValue(''));