<template>
    <div class="container">

        <log-show-detail v-if="logModalOpen" :logUser="logUser" :logTitle="logTitle" :logType="logType" :logDescription="logDescription" :logDate="logDate" @closeRequest='close'> </log-show-detail>

        <log-edit v-if="editModalOpen" :logId="logId" :logUser="logUser" :logTitle="logTitle" :logType="logType" :logDescription="logDescription" :logDate="logDate" @closeRequest='close'></log-edit>

        <div class="form-group">
                <!-- <input type="text" class="form-control" id="filter" placeholder="Filter the Logs"> -->
                <br>
                <i class="fas fa-plus jobs-page" data-toggle="modal" data-target="#exampleModalCenter"></i>
                <div v-if="isLoading" class="loading-image">
                    <img src="/develogger-app/public/img/dev-tick.gif" alt="">
                </div>
        </div>

        <div class="row content-holder">
            <table class="table">
                <thead>
                    <tr class="left-align">
                        <th class="">Log</th>
                        <th class="">User</th>
                        <th class="center-align" style="text-align:right">Date</th>

                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="log in logs" :key="log.id" :log="log" @deleteLog="deleteLog" class="tr-table">
                        <td class="client-name" @click="openLogs(log.id,log.user,log.title,log.type,log.description,log.created_at)">{{ log.title }}</td>
                        <td class="" >{{ log.user }}</td>
                        <td class="client-pm" style="text-align:right">{{moment(log.created_at).fromNow()}}</td>
                        <!-- <td @click="openEdit(log.id,log.user,log.title,log.type,log.description,log.created_at)"><i class="fas fa-edit"></i></td> -->
                        <td @click="deleteLog(key,log.id)"><i class="fas fa-trash-alt"></i></td>
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
import ShowDetail from './ShowDetail.vue';
import EditLog from './EditLog.vue';

    export default {

        key:'',
        
        name:'Log',

        data(){
            return {
                logModalOpen: false,
                editModalOpen: false,
                isLoading:'',
                checked:false,
                logs: [],
                log: {id:'', domain_id:'', title: '', type: '', description: ''},
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                errors:{},

                //passing those variables to ShowDetails component
                logId:'',
                logUser:'',
                logTitle:'',
                logType:'',
                logDescription:'',
                logDate:'',
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
                this.isLoading = true;
                if(this.log.title.length > 0 && this.log.domain_id.length > 0 && this.log.type.length > 0 && this.log.description.length > 0){

                    window.axios.post('/develogger-app/public/api/logs',this.log).then((response) => {
                        this.logs.push(response.data)
                        this.log.domain_id = '';
                        this.log.title = '';
                        this.log.type = '';
                        this.log.description = '';
                        this.checked = false;

                        setTimeout(() => {
                            this.isLoading = false;
                        }, 800);
                    
                    }).catch((error) => this.errors = error.response.data.errors)

                }
                
            },

            openLogs(id,user,title,type,description,date){
                this.logId = id;
                this.logUser = user;
                this.logTitle = title;
                this.logType = type;
                this.logDescription = description;
                this.logDate = date;
                this.logModalOpen = true;
            },

            openEdit(id,user,title,type,description,date){
                this.logId = id;
                this.logUser = user;
                this.logTitle = title;
                this.logType = type;
                this.logDescription = description;
                this.logDate = date;
                this.editModalOpen = true;
            },

            close(){
                this.logModalOpen = false;
                this.editModalOpen = false;
            },

            deleteLog(key,id){

                if(confirm("Are you sure you want to delete?")){
                    this.isLoading = true;

                    window.axios.delete(`/develogger-app/public/api/logs/${id}`,this.log).then((response) => {
                            this.logs.push(response.data)
                            this.logs.splice(key,1);

                            setTimeout(() => {
                                this.isLoading = false;
                            }, 800);

                            this.logId = '';
                        
                        }).catch((error) => this.errors = error.response.data.errors)
                }
                    
            }
            
        },

        created(){
            this.getLogs();
        },

        computed: {
            isComplete () {
                return this.log.title && this.log.domain_id && this.log.type && this.log.description;
            }
        },

        components:{
            'log-show-detail': ShowDetail,
            'log-edit': EditLog,
        }
        
    }


    
</script>


