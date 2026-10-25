// --- LOGIN MODAL ---
const userBtn = document.querySelector('.user-btn');
const loginModal = document.getElementById('userModal');
const loginClose = document.querySelector('.modal-close');

// --- REGISTER MODAL ---
const registerModal = document.getElementById('registerModal');
const registerClose = document.querySelector('.register-close');

// Botão "Registar" dentro do modal de login
const openRegister = document.querySelector('.modal-register a');

// Botão "Entrar" dentro do modal de registo
const voltarLogin = document.getElementById('voltarLogin');

// Abrir modal de login
if (userBtn) {
  userBtn.addEventListener('click', (e) => {
    e.preventDefault();
    loginModal.style.display = 'flex';
  });
}

// Fechar modal de login
loginClose.addEventListener('click', () => {
  loginModal.style.display = 'none';
});

// Abrir modal de registo
openRegister.addEventListener('click', (e) => {
  e.preventDefault();
  loginModal.style.display = 'none';
  registerModal.style.display = 'flex';
});

// Fechar modal de registo
registerClose.addEventListener('click', () => {
  registerModal.style.display = 'none';
});

// Voltar ao login
voltarLogin.addEventListener('click', (e) => {
  e.preventDefault();
  registerModal.style.display = 'none';
  loginModal.style.display = 'flex';
});
