<div class="login login-v1">
    <div class="login-container">
        <!-- header -->
        <div class="login-header">
            <div class="brand">
                <span class="logo">
                    <img width="30" src="public/images/logo/logo.webp" alt="">
                </span> <b>Connexion</b> 
                <small class="ml-4">Bienvenue sur FMTech !</small>
            </div>
            <div class="icon">
                <i class="fa fa-lock"></i>
            </div>
        </div>
        <!-- FORM -->
        <div class="login-body">
            <!-- begin login-content -->
            <div class="login-content">
                <form action="userMainController" method="POST" id="loginform" class="margin-bottom-0">
                    <!-- Email -->
                    <div class="form-group m-b-20">
                        <input type="text" id="email" name="email" class="form-control form-control-lg inverse-mode" placeholder="Email votre Email" required />
                        <p class="error-message h5 fw-bold mt-2 mb-2"></p>
                    </div>
                    <!-- Password -->
                    <div class="form-group m-b-20">
                        <input type="password" id="password" name="password" class="form-control form-control-lg inverse-mode" placeholder="Entrer votre Password" required />
                        <p class="error-message h5 fw-bold ml-2 mt-2 mb-2"></p>
                    </div>
                    <div class="checkbox checkbox-css m-b-20">
                        <input type="checkbox" id="remember_checkbox" />
                        <label for="remember_checkbox">
                            Se souvenir de Moi
                        </label>
                        <small class="">
                            <a class=" h6 text-white ml-2" href="home">Page Acceuil</a>
                        </small>
                        <small class="">
                            <a class=" h6 text-white ml-2" href="#">Mot de passe oublie</a>
                        </small>
                    </div>

                    <div class="login-buttons">
                        <button type="submit" name="formLogin" id="btnSubmit" class="btn btn-success btn-block btn-lg">Se Connecter</button>
                    </div>
                </form>
            </div>
            <!-- end login-content -->
        </div>
        <!-- end login-body -->
    </div>
    <!-- end login-container -->
</div>