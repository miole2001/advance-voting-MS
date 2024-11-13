const form = document.getElementById('form')
const profile_input = document.getElementById('profile-input')
const name_input = document.getElementById('name-input')
const gender_input = document.getElementById('gender-input')
const address_input = document.getElementById('address-input')
const email_input = document.getElementById('email-input')
const dob_input = document.getElementById('dob-input')
const password_input = document.getElementById('password-input')
const repeat_password_input = document.getElementById('repeat-password-input')
const error_message = document.getElementById('error-message')

form.addEventListener('submit', (e) => {
  let errors = []

  if(name_input){
    // If we have a name input then we are in the signup
    errors = getSignupFormErrors(profile_input.value, name_input.value, gender_input.value, address_input.value, email_input.value, dob_input.value, password_input.value, repeat_password_input.value)
  }
  else{
    // If we don't have a name input then we are in the login
    errors = getLoginFormErrors(email_input.value, password_input.value)
  }

  if(errors.length > 0){
    // If there are any errors
    e.preventDefault()
    error_message.innerText  = errors.join(". ")
  }
})

function getSignupFormErrors(profile, name, gender, address, email, dob, password, repeatPassword){
  let errors = []

  if(profile === '' || profile == null){
    errors.push('Profile picture is required')
    profile_input.parentElement.classList.add('incorrect')
  }
  if(name === '' || name == null){
    errors.push('Full Name is required')
    name_input.parentElement.classList.add('incorrect')
  }
  if(gender === '' || gender == null){
    errors.push('Gender is required')
    gender_input.parentElement.classList.add('incorrect')
  }
  if(address === '' || address == null){
    errors.push('Gender is required')
    address_input.parentElement.classList.add('incorrect')
  }
  if(email === '' || email == null){
    errors.push('Email is required')
    email_input.parentElement.classList.add('incorrect')
  }
  if(dob === '' || dob == null){
    errors.push('Date of Birth is required')
    dob_input.parentElement.classList.add('incorrect')
  }
  if(password === '' || password == null){
    errors.push('Password is required')
    password_input.parentElement.classList.add('incorrect')
  }
  if(password.length < 8){
    errors.push('Password must have at least 8 characters')
    password_input.parentElement.classList.add('incorrect')
  }
  if(password !== repeatPassword){
    errors.push('Password does not match repeated password')
    password_input.parentElement.classList.add('incorrect')
    repeat_password_input.parentElement.classList.add('incorrect')
  }


  return errors;
}

function getLoginFormErrors(email, password){
  let errors = []

  if(email === '' || email == null){
    errors.push('Email is required')
    email_input.parentElement.classList.add('incorrect')
  }
  if(password === '' || password == null){
    errors.push('Password is required')
    password_input.parentElement.classList.add('incorrect')
  }

  return errors;
}

const allInputs = [profile_input, name_input, gender_input, address_input, email_input, dob_input, password_input, repeat_password_input].filter(input => input != null)

allInputs.forEach(input => {
  input.addEventListener('input', () => {
    if(input.parentElement.classList.contains('incorrect')){
      input.parentElement.classList.remove('incorrect')
      error_message.innerText = ''
    }
  })
})