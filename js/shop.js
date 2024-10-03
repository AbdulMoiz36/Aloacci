// Side Menu toggle on Small devices
document.getElementById('filter-btn').addEventListener('click', function() {
    // Show the filter div by moving it into view
    document.getElementById('filters').classList.remove('-translate-x-full');
});

document.getElementById('close-filter').addEventListener('click', function() {
    // Hide the filter div by moving it out of view
    document.getElementById('filters').classList.add('-translate-x-full');
});



// Side Menu Dropdown 
document.getElementById('dropdown-gender-btn').addEventListener('click', function() {
    const dropdownContent = document.getElementById('dropdown-gender-content');
    dropdownContent.classList.toggle('hidden');
    
});

document.getElementById('dropdown-genre-btn').addEventListener('click', function() {
    const dropdownContent = document.getElementById('dropdown-genre-content');
    dropdownContent.classList.toggle('hidden');
    
});


// // Toggle checkbox selection
// const toggleCheckbox = (checkboxId) => {
//     const checkbox = document.getElementById(checkboxId);
//     checkbox.checked = !checkbox.checked; // Toggle selection
// };

// // Update selected values based on checkboxes with data-name attribute
// const updateSelectedValues = () => {
//     const checkboxes = document.querySelectorAll('input[type="checkbox"]');
//     const selectedValuesDiv = document.getElementById('selected-values');
//     selectedValuesDiv.innerHTML = '';

//     checkboxes.forEach(checkbox => {
//         if (checkbox.checked) {
//             const dataName = checkbox.getAttribute('data-name'); // Get the data-name attribute
//             const valueDiv = document.createElement('div');
//             valueDiv.className = 'bg-amber-400 rounded-full py-1 px-2 font-semibold flex items-center';
//             valueDiv.innerHTML = `<span class="mr-2 cursor-pointer"><i class="fa-solid fa-xmark"></i></span> ${dataName}`; // Use data-name as the label

//             valueDiv.querySelector('.fa-xmark').addEventListener('click', () => {
//                 checkbox.checked = false;
//                 updateSelectedValues(); // Re-trigger the update when deselecting
//             });

//             selectedValuesDiv.appendChild(valueDiv); // Add the selected value to the div
//         }
//     });
// };

// // Add event listeners for checkboxes to update the selected values
// document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
//     checkbox.addEventListener('change', updateSelectedValues);
// });



