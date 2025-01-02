document.addEventListener('DOMContentLoaded', function() {
    const submenuTrigger = document.querySelector('.submenu-trigger');
    const submenuContent = document.querySelector('.submenu-content');
    
    submenuTrigger.addEventListener('click', function(e) {
        e.preventDefault();
        submenuContent.style.display = submenuContent.style.display === 'block' ? 'none' : 'block';
        this.querySelector('.fa-chevron-down').style.transform = 
            submenuContent.style.display === 'block' ? 'rotate(180deg)' : 'rotate(0)';
    });
});