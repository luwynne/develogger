<template>
  	<!-- Modal -->
	<div class="container openLeft">
		<p>{{ logDomainId }}</p>
		<div v-for="log in logs" :key="log.id" :log="log">
			<h1>{{ log.title }}</h1>
			<p>{{ log.description }}</p>
			<br><br>
		</div>
	</div>
</template>

<script>
import axios from 'axios';

export default {
    name:"Show",
	props:['logDomainId'],

	data(){
		return{
			logs:[],
			log:{domain_id:'', user:'', title:'', type:'', description:''},
		}
	},

	methods:{

		getLogsDomainList(){
			window.axios.get(`/develogger-app/public/api/domain-logs/${this.logDomainId}`).then(({data})=>{
                    data.forEach(log =>{
                        this.logs.push(log)
                    });
                });
		}

	},
	
	 created(){
        this.getLogsDomainList();
    },

}
</script>

