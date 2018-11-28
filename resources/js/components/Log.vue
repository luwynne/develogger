<template>
    <div class="container">

        <log-show-detail v-if="logModalOpen" :logUser="logUser" :logTitle="logTitle" :logType="logType" :logDescription="logDescription" :logDate="logDate" @closeRequest='close'> </log-show-detail>

        <div class="form-group">
                <!-- <input type="text" class="form-control" id="filter" placeholder="Filter the Logs"> -->
                <br>
                <p>New Log</p>&nbsp;<router-link v-bind:to="{name: 'AddLog'}"><i class="fas fa-plus jobs-page" data-toggle="modal" data-target="#exampleModalCenter"></i></router-link>
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
                        <th class="">Domain</th>
                        <th class="center-align" style="text-align:right">Date</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="log in logs" :key="log.id" :log="log" @deleteLog="deleteLog" class="tr-table">
                        <td class="client-name" @click="openLogs(log.id,log.user,log.title,log.type,log.description,log.created_at)">{{ log.title }}</td>
                        <td class="" >{{ log.user }}</td>
                        <td class="">{{ log.domain.url }}</td>
                        <td class="client-pm" style="text-align:right">{{moment(log.created_at).fromNow()}}</td>
                        <td><router-link v-bind:to="{name: 'EditLog', params: {id: log.id}}"><i class="fas fa-edit"></i></router-link></td>
                        <td @click="deleteLog(key,log.id)"><i class="fas fa-trash-alt"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>

import axios from 'axios';
import moment from 'moment';
import ShowDetail from './ShowDetail.vue';
import EditLog from './EditLog.vue';
import AddLog from './AddLog.vue';


    export default {

        name:'Log',

        data(){
            return {
                key:0,
                logModalOpen: false,
                editModalOpen: false,
                isLoading:'',
                logs: [],
                log: {id:'', domain_id:'', title: '', type: '', description: ''},
                domains:[],
                domain:{url:'', id:'', url:'', client:''},
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

            getLogs(){ //gets all the logs as soon as the component is loaded
                window.axios.get('/develogger-app/public/api/logs').then(({data})=>{
                    data.forEach(log =>{
                        this.logs.push(log)
                    });
                });
            },

            moment,


            openLogs(id,user,title,type,description,date){ //open log information
                this.logId = id;
                this.logUser = user;
                this.logTitle = title;
                this.logType = type;
                this.logDescription = description;
                this.logDate = date;
                this.logModalOpen = true;
            },


            close(){ //closes modal
                this.logModalOpen = false;
                this.editModalOpen = false;
            },

            deleteLog(key,id){ //this deletes the log

                if(confirm("Are you sure you want to delete?")){
                    this.isLoading = true;

                    window.axios.delete(`/develogger-app/public/api/logs/${id}`,this.log).then((response) => {
                            this.logs.splice(key,1);

                            setTimeout(() => {
                                this.isLoading = false;
                            }, 800);

                            this.logId = '';
                        
                        }).catch((error) => this.errors = error.response.data.errors)
                }
                    
            },

            getAllDomains(){ //this function brings the domains to the select drop down list in order to create a new log as soon as the component is loaded
                window.axios.get('/develogger-app/public/api/domains').then(({data})=>{
                    data.forEach(domain =>{
                        this.domains.push(domain)
                    });
                });
            }
            
        },

        created(){ //load those functions as soon as the component is loaded
            this.getLogs();
            this.getAllDomains();
        },

        computed: { //processing real live. This is used to validate the modal that creates a new log
            isComplete () {
                return this.log.title && this.log.domain_id && this.log.type && this.log.description;
            }
        },

        components:{
            'log-show-detail': ShowDetail,
            EditLog,
            AddLog
        }
        
    }


    
</script>


