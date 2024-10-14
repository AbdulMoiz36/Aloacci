<?php
include "header.php";
?>

<div class="bg-gray-100 flex items-center justify-center py-24">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
    <h2 class="text-2xl font-semibold text-center mb-6">Create Account</h2>

    <form>
      <!-- First Name Input -->
      <div class="mb-4">
        <label for="Name" class="block text-gray-700 font-medium mb-2">Name</label>
        <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
          placeholder="Enter your name"/>
          <p class="help-block text-danger" id="name_error" style="padding:0 0.5rem 0;color:red;"></p>
      </div>

      <!-- Email Input -->
      <div class="mb-4">
        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
        <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
          placeholder="Enter your email"/>
          <p class="help-block text-danger" id="email_error" style="padding:0 0.5rem 0;color:red;"></p>
      </div>

      <!-- Mobile Input -->
      <div class="mb-4">
        <label for="text" class="block text-gray-700 font-medium mb-2">Moblie</label>
        <input type="text" name="mobile" id="mobile" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
          placeholder="Enter your Mobile"/>
          <p class="help-block text-danger" id="mobile_error" style="padding:0 0.5rem 0;color:red;"></p>
      </div>

      <!-- Password Input -->
      <div class="mb-6">
        <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
        <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
          placeholder="Create a password"/>
          <p class="help-block text-danger" id="password_error" style="padding:0 0.5rem 0;color:red;"></p>
      </div>

      <!-- Password Input -->
      <div class="mb-6">
        <label for="password" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
        <input type="password" name="c_password" id="c_password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
          placeholder="Confirm password"/>
          <p class="help-block text-danger" id="c_password_error" style="padding:0 0.5rem 0;color:red;"></p>
      </div>

      <!-- Submit Button -->
      <div class="mb-4">
        <button type="button" onclick="user_register()" class="w-full bg-amber-500 text-white py-2 px-4 rounded-md hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-400">
          Create Account
        </button>
      </div>
    </form>

    <!-- Login Link -->
    <p class="text-sm text-center text-gray-600">
      Already have an account?
      <a href="login" class="text-amber-500 hover:underline"><b>Login</b></a>
    </p>
  </div>
</div>

<?php
include "footer.php";
?>