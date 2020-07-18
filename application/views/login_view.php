<div class="container">
    <div class="row">
        <form id="in-form">
			<div class="form-group">
                <label for="login">Логин (или адрес электронной почты, указанный при регистрации)</label>
                <input type="login" class="form-control" id="login" aria-describedby="loginHelp" placeholder="Ваша почта">
                <div id="ifb-login" class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="pass">Пароль</label>
                <input type="password" class="form-control" id="pass" placeholder="Ваш пароль">
                <div id="ifb-pass" class="invalid-feedback"></div>
            </div>
            <div class="g-recaptcha" data-sitekey="6LcZvrIZAAAAAHttro_PlHblE1GgcdtlJMSMiA2W"></div>
            <div class="text-danger" id="recaptchaError"></div>
			</br>
            <button id="btn-in" type="button" class="btn btn-primary">Войти</button>
            <a href="/user/registration">Если у вас нет аккаутна, нажмите сюда для регистрации</a>
        </form>
    </div>
</div>
