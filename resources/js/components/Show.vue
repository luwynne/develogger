<template>
  	<!-- Modal -->
	<div class="container openLeft">
		
	<div class="row-header">
		<div class="header-content-wrapper">
			<h1>{{logDomainName}}</h1>
			<p><b>Client:</b> {{ logDomainClient }}</p>
		</div>
		<span class="closebutton" @click="close">&times;</span>
	</div>
		
		<div v-for="log in logs" :key="log.id" :log="log" class="row-body">
			<p><b>#{{log.log_counter}}&nbsp;{{ log.user }}&nbsp;&nbsp;&nbsp;{{ log.created_at }}</b></p>
			<h2>{{ log.title }}</h2>
			<p>{{ log.description }}</p>
			<br><br>
		</div>
		<div v-if="logs.length < 1 || logs == undefined" class="no-log-row">
			<h1>No Logs for {{ logDomainName }}</h1>
		</div>
	</div>
</template>

<script>
import axios from 'axios';

export default {
    name:"Show",
	props:['logDomainId','logDomainName','logDomainClient'],

	data(){
		return{
			logs:[],
			log:{log_counter:1, domain_id:'', user:'', title:'', type:'', description:''},
		}
	},

	methods:{

		getLogsDomainList(){
			window.axios.get(`/develogger-app/public/api/domain-logs/${this.logDomainId}`).then(({data})=>{
                    data.forEach(log =>{
						log.log_counter = this.log.log_counter++;
                        this.logs.push(log)
                    });
                });
		},

		close(){
			this.$emit('closeRequest');
		}

	},
	
	 created(){
        this.getLogsDomainList();
    },

}
</script>

