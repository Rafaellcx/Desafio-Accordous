<template>
    <div id="app">
        <h3>ACCORDOUS</h3>
        <b-card-group deck  style="margin:10px">
            <BtnCadastrarPropriedade/>
        </b-card-group>
            <Propriedade/>
    </div>
</template>

<script>
    import BtnCadastrarPropriedade from '../components/BtnCadastrarPropriedade'
    import Propriedade from '../components/Propriedade'
    export default {
        name: 'App',
        components:{
            BtnCadastrarPropriedade,
            Propriedade
        }
    }
</script>
