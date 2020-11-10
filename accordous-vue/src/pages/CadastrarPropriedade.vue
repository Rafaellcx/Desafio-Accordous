<template>
    <div>
        <h3>Cadastrar Propriedade</h3>
        <div style="margin:10px" >
            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                <div class="mt-3">
                    <b-card-group deck>
                        <b-card header="Nova Propriedade" class="text-left">
                            <b-card-text>
                                <div class="row justify-center">
                                    <div role="group" class="col" style="padding: 10px">
                                        <label for="input-live">E-mail:</label>
                                        <b-form-input
                                        type="email"
                                        required
                                        id="input-email"
                                        v-model="email"
                                        :state="emailState"
                                        aria-describedby="input-live-help input-live-feedback"
                                        placeholder="Informe o e-mail"
                                        trim
                                        @blur="teste"
                                        ></b-form-input>
                                        <b-form-invalid-feedback id="input-live-feedback">
                                            E-mail não informado
                                        </b-form-invalid-feedback>

                                    </div>
                                    <div role="group" class="col" style="padding: 10px">
                                        <label for="input-live">Rua:</label>
                                        <b-form-input
                                        type="text"
                                        required
                                        id="input-rua"
                                        v-model="rua"
                                        :state="ruaState"
                                        aria-describedby="input-live-help input-live-feedback"
                                        placeholder="Informe a Rua"
                                        trim
                                        ></b-form-input>
                                        <b-form-invalid-feedback id="input-live-feedback">
                                            Rua não informada
                                        </b-form-invalid-feedback>

                                    </div>
                                </div>
                                <div class="row justify-center">
                                    <div role="group" class="col" style="padding: 10px">
                                        <label for="input-live">Número:</label>
                                        <b-form-input
                                        type="number"
                                        required
                                        id="input-numero"
                                        v-model="numero"
                                        :state="numeroState"
                                        aria-describedby="input-live-help input-live-feedback"
                                        placeholder="Informe o Número"
                                        trim
                                        ></b-form-input>
                                        <b-form-invalid-feedback id="input-live-feedback">
                                            Número não informado
                                        </b-form-invalid-feedback>
                                    </div>
                                    <div role="group" class="col" style="padding: 10px">
                                        <label for="input-live">Complemento:</label>
                                        <b-form-input
                                        type="text"
                                        id="input-complemento"
                                        v-model="complemento"
                                        aria-describedby="input-live-help input-live-feedback"
                                        placeholder="Informe o Complemento"
                                        trim
                                        ></b-form-input>
                                    </div>
                                </div>
                                <div class="row justify-center">
                                    <div role="group" class="col" style="padding: 10px">
                                        <label for="input-live">Bairro:</label>
                                        <b-form-input
                                        type="text"
                                        required
                                        id="input-bairro"
                                        v-model="bairro"
                                        :state="bairroState"
                                        aria-describedby="input-live-help input-live-feedback"
                                        placeholder="Informe o Bairro"
                                        trim
                                        ></b-form-input>
                                        <b-form-invalid-feedback id="input-live-feedback">
                                            Bairro não informado
                                        </b-form-invalid-feedback>
                                    </div>
                                    <div role="group" class="col" style="padding: 10px">
                                        <label for="input-live">Cidade:</label>
                                        <b-form-input
                                        type="text"
                                        required
                                        id="input-cidade"
                                        v-model="cidade"
                                        :state="cidadeState"
                                        aria-describedby="input-live-help input-live-feedback"
                                        placeholder="Informe a Cidade"
                                        trim
                                        ></b-form-input>
                                        <b-form-invalid-feedback id="input-live-feedback">
                                            Cidade não informada
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                                <div class="row justify-center" style="width:50%">
                                    <div role="group" class="col" style="padding: 10px;">
                                        <label for="input-selected">Estado:</label>
                                        <b-form-select id="input-selected" v-model="selected" :options="options" :state="selectedState" ></b-form-select>
                                    </div>
                                </div>
                            </b-card-text>
                        </b-card>
                    </b-card-group>
                    <div style="margin:10px">
                        <b-button type="submit" variant="outline-success" style="margin:5px">Confrimar</b-button>
                        <b-button type="reset" variant="outline-secondary" href="/inicio" style="margin:5px">Voltar</b-button>
                    </div>
                    
                </div>
            </b-form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import Vue from 'vue';
    import VueSweetalert2 from 'vue-sweetalert2';
    import 'sweetalert2/dist/sweetalert2.min.css';
    Vue.use(VueSweetalert2);

    export default {
        name: 'CadastrarPropriedade',
        created() {
            
        },
        computed: {
            emailState() {
                return this.email.length > 2 ? true : false
            },
            ruaState(){
                return this.rua.length == 0 ? false : true
            },
            numeroState(){
                return this.numero == 0 ? false : true
            },
            bairroState(){
                return this.bairro.length == 0 ? false : true
            },
            cidadeState(){
                return this.cidade.length == 0 ? false : true
            },
            estadoState(){
                return this.estado.length == 0 ? false : true
            },
            selectedState(){
                return this.selected == null ? false : true
            },
        },
        data() {
        return {
            show: true,
            email: '',
            rua:'',
            numero:'',
            complemento:'',
            bairro:'',
            cidade:'',
            estado:'',
            selected: null,
            options: [
                { value: null, text: 'Por favor, Selecione um estado' },
                { value: 'RJ', text: 'Rio de Janeiro' },
                { value: 'AC', text: 'Acre' },
                { value: 'AL', text: 'Alagoas' },
                { value: 'AP', text: 'Amapá' },
                { value: 'AM', text: 'Amazonas' },
                { value: 'BA', text: 'Bahia' },
                { value: 'CE', text: 'Ceará' },
                { value: 'DF', text: 'Distrito Federal' },
                { value: 'ES', text: 'Espírito Santo' },
                { value: 'GO', text: 'Goiás' },
                { value: 'MA', text: 'Maranhão' },
                { value: 'MT', text: 'Mato Grosso' },
                { value: 'MS', text: 'Mato Grosso do Sul' },
                { value: 'MG', text: 'Minas Gerais' },
                { value: 'PA', text: 'Pará' },
                { value: 'PB', text: 'Paraíba' },
                { value: 'PR', text: 'Paraná' },
                { value: 'PE', text: 'Pernambuco' },
                { value: 'PI', text: 'Piauí' },
                { value: 'RN', text: 'Rio Grande do Norte' },
                { value: 'RS', text: 'Rio Grande do Sul' },
                { value: 'RO', text: 'Rondônia' },
                { value: 'RR', text: 'Roraima' },
                { value: 'SP', text: 'São Paulo' },
                { value: 'SE', text: 'Sergipe' },
                { value: 'TO', text: 'Tocantins' },
            ]
        }
        },
        methods: {

            teste(){
                console.log('Mudou de campo');
                return this.email.length > 2 ? true : false
            },
            onSubmit(evt) {
                evt.preventDefault()
                axios.post('http://127.0.0.1:8000/api/propriedade/store',{ 
                email: this.email,
                rua: this.rua,
                numero: this.numero,
                complemento:'',
                bairro: this.bairro,
                cidade: this.cidade,
                estado: this.selected,
                })

                .then(response => {
                if(response.data.tipo == 'sucesso'){
                this.$swal.fire({
                position: 'center',
                icon: 'success',
                title: response.data.mensagem,
                showConfirmButton: true,
                })

                this.onReset(evt)
                }
                
                if(response.data.tipo == 'erro'){
                    this.$swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: response.data.mensagem,
                        showConfirmButton: true,
                    })
                }
                })
                .catch((error) => {
                    console.log(error);
                    this.$swal.fire({
                        icon: 'error',
                        title: '',
                        text: error,
                        footer: ''
                    })
                })
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.email = ''
                this.rua = ''
                this.numero = ''
                this.complemento = ''
                this.bairro = ''
                this.cidade = ''
                this.estado = ''
                this.selected = null
                // // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                this.show = true
                })
            }
        }
    }
</script>