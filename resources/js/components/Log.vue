<template>
    <div class="container">

        <div class="form-group">
                <input type="text" class="form-control" id="filter" placeholder="Filter the Logs">
                <i class="fas fa-plus jobs-page" data-toggle="modal" data-target="#exampleModalCenter"></i>
        </div>

        <div class="row content-holder">
            <table>
                <thead>
                    <tr>
                        <th class="client-name">Log</th>
                        <th class="client-pm">User</th>
                        <th class="client-pm">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="log in logs" :key="log.id" :log="log" class="tr-table">
                        <td class="client-name">{{ log.title }}</td>
                        <td class="client-pm">{{ log.user }}</td>
                        <td class="client-pm">{{moment(log.created_at).fromNow()}}</td>
                    </tr>
                </tbody>
            </table>
        </div>


        <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create new Log</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                            <input type="hidden" name="_token" :value="csrf">

                            <input v-model="log.title" name="website" type="text" id="website" class="form-control" placeholder="Log Title"><br>

                            <select v-model="log.domain_id" id="type" class="form-control" name="type"><br>
                                <option value="" disabled selected>Website</option>
                                <option value="1">aerogen.com</option>
                                <option value="4">ardsolus.ie</option>
                                <option value="8">blacklionrealstate.fund</option>
                                <option value="11">blanchadstowncentre.ie</option>
                                <option value="7">chathamandking.ie</option>
                                <option value="5">clayfarm.ie</option>
                                <option value="10">edenplaza.ie</option>
                                <option value="6">hardwicke.ie</option>
                                <option value="2">kennedywilsonresidential.ie</option>
                                <option value="3">loulerie.ie</option>                              
                                <option value="9">procert.ie</option>  
                            </select>

                            <br>

                            <select v-model="log.type" id="type" class="form-control" name="type"><br>
                                <option value="" disabled selected>Type</option>
                                <option>Client Update</option>
                                <option>Dev Update</option>
                                <option>Bug</option>
                                <option>Style Fix</option>
                            </select>

                            <br>

                            <label class="left" for="description">Log Description:</label>
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
import moment from 'moment';

    export default {

        name:'Log',

        data(){
            return {
                checked:false,
                logs: [],
                log: {domain_id:'', title: '', type: '', description: ''},
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                errors:{}
            }
        },

        methods:{

            getLogs(){
                window.axios.get('/develogger-app/public/api/logs').then(({data})=>{
                    data.forEach(log =>{
                        this.logs.push(log)
                    });
                });
            },

            moment,

            save(){
                
                if(this.log.title.length > 0 && this.log.domain_id.length > 0 && this.log.type.length > 0 && this.log.description.length > 0){

                    window.axios.post('/develogger-app/public/api/logs',this.log).then((response) => {
                        this.logs.push(response.data)
                        this.log.domain_id = '';
                        this.log.title = '';
                        this.log.type = '';
                        this.log.description = '';
                        this.checked = false;
                    
                    }).catch((error) => this.errors = error.response.data.errors)

                }
                
            },
            
        },

        created(){
            this.getLogs();
        },

        computed: {
            isComplete () {
                return this.log.title && this.log.domain_id && this.log.type && this.log.description;
            }
        }
        
    }


    
</script>


