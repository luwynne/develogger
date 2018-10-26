<template>
    <div class="container">
        <div class="form-group">
                <input type="text" class="form-control" id="filter" placeholder="Filter the Domains">  
        </div>

        <div class="row content-holder">
            <table>
                <thead>
                    <tr>
                        <th class="client-name">Domain</th>
                        <th class="client-pm">Client</th>
                        <th class="client-pm">Add Log on Domain</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="domain in domains" :key="domain.id" :domain="domain" class="tr-table">
                        <td class="client-name">{{ domain.url }}</td>
                        <td class="client-pm">{{ domain.client }}</td>
                        <td class="client-pm center"><i class="fas fa-plus jobs-page" data-toggle="modal" data-target="#exampleModalCenter" @click="doSomethingWith(domain.id, domain.url)"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    
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
                                <input  type="checkbox" name="tell-everyone" id="tell-everyone">
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

    export default {

        name:'Domain',

        data(){
            return {
                checked:false,
                domainSendId: '',
                domainSendName: '',
                domains: [],
                domain: {id:'', url:'', client: ''},
                log: {domain_id: this.domainSendId, title: '', type: '', description: ''},
                errors:{}
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
                this.log.domain_id = this.domainSendId;
                if(this.log.title.length > 0 && this.log.type.length > 0 && this.log.description.length > 0){

                    window.axios.post('/develogger-app/public/api/domains',this.log).then((response) => {
                        // this.logs.push(response.data)
                        this.log.domain_id = '';
                        this.log.title = '';
                        this.log.type = '';
                        this.log.description = '';
                        this.checked = false;
                    
                    }).catch((error) => this.errors = error.response.data.errors)

                }
            },

            doSomethingWith(item1, item2) {
                this.domainSendId = item1;
                this.domainSendName = item2;
            }
            
        },

        created(){
            this.getDomains();
        },

        computed: {
            isComplete () {
                return this.log.title && this.log.type && this.log.description;
            }
        }
  
        
    }


    
</script>


