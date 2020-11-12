<template>
    <div style="margin:10px" >
    <h3>Contrato</h3>
        <div class="mt-3">
            <b-card-group deck>
                <b-card header="Dados do Contrato" class="text-left">
                    <b-card-text>
                        <b-table :fields="fields" :items="items" responsive="sm">
                        </b-table>
                    </b-card-text>
                </b-card>
            </b-card-group>
            <div style="margin:10px">
                <b-button type="reset" variant="outline-secondary" href="/inicio" style="margin:5px">Voltar</b-button>
            </div>
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
    name: 'Contrato',
    data() {
      return {
        
        textoContrato:'Contrato',
        fields: [
            { key: 'Propriedade', sortable: true, align: 'left' },
            { key: 'nomeContratante', sortable: true, align: 'left' },
            { key: 'tipoPessoa', sortable: true },
            { key: 'documento', sortable: true },
            { key: 'emailContratante', sortable: true, align: 'left' },
        ],
        items: [],
        propriedade_id:null,
        
      }
    },
    methods:{

      listaContrato(){
        this.items = [];
        axios
        .post('http://127.0.0.1:8000/api/contrato/show', {id:this.propriedade_id})
        .then(response => {
            console.log(response.data);
          
            this.items.push({
              id:response.data.id,
              propriedade_id:response.data.propriedade_id,
              tipoPessoa:response.data.TipoPessoaDesc,
              documento:response.data.documento,
              emailContratante:response.data.emailContratante,
              nomeContratante:response.data.nomeContratante,
              Propriedade:response.data.Propriedade,
            })
          
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
      
            this.$swal.fire({
                icon: 'error',
                title: '',
                text: error,
                footer: ''
            })
        })
      },
    },
    mounted () {
    this.propriedade_id   = this.$route.params.id 
    this.listaContrato();
    }
  }
</script>