<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Registrar</div>

                    <div class="card-body">
                        <form method="GET" action="/login" @submit.prevent="register($event)">

                            <input type="hidden" name="_token" :value="csrfToken">

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" v-model="name" class="form-control" name="name" value="" required autocomplete="name" autofocus>

                                    <span class="invalid-feedback" role="alert">
                                        <strong>Mensagem</strong>
                                    </span>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" v-model="email" class="form-control" name="email" value="" required autocomplete="email" autofocus>

                                    <span class="invalid-feedback" role="alert">
                                        <strong>Mensagem</strong>
                                    </span>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Senha</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" v-model="password" class="form-control" name="password" required autocomplete="current-password">

                                    <span class="invalid-feedback" role="alert">
                                        <strong>Mensagem</strong>
                                    </span>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="passwordConfirmation" class="col-md-4 col-form-label text-md-end">Confirme a senha</label>

                                <div class="col-md-6">
                                    <input id="passwordConfirmation" type="password" v-model="passwordConfirmation" class="form-control" name="passwordConfirmation" required autocomplete="password-confirmation">

                                    <span class="invalid-feedback" role="alert">
                                        <strong>Mensagem</strong>
                                    </span>

                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">

                                    <button type="submit" class="btn btn-primary">
                                        Registrar
                                    </button>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import axios from 'axios';

    export default {
        props: ['csrfToken'],
        data() {
            return {
                name: '',
                email: '',
                password: '',
                passwordConfirmation: ''
            };
        },
        methods: {
            register(e) {

                let password = this.password;
                let passwordConfirmation = this.passwordConfirmation;

                if(password !== passwordConfirmation) {
                    alert('As senhas não coincidem!');
                    return;
                }

                const url = 'api/auth/v1/register';

                const data = {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    passwordConfirmation: this.passwordConfirmation
                };

                axios.post(url, data)
                    .then(response => {
                        console.log(response.data);
                        const token = response.data.token;
                        if(token) {
                            localStorage.setItem('token', response.data.token);
                            /*window.location.href = '/login';*/
                        }

                        e.target.submit();

                    })
                    .catch(error => {
                        console.log(error.response.data);
                    });
            }
        }
    }
</script>

