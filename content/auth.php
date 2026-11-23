<section class="auth container">

<div class="auth-box">

<div class="tabs">
<button class="tab active" onclick="showTab('login', this)">вход</button>
<button class="tab" onclick="showTab('register', this)">регистрация</button>
</div>

<!-- ВХОД -->
<form class="form active" id="login" onsubmit="login(event)">
    <input name="login" autocomplete="username" placeholder="логин или email">
    <input name="password" type="password" autocomplete="current-password" placeholder="пароль">
    <button class="btn" type="submit">войти</button>
</form>

<!-- РЕГИСТРАЦИЯ -->
<form class="form" id="register" onsubmit="register(event)">
    <input name="login" autocomplete="username" placeholder="логин">
    <input name="email" autocomplete="email" placeholder="email">
    <input name="password" type="password" autocomplete="new-password" placeholder="пароль">
    <input name="password2" type="password" autocomplete="new-password" placeholder="повтор пароля">
    <button class="btn">зарегистрироваться</button>
</form>

</div>

</section>