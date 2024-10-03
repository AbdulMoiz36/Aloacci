// // Side Menu toggle on Small devices
// document.getElementById('filter-btn').addEventListener('click', function() {
//     // Show the filter div by moving it into view
//     document.getElementById('filters').classList.remove('-translate-x-full');
// });

// document.getElementById('close-filter').addEventListener('click', function() {
//     // Hide the filter div by moving it out of view
//     document.getElementById('filters').classList.add('-translate-x-full');
// });


// Side Menu Dropdown 
document.getElementById('dropdown-gender-btn').addEventListener('click', function() {
    const dropdownContent = document.getElementById('dropdown-gender-content');
    const dropdownIcon = document.getElementById('dropdown-gender-icon');
    dropdownContent.classList.toggle('hidden');
    dropdownIcon.classList.toggle('fa-angle-down');
    dropdownIcon.classList.toggle('fa-angle-up');
});

document.getElementById('dropdown-genre-btn').addEventListener('click', function() {
    const dropdownContent = document.getElementById('dropdown-genre-content');
    const dropdownIcon = document.getElementById('dropdown-genre-icon');
    dropdownContent.classList.toggle('hidden');
    dropdownIcon.classList.toggle('fa-angle-down');
    dropdownIcon.classList.toggle('fa-angle-up');
});

document.getElementById('dropdown-type-btn').addEventListener('click', function() {
    const dropdownContent = document.getElementById('dropdown-type-content');
    const dropdownIcon = document.getElementById('dropdown-type-icon');
    dropdownContent.classList.toggle('hidden');
    dropdownIcon.classList.toggle('fa-angle-down');
    dropdownIcon.classList.toggle('fa-angle-up');
});

document.getElementById('dropdown-season-btn').addEventListener('click', function() {
    const dropdownContent = document.getElementById('dropdown-season-content');
    const dropdownIcon = document.getElementById('dropdown-season-icon');
    dropdownContent.classList.toggle('hidden');
    dropdownIcon.classList.toggle('fa-angle-down');
    dropdownIcon.classList.toggle('fa-angle-up');
});

document.getElementById('dropdown-sillage-btn').addEventListener('click', function() {
    const dropdownContent = document.getElementById('dropdown-sillage-content');
    const dropdownIcon = document.getElementById('dropdown-sillage-icon');
    dropdownContent.classList.toggle('hidden');
    dropdownIcon.classList.toggle('fa-angle-down');
    dropdownIcon.classList.toggle('fa-angle-up');
});

document.getElementById('dropdown-lasting-btn').addEventListener('click', function() {
    const dropdownContent = document.getElementById('dropdown-lasting-content');
    const dropdownIcon = document.getElementById('dropdown-lasting-icon');
    dropdownContent.classList.toggle('hidden');
    dropdownIcon.classList.toggle('fa-angle-down');
    dropdownIcon.classList.toggle('fa-angle-up');
});


// // Toggle checkbox selection
// const toggleCheckbox = (checkboxId) => {
//     const checkbox = document.getElementById(checkboxId);
//     checkbox.checked = !checkbox.checked; // Toggle selection
// };

// // Update selected categories
// const updateSelectedValues = () => {
//     const checkboxes = document.querySelectorAll('input[type="checkbox"]');
//     const selectedValuesDiv = document.getElementById('selected-values');
//     selectedValuesDiv.innerHTML = '';

//     checkboxes.forEach(checkbox => {
//         if (checkbox.checked) {
//             const label = checkbox.parentNode.textContent.trim();
//             const valueDiv = document.createElement('div');
//             valueDiv.className = 'bg-amber-400 rounded-full py-1 px-2 font-semibold flex items-center';
//             valueDiv.innerHTML = `<span class="mr-2 cursor-pointer"><i class="fa-solid fa-xmark"></i></span> ${label}`;
            
//             valueDiv.querySelector('.fa-xmark').addEventListener('click', () => {
//                 checkbox.checked = false;
//                 updateSelectedValues();
//             });

//             selectedValuesDiv.appendChild(valueDiv);
//         }
//     });
// };


