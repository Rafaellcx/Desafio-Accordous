<template>
    <div>
        <h3>Cadastrar Contrato</h3>
        <div style="margin:10px" >
            <b-overlay :show="show" rounded="sm">
                <b-form @submit="onSubmit" @reset="onReset">
                    <div class="mt-3">
                        <b-card-group deck>
                            <b-card header="Novo Contrato" class="text-left">
                                Propriedade localizada em {{ enderecoCompleto }}
                                <hr>
                                <b-card-text>
                                    <div class="row justify-center">
                                        <div role="group" class="col" style="padding: 10px">
                                            <label for="input-live">Tipo de Pessoa:</label>
                                            <b-form-select id="input-selected" required v-model="selected" :options="options" :state="selectedState" ></b-form-select>
                                        </div>
                                        <div role="group" class="col" style="padding: 10px">
                                            
                                            <label for="input-live">Documento:</label>
                                            
                                            <b-form-input
                                            filled
                                            type="text"
                                            required
                                            id="input-documento"
                                            v-model="documento"
                                            :state="documentoState"
                                            v-mask="['###.###.###-##', '##.###.###/####-##']"
                                            aria-describedby="input-live-help input-live-feedback"
                                            placeholder="Informe o Documento(CPF ou CPNJ)"
                                            trim
                                            ></b-form-input>
                                            <b-form-invalid-feedback id="input-live-feedback">
                                                Documento não informado
                                            </b-form-invalid-feedback>

                                        </div>
                                    </div>
                                    <div class="row justify-center">
                                        <div role="group" class="col" style="padding: 10px">
                                            <label for="input-live">E-mail Contratante:</label>
                                            <b-form-input
                                            type="email"
                                            required
                                            id="input-emailcontratante"
                                            v-model="emailContratante"
                                            :state="emailcontratanteState"
                                            aria-describedby="input-live-help input-live-feedback"
                                            placeholder="Informe o E-mail do Contratante"
                                            trim
                                            ></b-form-input>
                                            <b-form-invalid-feedback id="input-live-feedback">
                                                E-mail do Contratante não informado
                                            </b-form-invalid-feedback>
                                        </div>
                                        <div role="group" class="col" style="padding: 10px">
                                            <label for="input-live">nome Contratante:</label>
                                            <b-form-input
                                            type="text"
                                            required
                                            id="input-nomeContratante"
                                            v-model="nomeContratante"
                                            :state="nomeContratanteState"
                                            aria-describedby="input-live-help input-live-feedback"
                                            placeholder="Informe o nome do Contratante"
                                            trim
                                            ></b-form-input>
                                            <b-form-invalid-feedback id="input-live-feedback">
                                                Nome do Contratante não informado
                                            </b-form-invalid-feedback>
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
            </b-overlay>
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
        name: 'CadastrarContrato',
        created() {
            
        },
        computed: {
            selectedState(){
                return this.selected == null ? false : true
            },
            documentoState() {
                return (this.documento.length == 0 || this.documento.length < 14) 
                    || (this.documento.length > 14 && this.documento.length < 18) 
                    || (this.documento.length == 14 && this.selected == 'J')
                    || (this.documento.length == 18 && this.selected == 'F')
                    ? false : true
            },
            emailcontratanteState(){
                return this.emailContratante.length == 0 ? false : true
            },
            nomeContratanteState(){
                return this.nomeContratante.length == 0 ? false : true
            },
        },
        data() {
        return {
            propriedade_id:null,
            enderecoCompleto:null,
            show: false,
            selected: null,
            options: [
                { value: null, text: 'Por favor, Selecione um Tipo de Pessoa' },
                { value: 'F', text: 'Física' },
                { value: 'J', text: 'Jurídica' },
            ],
            documento:'',
            emailContratante: '',
            nomeContratante: '',
        }
        },
        methods: {

            onSubmit(evt) {
                evt.preventDefault()
                this.show = true
                axios.post('http://127.0.0.1:8000/api/contrato/store',{ 
                propriedade_id:this.propriedade_id,
                tipoPessoa: this.selected,
                documento: this.documento,
                emailContratante: this.emailContratante,
                nomeContratante: this.nomeContratante,
                })

                .then(response => {
                    
                    this.show = !this.show

                    if(response.data.tipo == 'sucesso'){
                    this.$swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: response.data.mensagem,
                    showConfirmButton: true,
                    })
                    this.$router.push('/inicio')
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
                    this.show = !this.show

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
                this.documento = ''
                this.emailContratante = ''
                this.nomeContratante = ''
                this.selected = null
            },
    
        },
        mounted () {
            this.propriedade_id   = this.$route.params.id 
            this.enderecoCompleto = this.$route.params.enderecoCompleto 
        }
    }
</script>