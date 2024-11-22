import './bootstrap';

document.addEventListener("DOMContentLoaded", function() {
    const spinner = document.getElementById("loading-spinner");

    // Show spinner before page unload
    window.addEventListener('beforeunload', function() {
        spinner.classList.remove('hidden');
    });

    // Optionally, hide the spinner once the new page is loaded
    window.addEventListener('load', function() {
        spinner.classList.add('hidden');
    });

    // Show spinner on form submission
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function() {
            spinner.classList.remove('hidden');
        });
    });

    // Show spinner on link clicks
    document.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', function(event) {
            // Optionally, check if the link is external or should trigger a page load
            // For example, skip links with target="_blank" or href="#"
            const href = link.getAttribute('href');
            if (href && !href.startsWith('#') && !link.hasAttribute('target')) {
                spinner.classList.remove('hidden');
            }
        });
    });
});



// start: Sidebar
const sidebarToggle = document.querySelector('.sidebar-toggle')
const sidebarOverlay = document.querySelector('.sidebar-overlay')
const sidebarMenu = document.querySelector('.sidebar-menu')
const main = document.querySelector('.main')
if(window.innerWidth < 768) {
    main.classList.toggle('active')   
    sidebarOverlay.classList.toggle('hidden')
    sidebarMenu.classList.toggle('-translate-x-full')
}
sidebarToggle.addEventListener('click', function (e) {
    e.preventDefault()
    main.classList.toggle('active')   
    sidebarOverlay.classList.toggle('hidden')
    sidebarMenu.classList.toggle('-translate-x-full')
})
sidebarOverlay.addEventListener('click', function (e) {
    e.preventDefault()
    main.classList.add('active')
    sidebarOverlay.classList.add('hidden')
    sidebarMenu.classList.add('-translate-x-full')
})

// end: Sidebar

 // start: Popper
 document.addEventListener('DOMContentLoaded', function () {
    const popperInstance = {};
    document.querySelectorAll('.dropdown').forEach(function (item, index) {
        const popperId = 'popper-' + index;
        const toggle = item.querySelector('.dropdown-toggle');
        const menu = item.querySelector('.dropdown-menu');
        
        if (menu) {  // Check if the menu exists
            menu.dataset.popperId = popperId;
            popperInstance[popperId] = Popper.createPopper(toggle, menu, {
                modifiers: [
                    {
                        name: 'offset',
                        options: {
                            offset: [0, 8],
                        },
                    },
                    {
                        name: 'preventOverflow',
                        options: {
                            padding: 24,
                        },
                    },
                ],
                placement: 'bottom-end'
            });
        }
    });

    document.addEventListener('click', function (e) {
        const toggle = e.target.closest('.dropdown-toggle');
        const menu = e.target.closest('.dropdown-menu');
        if (toggle) {
            const menuEl = toggle.closest('.dropdown').querySelector('.dropdown-menu');
            const popperId = menuEl.dataset.popperId;
            if (menuEl.classList.contains('hidden')) {
                hideDropdown();
                menuEl.classList.remove('hidden');
                showPopper(popperId);
            } else {
                menuEl.classList.add('hidden');
                hidePopper(popperId);
            }
        } else if (!menu) {
            hideDropdown();
        }
    });

    function hideDropdown() {
        document.querySelectorAll('.dropdown-menu').forEach(function (item) {
            item.classList.add('hidden');
        });
    }

    function showPopper(popperId) {
        popperInstance[popperId].setOptions(function (options) {
            return {
                ...options,
                modifiers: [
                    ...options.modifiers,
                    { name: 'eventListeners', enabled: true },
                ],
            };
        });
        popperInstance[popperId].update();
    }

    function hidePopper(popperId) {
        popperInstance[popperId].setOptions(function (options) {
            return {
                ...options,
                modifiers: [
                    ...options.modifiers,
                    { name: 'eventListeners', enabled: false },
                ],
            };
        });
    }
});

// end: Popper
  




 
