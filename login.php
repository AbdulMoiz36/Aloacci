<?php
include "header.php";
?>

<div class="bg-gray-100 flex items-center justify-center py-24">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
    <h2 class="text-2xl font-semibold text-center mb-6">Login</h2>

    <form>
      <!-- Email Input -->
      <div class="mb-4">
        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
        <input type="email" name="l_email" id="l_email"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
          placeholder="Enter your email" />
        <p class="help-block" id="l_email_error" style="padding:0 0.5rem 0;color:red;"></p>
      </div>

      <!-- Password Input -->
      <div class="mb-6">
        <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
        <input type="password" name="l_password" id="l_password"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
          placeholder="Enter your password" />
        <p class="help-block" id="l_password_error" style="padding:0 0.5rem 0;color:red;"></p>
      </div>

      <!-- Submit Button -->
      <div class="mb-4">
        <button type="button" onclick="user_login()" class="w-full bg-amber-500 text-white py-2 px-4 rounded-md hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-400">
          Login
        </button>
      </div>
      <div class="login_msg text-center" style="padding-bottom:1rem">
        <p style="color:red"><b></b></p>
      </div>
    </form>

    <!-- Create Account -->
    <p class="text-sm text-center text-gray-600">
      Don't have an account? <br>
      <a href="register.php" class="text-amber-500 hover:underline"><b>Create Account</b></a>
    </p>
  </div>
</div>
<?php
include "footer.php";
?>