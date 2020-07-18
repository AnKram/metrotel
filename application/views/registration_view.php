<div class="container">
    <div class="row">
        <form id="registration-form">
            <div class="form-group">
                <label for="login">Логин</label>
                <input type="text" class="form-control" id="login" aria-describedby="loginHelp" placeholder="Ваш логин">
                <div id="ifb-login" class="invalid-feedback"></div>
                <small id="loginHelp" class="form-text text-muted">Логин должен включать в себя только латинские буквы или цифры, а также быть длинной от 2 до 20 знаков</small>
            </div>
            <div class="form-group">
                <label for="email">Почта</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Ваша почта">
                <div id="ifb-email" class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="pass">Пароль</label>
                <input type="password" class="form-control" id="pass" placeholder="Ваш пароль">
                <small id="passHelp" class="form-text text-muted">Пароль должен включать в себя латинские буквы и цифры, а также быть длинной от 4 до 20 знаков</small>
            </div>
            <div class="g-recaptcha" data-sitekey="6LcZvrIZAAAAAHttro_PlHblE1GgcdtlJMSMiA2W"></div>
            <div class="text-danger" id="recaptchaError"></div>
            </br>
            <button id="btn-registration" type="button" class="btn btn-primary">Зарегистрироваться</button>
            <a href="/user/login">Если вы уже зарегистрированы, нажмите сюда для входа </a>
        </form>
    </div>
</div>
