<?php
include "header.php";
?>

<div class="bg-gray-100 flex items-center justify-center py-24">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
    <h2 class="text-2xl font-semibold text-center mb-6">Create Account</h2>

    <form>
      <!-- First Name Input -->
      <div class="mb-4">
        <label for="first-name" class="block text-gray-700 font-medium mb-2">First Name</label>
        <input
          type="text"
          id="first-name"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
          placeholder="Enter your first name"
          required
        />
      </div>

      <!-- Last Name Input -->
      <div class="mb-4">
        <label for="last-name" class="block text-gray-700 font-medium mb-2">Last Name</label>
        <input
          type="text"
          id="last-name"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
          placeholder="Enter your last name"
          required
        />
      </div>

      <!-- Email Input -->
      <div class="mb-4">
        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
        <input
          type="email"
          id="email"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
          placeholder="Enter your email"
          required
        />
      </div>

      <!-- Password Input -->
      <div class="mb-6">
        <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
        <input
          type="password"
          id="password"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
          placeholder="Create a password"
          required
        />
      </div>

      <!-- Submit Button -->
      <div class="mb-4">
        <button
          type="submit"
          class="w-full bg-amber-500 text-white py-2 px-4 rounded-md hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-400"
        >
          Create Account
        </button>
      </div>
    </form>

    <!-- Login Link -->
    <p class="text-sm text-center text-gray-600">
      Already have an account?
      <a href="login.php" class="text-amber-500 hover:underline"><b>Login</b></a>
    </p>
  </div>
</div>

<?php
include "footer.php";
?>
