<template>
    <div class="container">
        <div id="overlay">
            <div class="log-detail-window">
                <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{logTitle}}</h5>
                        <button type="button" class="close">
                        <i class="fas fa-times" @click="close"></i>
                        </button>
                </div>
                <div id="show-detail-modal-body" class="modal-body">
                    <small>by {{logUser}} {{moment(logDate).fromNow()}}</small>
                    <br><br>
                    <p>Type: {{logType}}</p>
                    <p>Description: {{logDescription}}</p>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

import moment from 'moment';

export default {

    name:'ShowDetail',

    props:['logUser','logTitle','logType','logDescription','logDate'],

    data(){
        return{
            
        }
    },

    methods:{

        close(){
			this.$emit('closeRequest');
        },
        
        moment,

    }
}
</script>

