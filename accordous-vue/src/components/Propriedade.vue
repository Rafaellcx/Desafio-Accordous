<template>
    <div style="margin:10px" >
        <div class="mt-3">
            <b-card-group deck>
                <b-card header="Propriedade" class="text-center">
                    <b-card-text>
                        <b-table
                        :items="items"
                        :fields="fields"
                        :sort-by.sync="sortBy"
                        :sort-desc.sync="sortDesc"
                        responsive="sm"
                        ></b-table>

                        <div>
                            Ordenado Por: <b>{{ sortBy }}</b>, Ordem:
                            <b>{{ sortDesc ? 'Descendente' : 'Ascendente' }}</b>
                        </div>
                    </b-card-text>
                </b-card>
            </b-card-group>
        </div>
    </div>
    
</template>

<script>
  import axios from 'axios'
  export default {
    name: 'Propriedade',
    data() {
      return {
        sortBy: 'email',
        sortDesc: false,
        fields: [
          { key: 'email', sortable: true },
          { key: 'rua', sortable: true },
          { key: 'complemento', sortable: true },
          { key: 'bairro', sortable: true },
          { key: 'cidade', sortable: true },
          { key: 'estado', sortable: true },
          { key: 'status', sortable: true },
        ],
        items: [],
        // items: [
        //   { email: 'jonas@gmail.com', rua: 'Rua dos inocentes', complemento: 's/c', bairro: 'Bairro dos sonhos', cidade:'Cidade dos Sonhos', estado:'Estado dos Sonhos', status:'C' },
        //   // { bairro: false, complemento: 21, rua: 'Larsen', email: 'Shaw' },
        //   // { bairro: false, complemento: 89, rua: 'Geneva', email: 'Wilson' },
        //   // { bairro: true, complemento: 38, rua: 'Jami', email: 'Carney' }
        // ]
      }
    },
      mounted () {
          axios
          .get('http://127.0.0.1:8000/api/propriedade/index')
          .then(response => {
            // console.log(response.data);
            for (let index = 0; index < response.data.length; index++) {
            this.items.push({
              id:response.data[index].id,
              email:response.data[index].email,
              rua:response.data[index].rua,
              complemento:response.data[index].complemento,
              bairro:response.data[index].bairro,
              cidade:response.data[index].cidade,
              estado:response.data[index].estado,
              status:response.data[index].StatusDesc,
            })
            }
            // if(response.data.tipo == 'erro'){
            // }
            })
      }
  }
</script>