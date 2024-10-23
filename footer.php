<footer class="bg-black text-white py-10">
  <div class=" mx-auto px-5 lg:px-20">

    <!-- Grid Layout for Footer -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

      <!-- Column 1: Logo Section -->
      <div class="mb-6 md:mb-0 flex justify-center">
        <img src="./img/logo.png" alt="Company Logo" class="w-2/4 md:w-3/4 lg:w-2/4 mb-4">
      </div>

      <!-- Column 2: About Section -->
      <div class="mb-6 md:mb-0">
        <h3 class="text-lg font-semibold mb-4">About Us</h3>
        <p class="text-sm">
          We are a leading company dedicated to providing the best products and services in the industry. Stay connected with us for the latest updates and offers.
        </p>
      </div>

      <!-- Column 3: Quick Links -->
      <div class="mb-6 md:mb-0">
        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
        <ul class="space-y-2 text-sm">
          <li><a href="index" class="hover:text-amber-500">Home</a></li>
          <li><a href="shop" class="hover:text-amber-500">Shop</a></li>
          <li><a href="about" class="hover:text-amber-500">About Us</a></li>
          <li><a href="contact" class="hover:text-amber-500">Contact</a></li>
          <li class="hover:text-amber-500 hover:cursor-pointer" onclick="openTrackModal()">Track Your Order</li>
        </ul>
      </div>

      <!-- Modal -->
      <div id="orderModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-8">
          <h2 class="text-2xl font-bold mb-4 text-black">Track Your Order</h2>

          <!-- Error message -->
          <p id="errorMessage" class="text-red-500 text-sm mb-4 hidden">No orders found for this ID and phone number.</p>

          <!-- Input fields -->
          <div class="mb-4">
            <label for="orderId" class="block text-sm font-bold text-gray-700 text-left">Order ID:</label>
            <input type="text" id="orderId" class="block text-black border w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm" placeholder="Enter your order ID">
          </div>

          <div class="mb-4">
            <label for="phoneNumber" class="block text-sm font-bold text-gray-700 text-left">Phone Number</label>
            <input type="text" id="phoneNumber" class="block text-black w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm" maxlength="11" placeholder="Enter your 11-digit phone number">
          </div>

          <!-- Modal actions -->
          <div class="flex justify-end">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2" onclick="closeTrackModal()">Cancel</button>
            <button type="button" class="bg-amber-600 text-white px-4 py-2 rounded-md" onclick="submitOrder()">Track</button>
          </div>
        </div>
      </div>

      <script>
        // Function to open the modal
        function openTrackModal() {
          document.getElementById('orderModal').classList.remove('hidden');
          document.getElementById('orderModal').classList.add('flex');
        }

        // Function to close the modal
        function closeTrackModal() {
          document.getElementById('orderModal').classList.add('hidden');
        }

        function submitOrder() {
          const orderId = document.getElementById('orderId').value;
          const phoneNumber = document.getElementById('phoneNumber').value;
          const errorMessage = document.getElementById('errorMessage');

          // Clear any previous errors
          errorMessage.classList.add('hidden');

          // Validate inputs
          if (orderId.trim() === '' || phoneNumber.trim() === '') {
            errorMessage.textContent = 'Both fields are required.';
            errorMessage.classList.remove('hidden');
            return;
          }

          // Send AJAX request to PHP script
          const xhr = new XMLHttpRequest();
          xhr.open('POST', 'track_order.php', true);
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              const response = JSON.parse(xhr.responseText);
              if (response.success) {
                // Redirect to order details page
                window.location.href = `order_details.php?id=${response.order_id}`;
              } else {
                // Show error message
                errorMessage.textContent = 'No orders found for this ID and phone number.';
                errorMessage.classList.remove('hidden');
              }
            }
          };
          xhr.send(`orderId=${orderId}&phoneNumber=${phoneNumber}`);
        }

        // Toggle dropdown on click
        function toggleDropdown() {
          const dropdownMenu = document.getElementById('contactDropdownMenu');
          dropdownMenu.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
          const dropdownMenu = document.getElementById('contactDropdownMenu');
          const toggleButton = document.getElementById('contactDropdownToggle');
          if (!toggleButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
          }
        });
      </script>
      

      <!-- Column 4: Social Links -->
      <div class="mb-6 md:mb-0">
        <h3 class="text-lg font-semibold mb-4">Follow Us</h3>
        <div class="flex md:ml-5 space-x-4">
          <a href="https://www.facebook.com/aloacci" class="text-white hover:text-amber-500"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.instagram.com/aloacci/" class="text-white hover:text-amber-500"><i class="fab fa-instagram"></i></a>
          <!-- <a href="https://www.threads.net/@owaisgadit17" class="text-white hover:text-amber-500"><i class="fa-brands fa-threads"></i></a> -->
        </div>
      </div>

    </div>

    <!-- Footer Bottom Line -->
    <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm">
      <p>&copy; 2024 Al-Oacci. All rights reserved.</p>
    </div>
  </div>
</footer>
<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Sweet Alert -->
<!-- Custom -->
<!-- scripts -->
<script src="./js/script.js" defer></script>
<script src="./js/shop.js" defer></script>
<script src="./js/custom.js" defer></script>
<!-- toaster -->
<script src="./admin/assets/bundles/izitoast/js/iziToast.min.js" defer></script>
<script src="./admin/assets/js/page/toastr.js" defer></script>
</body>

</html>