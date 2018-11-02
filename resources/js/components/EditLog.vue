<template>
    <div class="container">
        <div id="overlay">
            <div class="edit-detail-window">
                <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLongTitle">{{logTitle}}</h3>
                        <button type="button" class="close">
                        <i class="fas fa-times" @click="close"></i>
                        </button>
                </div>
                <div id="show-detail-modal-body" class="modal-body">
                    <br>
                    <label>Title:</label>
                    <input class="form-control" type="text" v-model="logTitle">

                    <br>
                    <label>Type:</label>
                    <select v-model="logType" class="form-control" ><br>
                            <option value="" disabled selected>Type</option>
                            <option>Client Update</option>
                            <option>Dev Update</option>
                            <option>Bug</option>
                            <option>Style Fix</option>
                    </select>

                    <br>
                    <label>Description:</label>
                    <textarea class="form-control" cols="30" rows="5" v-model="logDescription"></textarea>
                    
                </div>
                <div class="modal-footer">
                    <button d="log-it" type="button" class="btn btn-circle btn-xl" @click="update(logTitle, logType, logDescription)">
                        <span><b>EDIT</b></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

import axios from 'axios';

export default {

    name:'EditLog',

    props:['logId','logUser','logTitle','logType','logDescription','logDate'],

    data(){
        return{
            log:{title:'',type:'',description:''},
            errors:{}
        }
    },

    methods:{

        close(){
			this.$emit('closeRequest');
        },

        update(title,type,description){

            this.log.title = title;
            this.log.type = type;
            this.log.description - description;
            
            window.axios.patch(`/develogger-app/public/api/logs/${this.logId}`,this.$data.log).then((response)=> this.close())
                    .catch((error) => this.errors = error.response.data.errors)

        }

    }
}
</script>

