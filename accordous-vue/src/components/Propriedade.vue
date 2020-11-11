<template>
    <div style="margin:10px" >
        <div class="mt-3">
            <b-card-group deck>
                <b-card header="Propriedades" class="text-center">
                    <b-card-text>
                        <b-table :fields="fields" :items="items" responsive="sm">
                          <template v-slot:cell(actions)="data">
                            <b-button size="sm" class="mr-2" variant="info" @click="contrato(data)">{{textoContrato}}</b-button>
                            <b-button size="sm" variant="danger" @click="excluirPropriedade(data)">Excluir</b-button>
                          </template>
                        </b-table>
                    </b-card-text>
                </b-card>
            </b-card-group>
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
    name: 'Propriedade',
    data() {
      return {
        
        textoContrato:'Contrato',
        fields: [
          { key: 'email', sortable: true },
          { key: 'rua', sortable: true, align: 'left' },
          { key: 'complemento', sortable: true, align: 'left' },
          { key: 'bairro', sortable: true, align: 'left' },
          { key: 'cidade', sortable: true, align: 'left' },
          { key: 'estado', sortable: true, align: 'left' },
          { key: 'StatusDesc', label:'Status', sortable: true, align: 'left' },
          { key: 'actions', label: 'Ações'}
        ],
        items: [],
        
      }
    },
    methods:{

      listaPropriedades(){
        this.items = [];
        axios
        .get('http://127.0.0.1:8000/api/propriedade/index')
        .then(response => {
     
          for (let index = 0; index < response.data.length; index++) {
            this.items.push({
              id:response.data[index].id,
              enderecoCompleto:response.data[index].EnderecoCompleto,
              email:response.data[index].email,
              rua:response.data[index].rua,
              complemento:response.data[index].complemento,
              bairro:response.data[index].bairro,
              cidade:response.data[index].cidade,
              estado:response.data[index].estado,
              status:response.data[index].status,
              StatusDesc:response.data[index].StatusDesc,
            })
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
      
            this.$swal.fire({
                icon: 'error',
                title: '',
                text: error,
                footer: ''
            })
        })
      },
      contrato(data){
      
        switch (data.item.status) {
          case 'N':
            this.$router.push('/cadastrarcontrato/'+data.item.id+'/'+data.item.enderecoCompleto)
            break;
          case 'C':
            this.$router.push('/contrato/'+data.item.id+'/'+data.item.enderecoCompleto)
            break;
          default:
            break;
        }
      },
      excluirPropriedade(data){
      
        var id = data.item.id;

        this.$swal.fire({
          title: 'Tem certeza que deseja excluir a propriedade?',
          text: "Após a confirmação, a operação não poderá ser desfeita.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim'
        }).then((result) => {
          if (result.isConfirmed) {
            // this.$q.loading.show();
            axios.post('http://127.0.0.1:8000/api/propriedade/destroy',{ 
            id
            })

            .then(response => {
            if(response.data.tipo == 'sucesso'){
              // this.$q.loading.hide();
              this.listaPropriedades();
              this.$swal.fire({
                position: 'center',
                icon: 'success',
                title: response.data.mensagem,
                showConfirmButton: true,
                // timer: 2000
              })
              // .then((result) => {
              //   if (result.isConfirmed) {

              //   }
              // })
            }
            if(response.data.tipo == 'erro'){
              // this.$q.loading.hide();
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
          }
        })
      }
    },
    mounted () {
      this.listaPropriedades();
    }
  }
</script>