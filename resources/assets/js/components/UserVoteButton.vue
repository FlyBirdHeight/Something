<template>
    <button
            class="btn btn-default pull-left"
            v-text="text"
            v-on:click="follow"
            v-bind:class="{'btn-success': followed}"
    ></button>
</template>

<script>
    export default{
        props:['answer'],
        mounted() {
            axios.get('/api/user/votes/'+this.answer).then(response => {
               this.voted = response.data.voted;
            })
        },
        data() {
            return {
                voted: true
            }
        },
        computed: {
            text() {
                return this.voted ? '已点赞' : '点赞'
            }
        },
        methods: {
            follow() {
                 axios.post('/api/user/vote',{'answer':answer}).then(response => {
                    //console.log(response);
                    this.voted = response.data.voted;
                })
            }
        }
    }
</script>
