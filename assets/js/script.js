/*!
    * Start Bootstrap - SB Admin v7.0.5 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2022 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
// 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});


function toggleEdit() {
    var displayInfo = document.getElementById('display-info');
    var editForm = document.getElementById('edit-form');
    var editBtn = document.getElementById('edit-btn');

    if (displayInfo.style.display === 'none') {
        // Switch to display mode
        displayInfo.style.display = 'block';
        editForm.style.display = 'none';
        editBtn.innerText = 'Edit';
    } else {
        // Switch to edit mode
        displayInfo.style.display = 'none';
        editForm.style.display = 'block';
        editBtn.innerText = 'Update';
    }
}
