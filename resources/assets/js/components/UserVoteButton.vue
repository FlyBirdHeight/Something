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
        props:['answer','count'],
        mounted() {
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
                return this.count;
            }
        },
        methods: {
            vote() {
                axios.post('/api/user/vote',{'answer':this.answer}).then(response => {
//                    console.log(response.data);
                    this.voted = response.data.voted;
                    this.count = response.data.count;
                })
            }
        }
    }
</script>
