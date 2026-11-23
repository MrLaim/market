/* ================= LOAD ================= */

async function load(page) {
    try {
        let url = "content/" + page + ".php";

        // product&id=1
        if (page.startsWith("product&")) {
            const id = page.split("&")[1].split("=")[1];
            url = "content/product.php?id=" + id;
        }

        const res = await fetch(url);

        if (!res.ok) {
            document.getElementById("content").innerHTML =
                "<h2>Страница не найдена</h2>";
            return;
        }

        const html = await res.text();
        document.getElementById("content").innerHTML = html;

    } catch (err) {
        document.getElementById("content").innerHTML =
            "<h2>Ошибка загрузки</h2>";
        console.error(err);
    }
}

/* ================= ALERT ================= */

function showAlert(target, message, success = true){

    let alert;

    // если глобальный (для корзины и т.д.)
    if (target === document.body) {

        alert = document.createElement('div');
        alert.className = 'alert-global';

        document.body.appendChild(alert);

    } else {

        alert = target.querySelector('.alert');

        if(!alert){
            alert = document.createElement('div');
            alert.className = 'alert';
            target.prepend(alert);
        }
    }

    alert.innerText = message;

    alert.style.background = success ? "#4caf50" : "#c0392b";

    clearTimeout(alert._timer);
    alert._timer = setTimeout(() => {
        alert.remove();
    }, 3000);
}

/* ================= LOGIN ================= */

async function login(event){
    const form = event.target;
    const formData = new FormData(form);

    try {
        const res = await fetch('content/login.php', {
            method: 'POST',
            body: formData
        });

        const data = await res.json();

        showAlert(form, data.message, data.success);

        if (data.success) {
            setTimeout(() => {
                window.location.href = "index.php";
            }, 1000);
        }

    } catch (e) {
        showAlert(form, "Ошибка сервера", false);
    }
}

/* ================= REGISTER ================= */

async function register(event){
    const form = event.target;
    const data = new FormData(form);

    try {
        const res = await fetch('content/register.php', {
            method: 'POST',
            body: data
        });

        const result = await res.json();

        showAlert(form, result.message, result.success);

        if(result.success){
            setTimeout(() => {
                showTab('login', document.querySelector('.tab'));
            }, 1500);
        }

    } catch (e) {
        showAlert(form, "Ошибка сервера", false);
    }
}

/* ================= MENU ================= */

document.addEventListener("click", function (e) {

    const link = e.target.closest("[data-page]");
    if (link) {
        e.preventDefault();
        load(link.dataset.page);
        return;
    }

    const productLink = e.target.closest(".product-link");
    if (productLink) {
        e.preventDefault();
        const id = productLink.dataset.id;
        load("product&id=" + id);
        return;
    }

});

/* ================= CART ADD ================= */

document.addEventListener("click", function(e){

    const btn = e.target.closest(".add-to-cart");
    if (!btn) return;

    e.preventDefault();
    e.stopPropagation();

    const productId = btn.dataset.id;

    if (!productId) {
        console.error("Нет data-id у кнопки");
        return;
    }

    const formData = new FormData();
    formData.append("product_id", productId);

    fetch("content/add_to_cart.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        showAlert(
            document.body,
            data.message || "Товар добавлен",
            data.success ?? true
        );
    })
    .catch(err => {
        console.error(err);
        alert("Ошибка сервера");
    });

});

/* ================= CART REMOVE ================= */

document.addEventListener("click", function(e){

    const btn = e.target.closest(".cart-remove");
    if (!btn) return;

    const itemId = btn.dataset.id;

    const formData = new FormData();
    formData.append("item_id", itemId);

    fetch("content/remove_from_cart.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        showAlert(document.body, data.message, data.success);

        load("carth"); // 🔥 обновляем корзину
    });

});

/* ================= AUTH ================= */

let isLogged = false;

async function checkAuth(){
    try {
        const res = await fetch("content/auth_check.php");
        const data = await res.json();

        isLogged = data.logged;
        updateAuthButton();

    } catch (e) {
        console.error("auth check error", e);
    }
}

function updateAuthButton(){
    const btn = document.getElementById("authBtn");
    if (!btn) return;

    btn.textContent = isLogged ? "Выход" : "Вход";
}

async function authAction(e){
    e.preventDefault();

    if (!isLogged) {
        load("auth");
        return;
    }

    const res = await fetch("content/logout.php");
    const data = await res.json();

    if (data.success) {
        checkAuth();

        setTimeout(() => {
            window.location.href = "index.php";
        }, 1000);
    }
}

/* ================= TABS ================= */

function showTab(tab, btn){
    document.querySelectorAll('.form').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab').forEach(el => el.classList.remove('active'));

    document.getElementById(tab).classList.add('active');

    if(btn){
        btn.classList.add('active');
    }
}

/* ================= INIT ================= */

document.addEventListener("DOMContentLoaded", function () {
    load("home");
    checkAuth();
});

/* ================= FORM HANDLER ================= */

document.addEventListener("submit", function(event){

    const form = event.target;

    if (form.id === "login") {
        event.preventDefault();
        login(event);
    }

    if (form.id === "register") {
        event.preventDefault();
        register(event);
    }

});