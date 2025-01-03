// Seleccionar el formulario
const formLogin = document.getElementById('formLogin');
if (formLogin) {
  formLogin.addEventListener('submit', function (event) {
    // Quitar clases de error previas
    formLogin.classList.remove('was-validated');

    // Validaciones en tiempo real
    const email = document.getElementById('email');
    const password = document.getElementById('password');

    let formValido = true;

    // Validación de email
    if (!email.value.match(/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/)) {
      email.classList.add('is-invalid');
      formValido = false;
    } else {
      email.classList.remove('is-invalid');
    }

    // Validación de contraseña segura
    // Al menos 6 caracteres, una letra y un número
    const passRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/;
    if (!passRegex.test(password.value)) {
      password.classList.add('is-invalid');
      formValido = false;
    } else {
      password.classList.remove('is-invalid');
    }

    if (!formValido) {
      event.preventDefault();
      event.stopPropagation();
      formLogin.classList.add('was-validated');
    }
  });
}
