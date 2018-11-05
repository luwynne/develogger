<template>
    <div class="container">
        <div class="form-group">
                <!-- <input type="text" class="form-control" id="filter" placeholder="Filter the Domains">   -->
                <div v-if="isLoading" class="loading-image">
                    <img src="/develogger-app/public/img/dev-tick.gif" alt="">
                </div>
                
        </div>

        <div class="col-md-12 row content-holder">
            <table class="table">
                <thead>
                    <tr class="left-align">
                        <th class="client-name">Domain</th>
                        <th class="client-pm">Client</th>
                        <th class="client-pm" style="text-align:center">Add Log</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="domain in domains" :key="domain.id" :domain="domain" class="tr-table">     
                        <td class="client-name" @click="openLogs(domain.id, domain.url, domain.client)"><span class="domainClick">{{ domain.url }}</span></td>
                        <td class="client-pm">{{ domain.client }}</td>
                        <td class="client-pm center"><i class="fas fa-plus jobs-page" data-toggle="modal" data-target="#exampleModalCenter" @click="getDomainInfo(domain.id, domain.url)"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <log-show v-if="logModalOpen" :logDomainId="logDomainId" :logDomainName="logDomainName" :logDomainClient="logDomainClient" @closeRequest='close'></log-show>
    
               <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create new Log for <br>{{domainSendName}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                             <input v-model="log.title" name="title" type="text" id="title" class="form-control" placeholder="Log Title">
                            
                             <input v-model="log.domain_id" type="hidden">

                            <br>

                            <select v-model="log.type" id="type" class="form-control" name="type"><br>
                                <option value="" disabled selected>Type</option>
                                <option>Client Update</option>
                                <option>Dev Update</option>
                                <option>Bug</option>
                                <option>Style Fix</option>
                            </select>

                            <br>

                            <label  class="left" for="description">Log Description:</label>
                            <textarea v-model="log.description" class="form-control" rows="5" id="description" name="description"></textarea>

                            <br>

                            <div class="left">
                                <input  v-model="tell" type="checkbox" name="tell-everyone" id="tell-everyone">
                                <label for="description">Tell Everyone?</label>
                                <br>
                                <input v-model="checked" type="checkbox" name="status" id="status" value="checked">
                                <label for="checked">Resolved and Tested?</label>
                            </div>
                            
                    </div>
                    <div class="modal-footer">
                        <button :disabled="!checked || !isComplete" id="log-it" type="button" class="btn btn-circle btn-xl" data-dismiss="modal" @click="save">
                            <span v-if="checked && isComplete" id="button-content"><b>LOG IT</b></span>
                            <span v-else id="button-content"><b>FIX IT</b></span>
                        </button>
                       
                            
                    </div>
                    </div>
                </div>
            </div>           

    </div>
</template>

<script>

import axios from 'axios';
import Show from './Show.vue'
// Import component
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {

        name:'Domain',

        data(){
            return {
                tell:false,
                isLoading:'',
                logModalOpen: false,
                logDomainId:'',
                logDomainName:'',
                logDomainClient:'',
                checked:false,
                domainSendId: '',
                domainSendName: '',
                domains: [],
                domain: {id:'', url:'', client: ''},
                log: {domain_id: this.domainSendId, title: '', type: '', description: ''},
                errors:{},
            }
        },


        methods:{

            getDomains(){
                
                window.axios.get('/develogger-app/public/api/domains').then(({data})=>{
                    data.forEach(domain =>{
                        this.domains.push(domain)
                        
                    });
                });
            },

            openAdd(key){
                //this.$children[1].domain = this.domains[key];
                this.addActive = 'is-active';

            },

            save(){
                this.isLoading = true;
                this.log.domain_id = this.domainSendId;
                if(this.log.title.length > 0 && this.log.type.length > 0 && this.log.description.length > 0){

                    window.axios.post('/develogger-app/public/api/domains',this.log).then((response) => {
                        this.log.domain_id = '';
                        this.log.title = '';
                        this.log.type = '';
                        this.log.description = '';
                        this.checked = false;

                        setTimeout(() => {
                            this.isLoading = false;
                        }, 800);
                    
                    }).catch((error) => this.errors = error.response.data.errors);

                }
            },

            isLoadingFalse(){

                this.isLoading = false;

            },

            getDomainInfo(item1, item2) {
                this.domainSendId = item1;
                this.domainSendName = item2;
            },

            openLogs(id, name, client){
                this.logDomainId = id;
                this.logDomainName = name;
                this.logDomainClient = client
                this.logModalOpen = true;
            },

            close(){
                this.logModalOpen = false;
            }

            
        },

        created(){
            this.getDomains();
        },

        computed: {

            isComplete () {
                return this.log.title && this.log.type && this.log.description;
            },
 
        },

        components:{
            'log-show': Show,
        }
  
        
    }


    
</script>


