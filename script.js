// ===== MENÚ MÓVIL =====
document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('menuBtn');
    const nav = document.querySelector('.header__nav');

    if (menuBtn && nav) {
        menuBtn.addEventListener('click', function() {
            nav.classList.toggle('active');
        });
    }

    // Cargar categorías con AJAX si estamos en index
    if (document.getElementById('categoriasGrid')) {
        cargarCategorias();
    }

    // Inicializar validaciones si hay formulario
    const formRegistro = document.getElementById('formRegistro');
    if (formRegistro) {
        inicializarValidacionRegistro(formRegistro);
    }

    const formLogin = document.getElementById('formLogin');
    if (formLogin) {
        inicializarValidacionLogin(formLogin);
    }

    // Cargar consejos si estamos en esa página
    if (document.getElementById('consejosLista')) {
        cargarConsejos();
        inicializarFiltros();
    }
});


// ===== AJAX: CARGAR CATEGORÍAS =====
function cargarCategorias() {
    const grid = document.getElementById('categoriasGrid');
    const loading = document.getElementById('loading');

    fetch('api/categorias.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la red');
            }
            return response.json();
        })
        .then(data => {
            loading.style.display = 'none';
            
            if (data.success && data.categorias.length > 0) {
                grid.innerHTML = data.categorias.map(cat => `
                    <div class="categoria-item" data-id="${cat.id}">
                        <div class="categoria-item__icono">${cat.icono}</div>
                        <div class="categoria-item__nombre">${cat.nombre}</div>
                    </div>
                `).join('');

                // Añadir evento click a cada categoría
                document.querySelectorAll('.categoria-item').forEach(item => {
                    item.addEventListener('click', function() {
                        const id = this.dataset.id;
                        window.location.href = `consejos.html?categoria=${id}`;
                    });
                });
            } else {
                grid.innerHTML = '<p>No hay categorías disponibles</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            loading.textContent = 'Error al cargar categorías';
            
            // Fallback con datos estáticos si falla el servidor
            grid.innerHTML = `
                <div class="categoria-item">
                    <div class="categoria-item__icono">🥗</div>
                    <div class="categoria-item__nombre">Nutrición</div>
                </div>
                <div class="categoria-item">
                    <div class="categoria-item__icono">🏃</div>
                    <div class="categoria-item__nombre">Ejercicio</div>
                </div>
                <div class="categoria-item">
                    <div class="categoria-item__icono">💆</div>
                    <div class="categoria-item__nombre">Bienestar</div>
                </div>
                <div class="categoria-item">
                    <div class="categoria-item__icono">😴</div>
                    <div class="categoria-item__nombre">Descanso</div>
                </div>
                <div class="categoria-item">
                    <div class="categoria-item__icono">🌿</div>
                    <div class="categoria-item__nombre">Natural</div>
                </div>
                <div class="categoria-item">
                    <div class="categoria-item__icono">💊</div>
                    <div class="categoria-item__nombre">Medicamentos</div>
                </div>
            `;
            loading.style.display = 'none';
        });
}


// ===== AJAX: CARGAR CONSEJOS =====
function cargarConsejos(categoriaId = null) {
    const lista = document.getElementById('consejosLista');
    const url = categoriaId 
        ? `api/consejos.php?categoria=${categoriaId}` 
        : 'api/consejos.php';

    lista.innerHTML = '<p class="categorias__loading">Cargando consejos...</p>';

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.consejos.length > 0) {
                lista.innerHTML = data.consejos.map(consejo => `
                    <article class="consejo-item">
                        <span class="consejo-card__tag">${consejo.categoria}</span>
                        <h3>${consejo.titulo}</h3>
                        <p>${consejo.contenido}</p>
                    </article>
                `).join('');
            } else {
                lista.innerHTML = '<p>No hay consejos disponibles</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Fallback con datos estáticos
            lista.innerHTML = `
                <article class="consejo-item">
                    <span class="consejo-card__tag">Nutrición</span>
                    <h3>Incluye frutas y verduras</h3>
                    <p>Consume al menos 5 porciones de frutas y verduras al día para obtener vitaminas y minerales esenciales.</p>
                </article>
                <article class="consejo-item">
                    <span class="consejo-card__tag">Ejercicio</span>
                    <h3>Estira antes de entrenar</h3>
                    <p>Realiza estiramientos suaves durante 5-10 minutos antes de cualquier actividad física para prevenir lesiones.</p>
                </article>
                <article class="consejo-item">
                    <span class="consejo-card__tag">Bienestar</span>
                    <h3>Practica la respiración profunda</h3>
                    <p>Dedica 5 minutos al día a respirar profundamente para reducir el estrés y mejorar la concentración.</p>
                </article>
            `;
        });
}

function inicializarFiltros() {
    const selectCategoria = document.getElementById('filtroCategoria');
    if (selectCategoria) {
        // Cargar categorías en el select
        fetch('api/categorias.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    data.categorias.forEach(cat => {
                        const option = document.createElement('option');
                        option.value = cat.id;
                        option.textContent = cat.nombre;
                        selectCategoria.appendChild(option);
                    });
                }
            })
            .catch(error => console.error('Error:', error));

        // Evento change para filtrar
        selectCategoria.addEventListener('change', function() {
            const categoriaId = this.value || null;
            cargarConsejos(categoriaId);
        });
    }

    // Verificar si viene categoría en URL
    const urlParams = new URLSearchParams(window.location.search);
    const categoriaUrl = urlParams.get('categoria');
    if (categoriaUrl) {
        cargarConsejos(categoriaUrl);
    }
}


