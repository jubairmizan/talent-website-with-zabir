@extends('layouts.landing')

@section('title', 'Register - Curaçao Talents')

@section('content')
  <div class="min-h-screen flex items-center justify-center p-6" style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);">
    <!-- Background shapes -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute top-20 left-20 w-32 h-40 rounded-2xl transform rotate-12" style="background: linear-gradient(135deg, rgba(106, 10, 252, 0.6) 0%, rgba(181, 53, 255, 0.6) 100%);"></div>
      <div class="absolute top-40 right-32 w-24 h-24 rounded-full" style="background: linear-gradient(135deg, rgba(106, 10, 252, 0.6) 0%, rgba(181, 53, 255, 0.6) 100%);"></div>
      <div class="absolute bottom-32 left-40 w-20 h-28 rounded-xl transform -rotate-12" style="background: linear-gradient(135deg, rgba(181, 53, 255, 0.6) 0%, rgba(106, 10, 252, 0.6) 100%);"></div>
    </div>

    <div class="w-full max-w-md bg-white/95 backdrop-blur-sm shadow-2xl relative z-10 rounded-lg border border-border">
      <div class="p-6 border-b border-border text-center">
        <div class="w-16 h-16 mx-auto mb-4">
          <img src="{{ asset('images/brug-logo.png') }}" alt="Brug Kreativo" class="w-full h-full object-contain">
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Join Curaçao Talents</h2>
        <p class="text-gray-600">Create your account and start your journey</p>
      </div>

      <div class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
        <!-- Success Message -->
        @if (session('status'))
          <div class="rounded-md bg-green-50 p-4 border border-green-200">
            <div class="flex">
              <div class="flex-shrink-0">
                <i data-lucide="check-circle" class="h-5 w-5 text-green-400"></i>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-green-800">
                  {{ session('status') }}
                </p>
              </div>
            </div>
          </div>
        @endif

        <!-- General Error Messages -->
        @if ($errors->any())
          <div class="rounded-md bg-red-50 p-4 border border-red-200">
            <div class="flex">
              <div class="flex-shrink-0">
                <i data-lucide="alert-circle" class="h-5 w-5 text-red-400"></i>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">
                  Please correct the following errors:
                </h3>
                <div class="mt-2 text-sm text-red-700">
                  <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
          </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4" id="registerForm" enctype="multipart/form-data">
          @csrf

          <!-- Role Selection -->
          <div class="space-y-2">
            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Choose Your Role</label>
            <div class="grid grid-cols-2 gap-3">
              <div class="role-option border-2 border-gray-200 rounded-md p-3 cursor-pointer hover:border-pink-500 transition-colors" data-role="talent">
                <div class="text-center">
                  <i data-lucide="palette" class="w-6 h-6 mx-auto mb-1 text-pink-500"></i>
                  <h3 class="text-sm font-semibold text-gray-900">Talent</h3>
                  <p class="text-xs text-gray-600">Showcase skills</p>
                </div>
              </div>
              <div class="role-option border-2 border-gray-200 rounded-md p-3 cursor-pointer hover:border-pink-500 transition-colors" data-role="client">
                <div class="text-center">
                  <i data-lucide="briefcase" class="w-6 h-6 mx-auto mb-1 text-pink-500"></i>
                  <h3 class="text-sm font-semibold text-gray-900">Client</h3>
                  <p class="text-xs text-gray-600">Find creators</p>
                </div>
              </div>
            </div>
            <input type="hidden" name="role" id="role" value="" required>
            @error('role')
              <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Name -->
          <div class="space-y-2">
            <label for="name" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Full Name</label>
            <input id="name" name="name" type="text" autocomplete="name" required
              class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 @error('name') border-red-500 @enderror"
              placeholder="Enter your full name" value="{{ old('name') }}">
            @error('name')
              <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Email -->
          <div class="space-y-2">
            <label for="email" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Email Address</label>
            <input id="email" name="email" type="email" autocomplete="email" required
              class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 @error('email') border-red-500 @enderror"
              placeholder="Enter your email" value="{{ old('email') }}">
            @error('email')
              <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Password -->
          <div class="space-y-2">
            <label for="password" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Password</label>
            <div class="relative">
              <input id="password" name="password" type="password" autocomplete="new-password" required
                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 pr-10 @error('password') border-red-500 @enderror"
                placeholder="Create a password">
              <button type="button" class="absolute right-0 top-0 h-full px-3 py-2 hover:bg-transparent text-gray-500 hover:text-gray-700" onclick="togglePassword('password')">
                <i data-lucide="eye" id="password-eye-icon" class="h-4 w-4"></i>
                <i data-lucide="eye-off" id="password-eye-off-icon" class="h-4 w-4 hidden"></i>
              </button>
            </div>
            @error('password')
              <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Confirm Password -->
          <div class="space-y-2">
            <label for="password_confirmation" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Confirm Password</label>
            <div class="relative">
              <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 pr-10 @error('password_confirmation') border-red-500 @enderror"
                placeholder="Confirm your password">
              <button type="button" class="absolute right-0 top-0 h-full px-3 py-2 hover:bg-transparent text-gray-500 hover:text-gray-700" onclick="togglePassword('password_confirmation')">
                <i data-lucide="eye" id="confirm-password-eye-icon" class="h-4 w-4"></i>
                <i data-lucide="eye-off" id="confirm-password-eye-off-icon" class="h-4 w-4 hidden"></i>
              </button>
            </div>
            @error('password_confirmation')
              <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Creator-specific fields (shown only when talent is selected) -->
          <div id="creator-fields" class="space-y-4 hidden">
            <div class="border-t pt-4">
              <h3 class="text-sm font-semibold text-gray-900 mb-3">Creator Profile Information</h3>

              <!-- Short Bio -->
              <div class="space-y-2">
                <label for="short_bio" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Short Bio</label>
                <textarea id="short_bio" name="short_bio" rows="3"
                  class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none"
                  placeholder="Brief description of your talents and skills..." value="{{ old('short_bio') }}"></textarea>
                @error('short_bio')
                  <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Profile Picture -->
              <div class="space-y-2">
                <label for="avatar" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Profile Picture (Optional)</label>
                <input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/jpg,image/gif"
                  class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                <p class="text-xs text-gray-500">Max size: 2MB. Formats: JPG, PNG, GIF</p>
                @error('avatar')
                  <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Banner Image -->
              <div class="space-y-2">
                <label for="banner_image" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Banner Image (Optional)</label>
                <input id="banner_image" name="banner_image" type="file" accept="image/jpeg,image/png,image/jpg,image/gif"
                  class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                <p class="text-xs text-gray-500">Max size: 5MB. Formats: JPG, PNG, GIF</p>
                @error('banner_image')
                  <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Website URL -->
              <div class="space-y-2">
                <label for="website_url" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Website URL (Optional)</label>
                <input id="website_url" name="website_url" type="url"
                  class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                  placeholder="https://your-portfolio.com" value="{{ old('website_url') }}">
                @error('website_url')
                  <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Social Media Links -->
              <div class="space-y-3">
                <label class="text-sm font-medium leading-none">Social Media (Optional)</label>
                <p class="text-xs text-gray-500">Add your social media profiles to help clients find and connect with you</p>

                <div class="grid grid-cols-2 gap-3">
                  <!-- Instagram -->
                  <div class="space-y-1">
                    <label for="instagram_url" class="text-xs text-gray-600">Instagram</label>
                    <input id="instagram_url" name="instagram_url" type="url"
                      class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                      placeholder="@username" value="{{ old('instagram_url') }}">
                  </div>

                  <!-- Facebook -->
                  <div class="space-y-1">
                    <label for="facebook_url" class="text-xs text-gray-600">Facebook</label>
                    <input id="facebook_url" name="facebook_url" type="url"
                      class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                      placeholder="Facebook URL" value="{{ old('facebook_url') }}">
                  </div>

                  <!-- LinkedIn -->
                  <div class="space-y-1">
                    <label for="linkedin_url" class="text-xs text-gray-600">LinkedIn</label>
                    <input id="linkedin_url" name="linkedin_url" type="url"
                      class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                      placeholder="LinkedIn URL" value="{{ old('linkedin_url') }}">
                  </div>

                  <!-- YouTube -->
                  <div class="space-y-1">
                    <label for="youtube_url" class="text-xs text-gray-600">YouTube</label>
                    <input id="youtube_url" name="youtube_url" type="url"
                      class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                      placeholder="YouTube URL" value="{{ old('youtube_url') }}">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Member-specific fields (shown only when client is selected) -->
          <div id="member-fields" class="space-y-4 hidden">
            <div class="border-t pt-4">
              <h3 class="text-sm font-semibold text-gray-900 mb-3">Client Profile Information</h3>

              <!-- First Name -->
              <div class="space-y-2">
                <label for="first_name" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">First Name</label>
                <input id="first_name" name="first_name" type="text"
                  class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                  placeholder="Enter your first name" value="{{ old('first_name') }}">
                @error('first_name')
                  <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Last Name -->
              <div class="space-y-2">
                <label for="last_name" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Last Name</label>
                <input id="last_name" name="last_name" type="text"
                  class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                  placeholder="Enter your last name" value="{{ old('last_name') }}">
                @error('last_name')
                  <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Location -->
              <div class="space-y-2">
                <label for="location" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Location (Optional)</label>
                <input id="location" name="location" type="text"
                  class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                  placeholder="City, Country" value="{{ old('location') }}">
                @error('location')
                  <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Bio -->
              <div class="space-y-2">
                <label for="member_bio" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Bio (Optional)</label>
                <textarea id="member_bio" name="member_bio" rows="3"
                  class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none"
                  placeholder="Tell us about yourself and what kind of talents you're looking for..." value="{{ old('member_bio') }}"></textarea>
                @error('member_bio')
                  <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Interests -->
              <div class="space-y-2">
                <label for="interests" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Interests (Optional)</label>
                <input id="interests" name="interests" type="text"
                  class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                  placeholder="e.g., Photography, Music, Art, Design" value="{{ old('interests') }}">
                @error('interests')
                  <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>

          <!-- Terms and Privacy -->
          <div class="flex items-start space-x-2">
            <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded mt-0.5">
            <label for="terms" class="text-sm text-gray-700 leading-5">
              I agree to the
              <a href="#" class="text-pink-600 hover:text-pink-500 underline">Terms of Service</a>
              and
              <a href="#" class="text-pink-600 hover:text-pink-500 underline">Privacy Policy</a>
            </label>
          </div>

          <!-- Submit Button -->
          <button type="submit"
            class="w-full inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-white h-10 px-4 py-2"
            style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);" onmouseover="this.style.background='#6A0AFC'" onmouseout="this.style.background='linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%)'" id="registerBtn">
            <span id="registerBtnText">Create Account</span>
            <div id="registerBtnSpinner" class="hidden ml-2">
              <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
            </div>
          </button>
        </form>

        <!-- Login Link -->
        <div class="text-center">
          <p class="text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium text-pink-600 hover:text-pink-500 underline">
              Sign in here
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Role selection functionality
    document.addEventListener('DOMContentLoaded', function() {
      const roleOptions = document.querySelectorAll('.role-option');
      const roleInput = document.getElementById('role');

      // Function to show/hide role-specific fields
      function toggleCreatorFields(role) {
        const creatorFields = document.getElementById('creator-fields');
        const memberFields = document.getElementById('member-fields');
        const shortBioField = document.getElementById('short_bio');
        const firstNameField = document.getElementById('first_name');
        const lastNameField = document.getElementById('last_name');

        if (role === 'talent') {
          creatorFields.classList.remove('hidden');
          memberFields.classList.add('hidden');
          // Make short_bio required for creators
          shortBioField.setAttribute('required', 'required');
          // Remove required attributes for member fields
          firstNameField.removeAttribute('required');
          lastNameField.removeAttribute('required');
        } else if (role === 'client') {
          memberFields.classList.remove('hidden');
          creatorFields.classList.add('hidden');
          // Make member fields required
          firstNameField.setAttribute('required', 'required');
          lastNameField.setAttribute('required', 'required');
          // Remove required attribute for creator fields
          shortBioField.removeAttribute('required');
        } else {
          creatorFields.classList.add('hidden');
          memberFields.classList.add('hidden');
          // Remove all required attributes
          shortBioField.removeAttribute('required');
          firstNameField.removeAttribute('required');
          lastNameField.removeAttribute('required');
        }
      }

      // Check if role is pre-selected from URL parameter
      const urlParams = new URLSearchParams(window.location.search);
      const preselectedRole = urlParams.get('role');

      if (preselectedRole) {
        roleInput.value = preselectedRole;
        const preselectedOption = document.querySelector(`[data-role="${preselectedRole}"]`);
        if (preselectedOption) {
          preselectedOption.classList.add('border-pink-500', 'bg-pink-50');
        }
        // Trigger field toggle for preselected role
        toggleCreatorFields(preselectedRole);
      }

      roleOptions.forEach(option => {
        option.addEventListener('click', function() {
          // Remove selected class from all options
          roleOptions.forEach(opt => opt.classList.remove('border-pink-500', 'bg-pink-50'));

          // Add selected class to clicked option
          this.classList.add('border-pink-500', 'bg-pink-50');

          // Set the role value
          roleInput.value = this.dataset.role;

          // Show/hide creator-specific fields
          toggleCreatorFields(this.dataset.role);
        });
      });



      // Form submission
      const form = document.getElementById('registerForm');
      const submitBtn = document.getElementById('registerBtn');
      const submitBtnText = document.getElementById('registerBtnText');
      const submitBtnSpinner = document.getElementById('registerBtnSpinner');

      form.addEventListener('submit', function(e) {
        // Clear any previous error alerts
        const existingAlerts = document.querySelectorAll('.js-validation-alert');
        existingAlerts.forEach(alert => alert.remove());

        // Validation
        if (!roleInput.value) {
          e.preventDefault();
          showValidationError('Please select a role (Talent or Client)');
          return;
        }

        // Validate creator-specific fields if talent is selected
        if (roleInput.value === 'talent') {
          const shortBio = document.getElementById('short_bio').value.trim();
          if (!shortBio) {
            e.preventDefault();
            showValidationError('Short bio is required for creators');
            return;
          }
        }

        // Show loading state
        submitBtn.disabled = true;
        submitBtnText.textContent = 'Creating Account...';
        submitBtnSpinner.classList.remove('hidden');

        // Re-enable form after 10 seconds in case of network issues
        setTimeout(() => {
          if (submitBtn.disabled) {
            submitBtn.disabled = false;
            submitBtnText.textContent = 'Create Account';
            submitBtnSpinner.classList.add('hidden');
          }
        }, 10000);
      });

      // Function to show validation errors
      function showValidationError(message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'js-validation-alert rounded-md bg-red-50 p-4 border border-red-200 mb-4';
        alertDiv.innerHTML = `
          <div class="flex">
            <div class="flex-shrink-0">
              <i data-lucide="alert-circle" class="h-5 w-5 text-red-400"></i>
            </div>
            <div class="ml-3">
              <p class="text-sm font-medium text-red-800">${message}</p>
            </div>
          </div>
        `;

        // Insert before the form
        form.parentNode.insertBefore(alertDiv, form);

        // Initialize lucide icons for the new alert
        if (typeof lucide !== 'undefined') {
          lucide.createIcons();
        }

        // Scroll to top of form to show error
        alertDiv.scrollIntoView({
          behavior: 'smooth',
          block: 'center'
        });
      }
    });

    // Password toggle functionality
    function togglePassword(fieldId) {
      const field = document.getElementById(fieldId);
      const eyeIcon = document.getElementById(fieldId + '-eye-icon');
      const eyeOffIcon = document.getElementById(fieldId + '-eye-off-icon');

      if (field.type === 'password') {
        field.type = 'text';
        eyeIcon.classList.add('hidden');
        eyeOffIcon.classList.remove('hidden');
      } else {
        field.type = 'password';
        eyeIcon.classList.remove('hidden');
        eyeOffIcon.classList.add('hidden');
      }
    }
  </script>
@endsection
