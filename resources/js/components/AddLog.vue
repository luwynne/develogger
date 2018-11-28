<template>
    <div class="container">
        <div id="overlay">
            <div class="edit-detail-window">
                <div v-if="isLoading" class="loading-image">
                    <img src="/develogger-app/public/img/dev-tick.gif" alt="">
                </div>
               <form v-on:submit.prevent = "updatePost">   
                    <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLongTitle">Create new Log</h3>
                            <button type="button" class="close">
                            <router-link :to="'/Log'"><i class="fas inner-fas fa-times"></i></router-link>
                            </button>
                    </div>
                    <div id="show-detail-modal-body" class="modal-body">
                        
                        <input type="hidden" name="_token" :value="csrf">

                            <input v-model="log.title" name="website" type="text" id="website" class="form-control" placeholder="Log Title"><br>

                            <select v-model="log.domain_id" id="type" class="form-control" name="type"><br>
                                <option value="" disabled selected>Website</option>
                                 <option v-for="domain in domains" :key="domain.id" :domain="domain.id" :value="`${domain.id}`">{{domain.url}}</option>
                            </select>

                            <br>

                            <select v-model="log.type" id="type" class="form-control" name="type"><br>
                                <option value="" disabled selected>Type</option>
                                <option>Client Update</option>
                                <option>Dev Update</option>
                                <option>Bug Fix</option>
                                <option>Style Fix</option>
                                <option>New Website</option>
                            </select>

                            <br>

                            <label class="left" for="description">Log Description:</label>
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
              </form>  
            </div>
        </div>
    </div>
</template>


<script>

import axios from 'axios';
import Log from './Log.vue';

export default {

    name:'AddLog',

    data(){
        return{
            isLoading:'',
            checked:false,
            tell:false,
            domains:[],
            domain:{url:'', id:'', url:'', client:''},
            log:{domain_id:'', user:'', title:'',type:'',description:''},
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            errors:{}
        }
    },

    methods:{

       save(){ //creates the new log
                this.isLoading = true;
                if(this.log.title.length > 0 && this.log.domain_id.length > 0 && this.log.type.length > 0 && this.log.description.length > 0){

                    window.axios.post('/develogger-app/public/api/logs',this.log).then((response) => {
                        this.log.domain_id = '';
                        this.log.title = '';
                        this.log.type = '';
                        this.log.description = '';
                        this.checked = false;
                        this.$router.push('/Log');


                        setTimeout(() => {
                            this.isLoading = false;
                        }, 800);
                    
                    }).catch((error) => this.errors = error.response.data.errors)

                }
                
            },

        getAllDomains(){ //this function brings the domains to the select drop down list in order to create a new log as soon as the component is loaded
                window.axios.get('/develogger-app/public/api/domains').then(({data})=>{
                    data.forEach(domain =>{
                        this.domains.push(domain)
                    });
                });
            },
               

    },

    computed: { //processing real live. This is used to validate the modal that creates a new log
            isComplete () {
                return this.log.title && this.log.domain_id && this.log.type && this.log.description;
            }
        },

     created(){ //load those functions as soon as the component is loaded
            this.getAllDomains();
        },

}
</script>

