<template>
    <div class="row">
        <div class="col-md-12" style="padding:15px">
            <q-card bordered class="bg-white my-card">
                <q-card-section>
                    <div class="text-h6">Propriedades</div>
                </q-card-section>

                <q-separator inset />

                <q-card-section>
                    <!-- <div class="row justify-center"> -->
                    <div class="col">
                        <div class="q-pa-md">
                            <q-table
                            dense
                            :data="data"
                            :columns="columns"
                            row-key="name"
                            />
                        </div>
                    </div>
                </q-card-section>
            </q-card>
        </div>
    </div>
</template>

<script>
export default {
  data () {
    return {
      columns: [
        {
          name: 'atividade',
          required: true,
          label: 'Atividade',
          align: 'left',
          field: row => row.name,
          format: val => `${val}`,
          sortable: true
        },
        { name: 'email', align: 'center', label: 'E-mail', field: 'email', sortable: true },
        { name: 'rua', label: 'Rua', field: 'rua', sortable: true },
        { name: 'numero', label: 'Número', field: 'numero', sortable: true },
        { name: 'complemento', label: 'Complemento', field: 'complemento', sortable: true },
        { name: 'bairro', label: 'Bairro', field: 'bairro', sortable: true },
        { name: 'cidade', label: 'Cidade', field: 'cidade', sortable: true },
        { name: 'estado', label: 'Estado', field: 'estado', sortable: true },
        { name: 'status', label: 'Status', field: 'status' , icon: 'edit', sortable: true},
       
        // { name: 'sodium', label: 'Sodium (mg)', field: 'sodium' },
        // { name: 'calcium', label: 'Calcium (%)', field: 'calcium', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
        // { name: 'iron', label: 'Iron (%)', field: 'iron', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) }
      ],
      data: [
        {
          email: 'rafaellessacastro@hotmail.com',
          rua:'Rua das Alegrias',
          numero:'13',
          complemento:'Próximo à casa de Campo',
          bairro:'Campo lindo',
          cidade:'GreenVille',
          estado:'PE',
          status:'C',
        },
        {
          email: 'claudio@gmail.com',
          rua:'Rua da Amargura',
          numero:'1320',
          complemento:'Próximo ao bar do Peixoto',
          bairro:'Antares',
          cidade:'Maceió',
          estado:'AL',
          status:'C',
        },
        {
          email: 'reginaldo@hotmail.com',
          rua:'Rua da Saudade',
          numero:'137',
          complemento:'próximo do ponto de táxi',
          bairro:'Bairro Canto da Saudade',
          cidade:'Fortaleza',
          estado:'CE',
          status:'N',
        },
        
        
      ]
    }
  }
}
</script>