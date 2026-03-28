(function () {
    var toggle   = document.getElementById('menu-toggle');
    var sidebar  = document.getElementById('mobile-menu');
    var overlay  = document.getElementById('sidebar-overlay');
    var closeBtn = document.getElementById('sidebar-close');

    function openSidebar() {
        if (!sidebar) return;
        sidebar.classList.add('active');
        if (overlay) overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        if (!sidebar) return;
        sidebar.classList.remove('active');
        if (overlay) overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (toggle)   toggle.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (overlay)  overlay.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeSidebar();
    });
}());
