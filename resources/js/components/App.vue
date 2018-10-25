<template>
    <div class="container">
        <h5 class="page-title"><router-link class="nav-link" :to="'/Domain'">Domain</router-link></h5>
            &nbsp;&nbsp;
        <h5 class="page-title"><router-link class="nav-link" :to="'/Log'">Logs</router-link></h5>
        <router-view></router-view>
    </div>
</template>

<script>

import axios from 'axios';
import Domain from './Domain';
import Log from './Log';

    export default {

        name:'App',

        components:{Domain,Log}
        
        
    }


    
</script>


