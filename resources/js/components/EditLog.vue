<template>
    <div class="container">
        <div id="overlay">
            <div class="edit-detail-window">
               <form v-on:submit.prevent = "updatePost">   
                    <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLongTitle">{{log.title}}</h3>
                            <button type="button" class="close">
                            <router-link :to="'/Log'"><i class="fas inner-fas fa-times"></i></router-link>
                            </button>
                    </div>
                    <div id="show-detail-modal-body" class="modal-body">
                        <br>
                        <label>Title:</label>
                        <input class="form-control" type="text" v-model="log.title">

                        <br>
                        <label>Type:</label>
                        <select v-model="log.type" class="form-control" ><br>
                                <option value="" disabled selected>Type</option>
                                <option>Client Update</option>
                                <option>Dev Update</option>
                                <option>Bug Fix</option>
                                <option>Style Fix</option>
                                <option>New Website</option>
                        </select>

                        <br>
                        <label>Description:</label>
                        <textarea class="form-control" cols="30" rows="5" v-model="log.description"></textarea>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="log-it" class="btn btn-circle btn-xl">
                            <span><b>EDIT</b></span>
                        </button>
                    </div>
              </form>  
            </div>
        </div>
    </div>
</template>


<script>

import Axios from 'axios';
import Log from './Log.vue';

export default {

    name:'EditLog',

    data(){
        return{
            log:{domain_id:'', user:'', title:'',type:'',description:''},
        }
    },

    methods:{

       updatePost: function() {
        //patch method will be handle on the update function
            let uri = 'edit-log/'+this.$route.params.id;
            Axios.patch(uri, this.log).then((response) => {
                this.$router.push('/Log');
            })
        }

    },

    created: function(){
            //will get the edit function
            let uri = 'edit-log/'+this.$route.params.id+'/edit';
                Axios.get(uri).then((response) => {
                this.log = response.data;
            });
    },

}
</script>

