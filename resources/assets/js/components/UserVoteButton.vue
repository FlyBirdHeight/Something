<template>
    <button
            class="btn btn-default"
            v-text="text"
            v-on:click="vote"
            v-bind:class="{'btn-primary': voted}"
    ></button>
</template>

<script>
    export default{
        props:['answer'],
        mounted() {
//            axios.get('/api/user/votes/'+this.answer).then(response => {
//               this.voted = response.data.voted;
//            })
            console.log(this.answer);
            axios.post('/api/user/votes/'+this.answer).then(response => {
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
            vote() {
                axios.post('/api/user/vote',{'answer':this.answer}).then(response => {
                    this.voted = response.data.voted;
                })
            }
        }
    }
</script>