// ===== VALIDACIÓN REGISTRO =====
function inicializarValidacionRegistro(form) {
    const nombre = document.getElementById('nombre');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');
    const btnSubmit = form.querySelector('.btn-submit');
    const alertBox = document.getElementById('alertBox');

    // Validación en tiempo real
    nombre.addEventListener('blur', () => validarNombre(nombre));
    email.addEventListener('blur', () => validarEmail(email));
    password.addEventListener('blur', () => validarPassword(password));
    confirmPassword.addEventListener('blur', () => validarConfirmPassword(password, confirmPassword));

    // Validación al enviar
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const nombreValido = validarNombre(nombre);
        const emailValido = validarEmail(email);
        const passwordValido = validarPassword(password);
        const confirmValido = validarConfirmPassword(password, confirmPassword);

        if (nombreValido && emailValido && passwordValido && confirmValido) {
            // Enviar con Fetch API
            btnSubmit.disabled = true;
            btnSubmit.textContent = 'Registrando...';

            const formData = new FormData(form);

            fetch('api/registro.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btnSubmit.disabled = false;
                btnSubmit.textContent = 'Registrarse';

                if (data.success) {
                    mostrarAlerta(alertBox, 'success', data.message);
                    form.reset();
                    limpiarValidaciones(form);
                } else {
                    mostrarAlerta(alertBox, 'error', data.message);
                }
            })
            .catch(error => {
                btnSubmit.disabled = false;
                btnSubmit.textContent = 'Registrarse';
                mostrarAlerta(alertBox, 'error', 'Error de conexión. Inténtalo de nuevo.');
            });
        }
    });
}


// ===== VALIDACIÓN LOGIN =====
function inicializarValidacionLogin(form) {
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const btnSubmit = form.querySelector('.btn-submit');
    const alertBox = document.getElementById('alertBox');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const emailValido = validarEmail(email);
        const passwordVacio = password.value.trim() !== '';

        if (!passwordVacio) {
            mostrarError(password, 'La contraseña es obligatoria');
        } else {
            ocultarError(password);
        }

        if (emailValido && passwordVacio) {
            btnSubmit.disabled = true;
            btnSubmit.textContent = 'Accediendo...';

            const formData = new FormData(form);

            fetch('api/login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btnSubmit.disabled = false;
                btnSubmit.textContent = 'Acceder';

                if (data.success) {
                    mostrarAlerta(alertBox, 'success', data.message);
                    setTimeout(() => {
                        window.location.href = 'index.html';
                    }, 1500);
                } else {
                    mostrarAlerta(alertBox, 'error', data.message);
                }
            })
            .catch(error => {
                btnSubmit.disabled = false;
                btnSubmit.textContent = 'Acceder';
                mostrarAlerta(alertBox, 'error', 'Error de conexión. Inténtalo de nuevo.');
            });
        }
    });
}


// ===== FUNCIONES DE VALIDACIÓN =====
function validarNombre(input) {
    const valor = input.value.trim();
    if (valor === '') {
        mostrarError(input, 'El nombre es obligatorio');
        return false;
    } else if (valor.length < 2) {
        mostrarError(input, 'El nombre debe tener al menos 2 caracteres');
        return false;
    } else {
        ocultarError(input);
        return true;
    }
}

function validarEmail(input) {
    const valor = input.value.trim();
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (valor === '') {
        mostrarError(input, 'El email es obligatorio');
        return false;
    } else if (!regexEmail.test(valor)) {
        mostrarError(input, 'El formato del email no es válido');
        return false;
    } else {
        ocultarError(input);
        return true;
    }
}

function validarPassword(input) {
    const valor = input.value;

    if (valor === '') {
        mostrarError(input, 'La contraseña es obligatoria');
        return false;
    } else if (valor.length < 6) {
        mostrarError(input, 'La contraseña debe tener al menos 6 caracteres');
        return false;
    } else {
        ocultarError(input);
        return true;
    }
}

function validarConfirmPassword(passwordInput, confirmInput) {
    const password = passwordInput.value;
    const confirm = confirmInput.value;

    if (confirm === '') {
        mostrarError(confirmInput, 'Confirma tu contraseña');
        return false;
    } else if (password !== confirm) {
        mostrarError(confirmInput, 'Las contraseñas no coinciden');
        return false;
    } else {
        ocultarError(confirmInput);
        return true;
    }
}


// ===== FUNCIONES AUXILIARES =====
function mostrarError(input, mensaje) {
    input.classList.add('error');
    input.classList.remove('valid');
    const errorSpan = input.nextElementSibling;
    if (errorSpan && errorSpan.classList.contains('error-message')) {
        errorSpan.textContent = mensaje;
        errorSpan.classList.add('show');
    }
}

function ocultarError(input) {
    input.classList.remove('error');
    input.classList.add('valid');
    const errorSpan = input.nextElementSibling;
    if (errorSpan && errorSpan.classList.contains('error-message')) {
        errorSpan.classList.remove('show');
    }
}

function limpiarValidaciones(form) {
    form.querySelectorAll('input').forEach(input => {
        input.classList.remove('error', 'valid');
    });
    form.querySelectorAll('.error-message').forEach(span => {
        span.classList.remove('show');
    });
}

function mostrarAlerta(alertBox, tipo, mensaje) {
    alertBox.className = `alert alert--${tipo} show`;
    alertBox.textContent = mensaje;

    setTimeout(() => {
        alertBox.classList.remove('show');
    }, 5000);
}
