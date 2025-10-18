// ===== Password Toggle =====
function togglePassword(fieldId, icon) {
  const input = document.getElementById(fieldId);
  if (input.type === "password") {
    input.type = "text";
    icon.textContent = "🙈";
  } else {
    input.type = "password";
    icon.textContent = "👁️";
  }
}

// ===== Form Toggle (Sign In / Sign Up Tabs) =====
const signInTab = document.getElementById("signInTab");
const signUpTab = document.getElementById("signUpTab");
const signInForm = document.getElementById("signInForm");
const signUpForm = document.getElementById("signUpForm");

if (signInTab && signUpTab && signInForm && signUpForm) {
  signInTab.addEventListener("click", () => {
    // Switch active tab
    signInTab.classList.add("active");
    signUpTab.classList.remove("active");

    // Show login, hide register
    signInForm.style.display = "block";
    signUpForm.style.display = "none";
  });

  signUpTab.addEventListener("click", () => {
    // Switch active tab
    signUpTab.classList.add("active");
    signInTab.classList.remove("active");

    // Show register, hide login
    signUpForm.style.display = "block";
    signInForm.style.display = "none";
  });
}

// ===== Optional Helper Function (if needed programmatically) =====
function showForm(tabName) {
  if (!signInForm || !signUpForm) return;

  if (tabName === 'signIn') {
    signInForm.style.display = 'block';
    signUpForm.style.display = 'none';
    signInTab.classList.add('active');
    signUpTab.classList.remove('active');
  } else if (tabName === 'signUp') {
    signUpForm.style.display = 'block';
    signInForm.style.display = 'none';
    signUpTab.classList.add('active');
    signInTab.classList.remove('active');
  }
}
// ===== ADMIN Form Toggle (Admin Login / Admin Sign Up) =====
const adminLoginTab = document.getElementById("adminLoginTab");
const adminSignUpTab = document.getElementById("adminSignUpTab");
const adminLoginForm = document.getElementById("adminLoginForm");
const adminSignUpForm = document.getElementById("adminSignUpForm");

if (adminLoginTab && adminSignUpTab && adminLoginForm && adminSignUpForm) {
  adminLoginTab.addEventListener("click", () => {
    adminLoginTab.classList.add("active");
    adminSignUpTab.classList.remove("active");
    adminLoginForm.style.display = "block";
    adminSignUpForm.style.display = "none";
  });

  adminSignUpTab.addEventListener("click", () => {
    adminSignUpTab.classList.add("active");
    adminLoginTab.classList.remove("active");
    adminSignUpForm.style.display = "block";
    adminLoginForm.style.display = "none";
  });
}

