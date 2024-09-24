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
document.getElementById('dropdown-btn').addEventListener('click', function() {
    const dropdownContent = document.getElementById('dropdown-content');
    const dropdownIcon = document.getElementById('dropdown-icon');

    // Toggle visibility
    if (dropdownContent.classList.contains('hidden')) {
        dropdownContent.classList.remove('hidden'); // Show dropdown
        dropdownIcon.classList.remove('fa-angle-up');
        dropdownIcon.classList.add('fa-angle-down');
    } else {
        dropdownContent.classList.add('hidden'); // Hide dropdown
        dropdownIcon.classList.remove('fa-angle-down');
        dropdownIcon.classList.add('fa-angle-up');
    }
});

// Toggle checkbox selection
const toggleCheckbox = (checkboxId) => {
    const checkbox = document.getElementById(checkboxId);
    checkbox.checked = !checkbox.checked; // Toggle selection
};

// Update selected categories
const updateSelectedValues = () => {
    // Get all checkboxes
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const selectedValuesDiv = document.getElementById('selected-values');

    // Clear the current contents of the div
    selectedValuesDiv.innerHTML = '';

    // Loop through the checkboxes
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            // Create a new div for each selected value
            const valueDiv = document.createElement('div');
            valueDiv.className = 'bg-amber-400 rounded-full py-1 px-2 font-semibold flex items-center';
            valueDiv.innerHTML = `<span class="mr-2 cursor-pointer"><i class="fa-solid fa-xmark"></i></span> ${checkbox.value}`;
            
            // Add a click event to remove the selected item
            valueDiv.querySelector('.fa-xmark').addEventListener('click', () => {
                checkbox.checked = false;
                updateSelectedValues(); // Update the selected values again after removing
            });

            // Append the new value to the selected values div
            selectedValuesDiv.appendChild(valueDiv);
        }
    });
};
