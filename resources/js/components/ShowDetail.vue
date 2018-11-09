<template>
    <div class="container openLeft">
		
	<div class="row-header">
		<div class="header-content-wrapper">
			<h1>{{logTitle}}</h1>
		</div>
		<span class="closebutton" @click="close">&times;</span>
	</div>
		
		<div class="row-body">
			<p><b>#{{logUser}}&nbsp;&nbsp;&nbsp;{{moment(logDate).fromNow()}}</b></p>
			<p>Type: {{logType}}</p>
            <p>Description: {{logDescription}}</p>
		</div>
	</div>
</template>


<script>

import moment from 'moment';

export default {

    name:'ShowDetail',

    props:['logUser','logTitle','logType','logDescription','logDate'],

    data(){
        return{
            
        }
    },

    methods:{

        close(){
			this.$emit('closeRequest');
        },
        
        moment,

    }
}
</script>

